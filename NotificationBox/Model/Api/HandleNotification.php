<?php

namespace Magenest\NotificationBox\Model\Api;

use Magenest\NotificationBox\Api\HandleNotificationInterface;
use \Magenest\NotificationBox\Helper\Helper;
use Magenest\NotificationBox\Model\CustomerNotification as CustomerNotificationModel;
use Magenest\NotificationBox\Model\CustomerNotificationFactory;
use Magenest\NotificationBox\Model\ResourceModel\CustomerNotification;
use Magenest\NotificationBox\Model\ResourceModel\CustomerNotification\CollectionFactory;
use Magenest\NotificationBox\Logger\Logger;

class HandleNotification implements HandleNotificationInterface
{
    /** @var Helper */
    public $helper;

    /** @var CustomerNotificationFactory  */
    public $notificationModel;

    /** @var CustomerNotification  */
    public $notificationResource;

    /** @var CollectionFactory */
    public $notificationCollection;

    /** @var Logger  */
    public $logger;

    /**
     * Construct
     *
     * @param Helper $helper
     * @param CustomerNotificationFactory $notificationFactory
     * @param CustomerNotification $notificationResource
     * @param CollectionFactory $notificationCollection
     * @param Logger $logger
     */
    public function __construct(
        Helper $helper,
        CustomerNotificationFactory
        $notificationFactory,
        CustomerNotification $notificationResource,
        CollectionFactory $notificationCollection,
        Logger $logger
    ) {
        $this->logger = $logger;
        $this->helper = $helper;
        $this->notificationModel = $notificationFactory;
        $this->notificationResource = $notificationResource;
        $this->notificationCollection = $notificationCollection;
    }

    /**
     * Delete notifications
     *
     * @param int $customerId
     * @param string $notificationId
     * @return array
     */
    public function deleteNotifications($customerId, $notificationId)
    {
        $data = [];
        if ($notificationId=="" && strtolower($notificationId)!="all") {
            $data[] = [
                'status'=>false,
                'message'=>__('Invalid notification id(s)')
            ];
        } else {
            $notificationCollection = $this->getCollection($customerId, $notificationId);
            if ($notificationCollection->getSize() == 0) {
                $data[] = [
                    'status'=>false,
                    'message'=>__('Notification(s) cannot be found according to the input condition')
                ];
            } else {
                foreach ($notificationCollection as $notification) {
                    try {
                        $this->notificationResource->delete($notification);
                    } catch (\Exception $exception) {
                        $this->logger->error($exception->getMessage());
                        return $data[] = [
                            'status'=>false,
                            'message'=>$exception->getMessage()
                        ];
                    }
                }
                $data[] = [
                    'status'=>true,
                    'message'=>__('Delete notification(s) success')
                ];
            }
        }
        return $data;
    }

    /**
     * Mark as read notifications
     *
     * @param int $customerId
     * @param string $notificationId
     * @return array
     */
    public function markAsRead($customerId, $notificationId)
    {
        return $this->updateNotification($customerId, $notificationId, 'status', 1);
    }

    /**
     * Mark important notifications
     *
     * @param string $customerId
     * @param string $notificationId
     * @param int $status
     */
    public function markImportant($customerId, $notificationId, $status)
    {
        return $this->updateNotification($customerId, $notificationId, 'star', $status);
    }

    /**
     * Update notification
     *
     * @param string $customerId
     * @param string $notificationId
     * @param string $column
     * @param int $status
     */
    public function updateNotification($customerId, $notificationId, $column, $status)
    {
        $data = [];
        if ($notificationId=="") {
            $data[] = [
                'status'=>false,
                'message'=>__('Notification(s) cannot be found according to the input condition')
            ];
        } else {
            try {
                $notificationCollection = $this->getCollection($customerId, $notificationId);
                if (count($notificationCollection) == 0) {
                    $data[] = [
                        'status'=>false,
                        'message'=>__('Notification(s) cannot be found according to the input condition')
                    ];
                } else {
                    foreach ($notificationCollection as $item) {
                        $item->setData($column, $status);
                        $this->notificationResource->save($item);
                    }
                    $data[] = [
                        'status'=>true,
                        'message'=>__('Update notification(s) success.')
                    ];
                }

            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                return  [
                    ['status'=>false,
                    'message'=>$exception->getMessage()]
                ];
            }
        }
        return $data;
    }

    /**
     * Get collection by condition
     *
     * @param string $customerId
     * @param string $notificationId
     * @return array|CustomerNotification\Collection
     */
    public function getCollection($customerId, $notificationId)
    {
        $notificationCollection = $this->notificationCollection->create()->addFieldToFilter('customer_id', $customerId);
        if ($notificationId =="") {
            return [];
        } else {
            $notificationId = strtolower($notificationId);
            if ($notificationId != "all") {
                $listNotificationId = explode(',', $notificationId);
                $notificationCollection->addFieldToFilter('entity_id', ['in' => $listNotificationId]);
            }
            $notificationCollection->addFieldToFilter('customer_id', $customerId);
        }
        return $notificationCollection;
    }
}
