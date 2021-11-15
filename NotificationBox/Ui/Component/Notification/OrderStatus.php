<?php

namespace Magenest\NotificationBox\Ui\Component\Notification;

use \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;

class OrderStatus implements \Magento\Framework\Option\ArrayInterface
{
    /** @var CollectionFactory  */
    protected $statusCollectionFactory;

    /**
     * @param CollectionFactory $statusCollectionFactory
     */
    public function __construct(CollectionFactory $statusCollectionFactory)
    {
        $this->statusCollectionFactory = $statusCollectionFactory;
    }
    /**
     * Get all order status
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->statusCollectionFactory->create()->toOptionArray();
    }
}
