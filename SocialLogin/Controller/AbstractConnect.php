<?php

namespace Magenest\SocialLogin\Controller;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Session\SessionManagerInterface;

/**
 * Class AbstractConnect
 * @package Magenest\SocialLogin\Controller
 */
abstract class AbstractConnect extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magenest\SocialLogin\Helper\SocialLogin
     */
    protected $_helper;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var string
     */
    protected $clientModel;

    /**
     * @var string
     */
    protected $_type;

    /**
     * @var string
     */
    protected $_path;

    /**
     * @var string
     */
    protected $_exeptionMessage;

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $socialSession;

    /**
     * AbstractConnect constructor.
     * @param \Magento\Framework\Session\SessionManagerInterface $socialSession
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magenest\SocialLogin\Helper\SocialLogin $helper
     * @param \Magento\Framework\Session\SessionManagerInterface $sessionManager
     */
    public function __construct(
        \Magento\Framework\Session\SessionManagerInterface $socialSession,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magenest\SocialLogin\Helper\SocialLogin $helper,
        SessionManagerInterface $sessionManager
    ) {
        $this->socialSession = $socialSession;
        $this->_customerSession = $customerSession;
        $this->_helper = $helper;
        $this->sessionManager = $sessionManager;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $this->connect();
        } catch (\Exception $e) {
            $this->_exeptionMessage = $e->getMessage();
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sociallogin/checklogin/index');
        return $resultRedirect;
    }

    /**
     * @throws LocalizedException
     * @throws \Exception
     */
    public function connect()
    {
        $error = $this->getRequest()->getParam('error');
        $code = $this->getRequest()->getParam('code') ?? $this->getRequest()->getParam('oauth_token');
        $state = $this->getRequest()->getParam('state');
        $accessToken = $this->getRequest()->getParam('access_token');

        if (!(isset($error) || isset($code)) && !isset($state)) {
            throw new LocalizedException(__('Something went wrong, please try again later'));
        }

        $client = $this->_objectManager->create($this->clientModel);
        if (isset($accessToken)) {
            $client->setAccessToken($accessToken);
        }

        if ($code) {
            $userInfo = $this->getUserInfo($client, $code);
            if (!isset($userInfo['email'])) {
                $userInfo['exist_email'] = 0;
            } else {
                $userInfo['exist_email'] = 1;
            }
            $userInfo['type'] = $this->_type;
            $customer = $this->_helper->getCustomer($userInfo['id'], $this->_type);
            if (!$this->_customerSession->isLoggedIn()) {
                // connect social to existed account
                $state = empty($state) ? null : json_decode($state, true);
                if (!empty($state['customer_id'])) {
                    if ($customer->getId()) {
                        throw new LocalizedException(__('Your social account have connected to another account.'));
                    }
                    $this->connectSocial($userInfo, $state['customer_id']);
                    $this->messageManager->addSuccessMessage(__('You have connected to your social account.'));
                    return;
                }

                // normal login
                if ($customer->getId()) {
                    if($this->_type == "apple" && !isset($userInfo['is_private_email'])){
                        if ($userInfo['email'] != $customer->getEmail() && isset($userInfo['email_verified'])) {
                            $customer->setEmail($userInfo['email']);
                            $customer->save();
                        }
                    }

                    $this->_customerSession->setCustomerAsLoggedIn($customer);
                    $this->_helper->updateLastLoginTime($userInfo);
                    $this->socialSession->setSocialType($userInfo['type'] ?? '');
                    return;
                }

                /**
                 * If don't exist customer, create new customer with this information
                 *
                 */
                $userInfo['email'] =  $userInfo['email'] ?? $this->generateEmail($userInfo['name']);
                $data = $this->getDataNeedSave($userInfo);
                $this->beforeCreateCustomer($data);
                $this->_helper->creatingAccount($data);
                $this->_helper->createSocialAccount($userInfo);
                $this->socialSession->setSocialType($userInfo['type'] ?? '');
            } else {
                if ($customer->getId()) {
                    throw new LocalizedException(__('Your social account have connected to another account.'));
                }
                $this->_helper->createSocialAccount($userInfo);
                $this->messageManager->addSuccessMessage(__('You have connected to your %1 account.',$this->_type));
            }
        }
    }

    /**
     * @param $str
     * @return string
     */
    private function generateEmail($str)
    {
        $str = strtolower($str);
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/[\(\)+]+/", '', $str);
        $str = preg_replace("/[^0-9a-zA-Z-]+/", '', $str);
        $str = preg_replace("/[-]+/", '', $str);
        $str = preg_replace("/\-+$/", '', $str);
        return $str . "@" . $this->_type . ".com";
    }

    /**
     * Save Information
     *
     * @param $userInfo
     * @return array
     */
    public function getDataNeedSave($userInfo)
    {
        return [
            'sendemail' => 0,
            'confirmation' => 0,
            'magenest_sociallogin_id' => $userInfo['id'],
            'magenest_sociallogin_type' => $this->_type
        ];
    }

    /**
     * Save user info to session
     * @param $data
     */
    protected function beforeCreateCustomer($data)
    {
        $this->sessionManager->setUserData($data);
    }

    /**
     * @param $client
     * @param $code
     */
    public function getUserInfo($client, $code)
    {
    }

    /**
     * @param $userInfo
     * @param $customerId
     * @throws \Exception
     */
    protected function connectSocial($userInfo, $customerId)
    {
        $this->_helper->connectSocialToExistedAccount($customerId, $userInfo['id'], $this->_type);
    }
}
