<?php

namespace Magenest\Checkout\Model\ResourceModel;

class CustomerCoupon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_customer_coupon', 'id');
    }

}
