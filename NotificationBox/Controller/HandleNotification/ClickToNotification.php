<?php
namespace Magenest\NotificationBox\Controller\HandleNotification;

use Magenest\NotificationBox\Helper\Helper;
use Magenest\NotificationBox\Model\NotificationFactory;
use Magenest\NotificationBox\Model\ResourceModel\Notification;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magenest\NotificationBox\Logger\Logger;

class ClickToNotification extends Action
{
    /** @var Helper  */
    protected $helper;

    /** @var NotificationFactory  */
    protected $notificationFactory;

    /** @var Notification  */
    protected $notificationResource;

    /** @var Logger  */
    protected $logger;

    /**
     * Construct
     *
     * @param Context $context
     * @param Helper $helper
     * @param NotificationFactory $notificationFactory
     * @param Notification $notificationResource
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        Helper $helper,
        NotificationFactory $notificationFactory,
        Notification $notificationResource,
        Logger $logger
    ) {
        $this->logger              = $logger;
        $this->notificationResource         = $notificationResource;
        $this->notificationFactory          = $notificationFactory;
        $this->helper                       = $helper;
        parent::__construct($context);
    }
    /**
     * Update field notification
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();
        if (isset($params['impression'])) {
            $type = 'UpdateImpression';
            $notificationId = $params['impression'];
        }
        if (isset($params['notificationId'])) {
            $type = 'updateTotalClick';
            $notificationId = $params['notificationId'];
        }
        $redirectUrl = (isset($params['url'])) ? $params['url'] : null;
        if (isset($notificationId)) {
            $this->updateData($type, $notificationId);
        }
        if (isset($redirectUrl)) {
            $resultRedirect->setUrl($params['url']);
        } else {
            $resultRedirect->setPath("");
        }
        return $resultRedirect;
    }

    /**
     * Update field notification
     *
     * @param string $type
     * @param string $notificationId
     */
    private function updateData($type, $notificationId)
    {
        try {
            $notificationModel = $this->notificationFactory->create();
            $this->notificationResource->load($notificationModel, $notificationId);
            if ($type == 'UpdateImpression') {
                $notificationModel->setData('impression', $notificationModel->getImpression()+1);
            } elseif ($type == 'updateTotalClick') {
                $notificationModel->setData('total_click', $notificationModel->getTotalClick()+1);
            }
            $this->notificationResource->save($notificationModel);
        } catch (\Exception $exception) {
            $this->logger->error('update fail: ' . $exception->getMessage());
        }
    }
}
