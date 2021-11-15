<?php

namespace Magenest\Checkout\Model\ResourceModel;

class Coupon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('salesrule_coupon', 'coupon_id');
    }

}
