<?php

namespace Magenest\CouponCode\Model;

use Magenest\CouponCode\Model\ResourceModel\Coupon as ResourceModel;
use Magento\Framework\DataObject\IdentityInterface;

class Coupon extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'MAGENEST_COUPON_LISTING';

    /**
     * Init model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG];
    }
}
