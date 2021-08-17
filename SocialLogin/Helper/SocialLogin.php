<?php

namespace Magenest\SocialLogin\Helper;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Config\Model\Config;
use Magento\Backend\App\ConfigInterface;

/**
 * Class SocialLogin
 * @package Magenest\SocialLogin\Helper
 */
class SocialLogin extends AbstractHelper
{
    /**
     *
     */
    const REFERER_STORE_PARAM_NAME = 'sociallogin_referer_store';

    /**
     *
     */
    const XML_PATH_ENABLE_MODAL = 'magenest/general/enabled_social_enabled_modal';
    /**
     *
     */
    const XML_PATH_DISPLAY_ON = 'magenest/general/display_on';

    /**
     * @var SessionFactory
     */
    protected $_customerSession;
    /**
     * @var CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var Config
     */
    protected $_config;

    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface
     */
    protected $cookieManager;

    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $customerUrl;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer
     */
    protected $customerResource;

    /**
     * @var \Magenest\SocialLogin\Model\ResourceModel\SocialAccount\CollectionFactory
     */
    protected $socialAccountCollection;

    /**
     * @var \Magenest\SocialLogin\Model\SocialAccountFactory
     */
    protected $socialAccountModel;

    /**
     * @var \Magenest\SocialLogin\Model\ResourceModel\SocialAccount
     */
    protected $socialAccountResource;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;
    /**
     * @var \Magenest\SocialLogin\Model\Line\Client
     */
    protected $clientLine;
    /**
     * @var \Magenest\SocialLogin\Model\Zalo\Client
     */
    protected $clientZalo;
    /**
     * @var \Magenest\SocialLogin\Model\Apple\Client
     */
    protected $clientApple;
    /**
     * @var \Magenest\SocialLogin\Model\Amazon\Client
     */
    protected $clientAmazon;
    /**
     * @var \Magenest\SocialLogin\Model\Google\Client
     */
    protected $clientGoogle;
    /**
     * @var \Magenest\SocialLogin\Model\Reddit\Client
     */
    protected $clientReddit;
    /**
     * @var \Magenest\SocialLogin\Model\Twitter\Client
     */
    protected $clientTwitter;
    /**
     * @var \Magenest\SocialLogin\Model\Facebook\Client
     */
    protected $clientFacebook;
    /**
     * @var \Magenest\SocialLogin\Model\Linkedin\Client
     */
    protected $clientLinkedin;
    /**
     * @var \Magenest\SocialLogin\Model\Instagram\Client
     */
    protected $clientInstagram;
    /**
     * @var \Magenest\SocialLogin\Model\Pinterest\Client
     */
    protected $clientPinterest;
    /**
     * @var array
     */
    protected $clients = [];

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * SocialLogin constructor.
     * @param \Magenest\SocialLogin\Model\Line\Client $clientLine
     * @param \Magenest\SocialLogin\Model\Zalo\Client $clientZalo
     * @param \Magenest\SocialLogin\Model\Apple\Client $clientApple
     * @param \Magenest\SocialLogin\Model\Amazon\Client $clientAmazon
     * @param \Magenest\SocialLogin\Model\Google\Client $clientGoogle
     * @param \Magenest\SocialLogin\Model\Reddit\Client $clientReddit
     * @param \Magenest\SocialLogin\Model\Twitter\Client $clientTwitter
     * @param \Magenest\SocialLogin\Model\Facebook\Client $clientFacebook
     * @param \Magenest\SocialLogin\Model\Linkedin\Client $clientLinkedin
     * @param \Magenest\SocialLogin\Model\Instagram\Client $clientInstagram
     * @param \Magenest\SocialLogin\Model\Pinterest\Client $clientPinterest
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\App\ConfigInterface $config
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param \Magento\Customer\Model\ResourceModel\Customer $customerResource
     * @param \Magenest\SocialLogin\Model\ResourceModel\SocialAccount\CollectionFactory $socialAccountCollection
     * @param \Magenest\SocialLogin\Model\SocialAccountFactory $socialAccountModel
     * @param \Magenest\SocialLogin\Model\ResourceModel\SocialAccount $socialAccountResource
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        \Magenest\SocialLogin\Model\Line\Client $clientLine,
        \Magenest\SocialLogin\Model\Zalo\Client $clientZalo,
        \Magenest\SocialLogin\Model\Apple\Client $clientApple,
        \Magenest\SocialLogin\Model\Amazon\Client $clientAmazon,
        \Magenest\SocialLogin\Model\Google\Client $clientGoogle,
        \Magenest\SocialLogin\Model\Reddit\Client $clientReddit,
        \Magenest\SocialLogin\Model\Twitter\Client $clientTwitter,
        \Magenest\SocialLogin\Model\Facebook\Client $clientFacebook,
        \Magenest\SocialLogin\Model\Linkedin\Client $clientLinkedin,
        \Magenest\SocialLogin\Model\Instagram\Client $clientInstagram,
        \Magenest\SocialLogin\Model\Pinterest\Client $clientPinterest,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        SessionFactory $customerSession,
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        ConfigInterface $config,
        Context $context,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Customer\Model\Url $customerUrl,
        \Magento\Customer\Model\ResourceModel\Customer $customerResource,
        \Magenest\SocialLogin\Model\ResourceModel\SocialAccount\CollectionFactory $socialAccountCollection,
        \Magenest\SocialLogin\Model\SocialAccountFactory $socialAccountModel,
        \Magenest\SocialLogin\Model\ResourceModel\SocialAccount $socialAccountResource,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->customerRepository      = $customerRepository;
        $this->clientAmazon            = $clientAmazon;
        $this->clientApple             = $clientApple;
        $this->clientFacebook          = $clientFacebook;
        $this->clientGoogle            = $clientGoogle;
        $this->clientInstagram         = $clientInstagram;
        $this->clientLine              = $clientLine;
        $this->clientLinkedin          = $clientLinkedin;
        $this->clientPinterest         = $clientPinterest;
        $this->clientReddit            = $clientReddit;
        $this->clientTwitter           = $clientTwitter;
        $this->clientZalo              = $clientZalo;
        $this->clients                 = [
            $clientAmazon,
            $clientApple,
            $clientFacebook,
            $clientGoogle,
            $clientInstagram,
            $clientLine,
            $clientLinkedin,
            $clientPinterest,
            $clientReddit,
            $clientTwitter,
            $clientZalo
        ];
        $this->_config                 = $config;
        $this->_customerSession        = $customerSession->create();
        $this->_customerFactory        = $customerFactory;
        $this->_storeManager           = $storeManager;
        $this->cookieManager           = $cookieManager;
        $this->customerUrl             = $customerUrl;
        $this->customerResource        = $customerResource;
        $this->socialAccountCollection = $socialAccountCollection;
        $this->socialAccountModel      = $socialAccountModel;
        $this->socialAccountResource   = $socialAccountResource;
        $this->timezone                = $timezone;
        parent::__construct($context);
    }

    /**
     * Login and save with customer email
     *
     * @param \Magento\Customer\Model\Customer $customer
     * @param array $data
     */
    public function login($customer, $data)
    {
        $dataModel = $customer->getDataModel();
        $dataModel->setCustomAttribute('magenest_sociallogin_id', $data['magenest_sociallogin_id']);
        $dataModel->setCustomAttribute('magenest_sociallogin_type', $data['magenest_sociallogin_type']);
        $customer->updateData($dataModel)->save();
        $this->_customerSession->setCustomerAsLoggedIn($customer);
    }

    /**
     * Create new Customer
     *
     * @param array $data
     */
    public function creatingAccount($data)
    {
        $customer = $this->_customerFactory->create();
        try {
            $customerId = $this->customerRepository->get($data['email'])->getId();
            $this->customerResource->load($customer,$customerId);
            $this->_customerSession->setCustomerAsLoggedIn($customer);
        } catch (\Exception $exception) {
            $customer->setData($data);
            $this->customerResource->save($customer);
            $this->_customerSession->setCustomerAsLoggedIn($customer);
        }
    }

    /**
     * @param $data
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function createSocialAccount($data)
    {
        $currentDateTime = $this->timezone->date()->format('Y-m-d H:i:s');
        $socialAccount = $this->socialAccountModel->create();
        $socialAccount->setCustomerId($this->_customerSession->getCustomerId());
        $socialAccount->setSocialLoginId($data['id'] ?? null);
        $socialAccount->setSocialLoginType($data['type'] ?? null);
        $socialAccount->setCreatedAt($currentDateTime);
        $socialAccount->setLastLogin($currentDateTime);
        $socialAccount->setSocialEmail($data['email'] ?? null);
        $socialAccount->setExistEmail($data['exist_email'] ?? null);
        $this->socialAccountResource->save($socialAccount);
    }

    /**
     * @param $data
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function updateLastLoginTime($data) {
        $socialAccountCollection = $this->socialAccountCollection->create()->addFieldToFilter('social_login_id',$data['id'])
                                                                           ->addFieldToFilter('social_login_type',$data['type']);
        $socialAccount = $socialAccountCollection->getFirstItem();
        $socialAccount->setLastLogin($this->timezone->date()->format('Y-m-d H:i:s'));
        $socialAccount->setExistEmail($data['exist_email'] ?? null);
        $this->socialAccountResource->save($socialAccount);
    }

    /**
     * @param $socialLoginId
     * @param $socialLoginType
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer($socialLoginId, $socialLoginType)
    {
        $socialAccountCollection = $this->socialAccountCollection->create()
                                                                 ->addFieldToFilter('social_login_id',$socialLoginId)
                                                                 ->addFieldToFilter('social_login_type',$socialLoginType);
        $customer = $this->_customerFactory->create();
        $this->customerResource->load($customer,$socialAccountCollection->getFirstItem()->getCustomerId());
        return $customer;
    }

    /**
     * Get Customer By Email
     *
     * @param $email
     * @return \Magento\Customer\Model\Customer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomerByEmail($email)
    {
        $websiteId = $this->_storeManager->getWebsite()->getId();
        $customer  = $this->_customerFactory->create()->setWebsiteId($websiteId)->loadByEmail($email);
        return $customer;
    }

    /**
     * @return Bool
     */
    public function isLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }

    /**
     * @return Bool
     */
    public function isButtonEnabledCreateAccount()
    {
        $displayOn = explode(',',$this->_config->getValue(self::XML_PATH_DISPLAY_ON));
        return in_array(\Magenest\SocialLogin\Model\Config\DisplayOn::CREATE_ACCOUNT_PAGE,$displayOn);
    }

    /**
     * @return Bool
     */
    public function isButtonEnabledCheckout()
    {
        $displayOn = explode(',',$this->_config->getValue(self::XML_PATH_DISPLAY_ON));
        return in_array(\Magenest\SocialLogin\Model\Config\DisplayOn::CHECKOUT_PAGE,$displayOn);
    }

    /**
     * @return Bool
     */
    public function isButtonEnabledCommentProduct()
    {
        $displayOn = explode(',',$this->_config->getValue(self::XML_PATH_DISPLAY_ON));
        return in_array(\Magenest\SocialLogin\Model\Config\DisplayOn::COMMENT_PRODUCT,$displayOn);
    }

    /**
     * @return Bool
     */
    public function isButtonEnabledModal()
    {
        return (bool)$this->_config->getValue(self::XML_PATH_ENABLE_MODAL);
    }

    /**
     * @param $email
     * @return String
     */
    public function getTypeByEmail($email)
    {
        $customer = $this->getCustomerByEmail($email);
        return $customer['magenest_sociallogin_type'];
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        $cookieRedirect = $this->cookieManager->getCookie(self::REFERER_STORE_PARAM_NAME);
        return $cookieRedirect ?? $this->customerUrl->getDashboardUrl();
    }

    /**
     * @return string[]
     */
    public function getAllSocialTypes(): array
    {
        $allSocialTypes = [];
        foreach ($this->clients as $client) {
            if ($client->isEnabled()) {
                $allSocialTypes[] = $client::TYPE_SOCIAL_LOGIN;
            }
        }
        return  $allSocialTypes;
    }

    /**
     * @return array
     */
    public function getAllTypesNotCheckEnable(): array
    {
        $allSocialTypes = [];
        foreach ($this->clients as $client) {
            $allSocialTypes[] = $client::TYPE_SOCIAL_LOGIN;
        }
        return  $allSocialTypes;
    }

    /**
     * @return array
     */
    public function getChartColor(): array
    {
        $chartColor = [];
        foreach ($this->clients as $client) {
            $chartColor[$client::TYPE_SOCIAL_LOGIN] = $client::CHART_COLOR;
        }
        return $chartColor;
    }
}
