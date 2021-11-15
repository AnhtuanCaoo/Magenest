<?php

namespace Magenest\Checkout\Model;
class CustomerCoupon extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'customer_coupon_model';


    protected function _construct()
    {
        $this->_init('Magenest\Checkout\Model\ResourceModel\CustomerCoupon');

    }



}
