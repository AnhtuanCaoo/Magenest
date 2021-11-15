<?php
namespace Magenest\NotificationBox\Api;

/**
 * Interface HandleNotificationInterface
 * Magenest\NotificationBox\Api
 */
interface HandleNotificationInterface
{
    /**
     * Delete notifications
     *
     * @param int $customerId
     * @param string $notificationId
     * @return array
     */
    public function deleteNotifications($customerId, $notificationId);

    /**
     * Mark as read notifications
     *
     * @param int $customerId
     * @param string $notificationId
     * @return array
     */
    public function markAsRead($customerId, $notificationId);

    /**
     * Mark important notifications
     *
     * @param string $customerId
     * @param int $notificationId
     * @param int $status
     * @return array
     */
    public function markImportant($customerId, $notificationId, $status);
}
