<?php

namespace Magenest\NotificationBox\Model\ResourceModel\NotificationType;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\NotificationBox\Model\NotificationType as Model;
use Magenest\NotificationBox\Model\ResourceModel\NotificationType as ResourceModel;

/**
 * Class Collection
 * Magenest\NotificationBox\Model\ResourceModel\NotificationType;
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
