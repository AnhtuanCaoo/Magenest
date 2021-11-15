<?php

namespace Magenest\NotificationBox\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\NotificationBox\Model\Notification as Model;
use Magenest\NotificationBox\Model\ResourceModel\Notification as ResourceModel;

/**
 * Class Collection
 * Magenest\NotificationBox\Model\ResourceModel\Notification
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Init collection
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
