<?php
namespace Magenest\NotificationBox\Api;

/**
 * Interface GetNotificationInterface
 * Magenest\NotificationBox\Api
 */
interface GetNotificationInterface
{
    /**
     * Get customer notification
     *
     * @param int $customerId
     * @return array
     */
    public function getCustomerNotification($customerId);
}
