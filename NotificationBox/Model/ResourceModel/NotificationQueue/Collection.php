<?php

namespace Magenest\NotificationBox\Model\ResourceModel\NotificationQueue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\NotificationBox\Model\NotificationQueue as Model;
use Magenest\NotificationBox\Model\ResourceModel\NotificationQueue as ResourceModel;

/**
 * Class Collection
 * Magenest\NotificationBox\Model\ResourceModel\NotificationQueue
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
