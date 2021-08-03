<?php

namespace Magenest\NotificationBox\Model\Api;

use Magenest\NotificationBox\Api\GetNotificationInterface;
use \Magenest\NotificationBox\Helper\Helper;
use Magenest\NotificationBox\Model\ResourceModel\CustomerNotification\Collection;
use Magenest\NotificationBox\Model\ResourceModel\CustomerNotification\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class GetNotification implements GetNotificationInterface
{

    const TABLE_NAME = 'magenest_notification';

    const STORE_DEFAULT = 0;

    /** @var Helper */
    public $helper;

    /** @var CollectionFactory */
    public $collectionFactory;

    /** @var TimezoneInterface */
    protected $timezoneInterface;

    /** @var UrlInterface */
    protected $urlInterface;

    /** @var LoggerInterface */
    protected $logger;

    /** @var CustomerRepositoryInterface */
    protected $customerRepositoryInterface;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * GetNotification constructor.
     *
     * @param Helper $helper
     * @param CollectionFactory $collectionFactory
     * @param TimezoneInterface $timezoneInterface
     * @param UrlInterface $urlInterface
     * @param LoggerInterface $logger
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
        Helper $helper,
        CollectionFactory $collectionFactory,
        TimezoneInterface $timezoneInterface,
        UrlInterface $urlInterface,
        LoggerInterface $logger,
        CustomerRepositoryInterface $customerRepositoryInterface,
        StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->logger                      = $logger;
        $this->urlInterface                = $urlInterface;
        $this->timezoneInterface           = $timezoneInterface;
        $this->collectionFactory           = $collectionFactory;
        $this->helper                      = $helper;
        $this->_storeManager               = $storeManager;
        $this->_resource                   = $resource;
    }

    /**
     * @param int $customerId
     *
     * @return array
     */
    public function getCustomerNotification($customerId)
    {
        $data                        = [];
        $notificationCollection      = $this->getNotifications($customerId);
        $notificationCollectionClone = clone $notificationCollection;
        $notificationCollection      = $notificationCollection->setPageSize(20);
        $notificationCollection      = $notificationCollection->getData();
        try {
            $this->customerRepositoryInterface->getById($customerId);
            foreach ($notificationCollection as & $notification) {
                $notification['name']         = $this->helper->getNotificationNameById($notification['notification_id']);
                $notification['icon']         = $this->helper->getImageByNotificationType($notification);
                $notification['created_at']   = $this->timezoneInterface->formatDateTime($notification['created_at'], 2, 2);
                $notification['redirect_url'] = $this->urlInterface->getUrl('notibox/handleNotification/viewNotification') . '?id=' . $notification['entity_id'];
            }
            $totalNotificationUnread = $notificationCollectionClone->addFieldToFilter('status', 0)->getSize();
            $data[]                  = [
                'status' => true,
                'data'   => [
                    'totalNotificationUnread' => $totalNotificationUnread,
                    'allNotification'         => $notificationCollection
                ]
            ];
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $data[] = [
                'status'  => false,
                'message' => $exception->getMessage()
            ];
        }

        return $data;
    }

    /**
     * @param $customerId
     *
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getNotifications($customerId)
    {
        $storeId    = (int)$this->_storeManager->getStore()->getId();
        $tableName  = $this->_resource->getTableName(self::TABLE_NAME);
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId)
            ->setOrder('entity_id', 'DESC');
        $collection->getSelect()->joinInner([
            'search_result' => $tableName,
        ],
            'main_table.notification_id = search_result.' . 'id',
        );
        $collection->addFieldToFilter(
            ['store_view', 'store_view'],
            [
                ['like' => '%' . self::STORE_DEFAULT . '%'],
                ['like' => '%' . $storeId . '%']
            ]
        );

        return $collection;
    }
}
