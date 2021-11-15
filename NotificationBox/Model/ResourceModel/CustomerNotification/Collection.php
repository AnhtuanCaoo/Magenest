<?php

namespace Magenest\NotificationBox\Model\ResourceModel\CustomerNotification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\NotificationBox\Model\CustomerNotification as Model;
use Magenest\NotificationBox\Model\ResourceModel\CustomerNotification as ResourceModel;

/**
 * Class Collection
 * Magenest\NotificationBox\Model\ResourceModel\Notification
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    /**
     * Init collection
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
