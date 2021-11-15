<?php
namespace Magenest\NotificationBox\Api;

/**
 * Interface SaveTokenInterface
 * Magenest\NotificationBox\Api
 */
interface SaveTokenInterface
{
    /**
     * Save customer Token
     *
     * @param string $token
     * @param int $customerId
     * @param int $deviceId
     * @return array
     */
    public function registerForCustomer($token, $customerId, $deviceId);

    /**
     * Save guest Token
     *
     * @param string $token
     * @param int $deviceId
     * @return array
     */
    public function registerForGuest($token, $deviceId);
}
