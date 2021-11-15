<?php

namespace Magenest\NotificationBox\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class NotificationQueue
 * Magenest\NotificationBox\Model\ResourceModel
 */
class NotificationQueue extends AbstractDb
{
    /**
     * Init table
     */
    protected function _construct()
    {
        $this->_init('magenest_notification_queue', 'entity_id');
    }
}
