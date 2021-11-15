<?php

namespace Magenest\CouponCode\Model\ResourceModel;

class Coupon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Init resource model
     */
    protected function _construct()
    {
        $this->_init($this->getTable('salesrule_coupon'), 'coupon_id');
    }
}
