<?php

namespace Magenest\NotificationBox\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Notification
 * Magenest\NotificationBox\Model\ResourceModel
 */
class Notification extends AbstractDb
{
    /**
     * Init table
     */
    protected function _construct()
    {
        $this->_init('magenest_notification', 'id');
    }
}
