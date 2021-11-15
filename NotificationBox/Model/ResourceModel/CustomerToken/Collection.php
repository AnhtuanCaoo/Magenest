<?php

namespace Magenest\NotificationBox\Model\ResourceModel\CustomerToken;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\NotificationBox\Model\CustomerToken as Model;
use Magenest\NotificationBox\Model\ResourceModel\CustomerToken as ResourceModel;

/**
 * Class Collection
 * Magenest\NotificationBox\Model\ResourceModel\CustomerToken;
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
