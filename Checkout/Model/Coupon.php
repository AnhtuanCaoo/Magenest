<?php

namespace Magenest\Checkout\Model;
class Coupon extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'coupon_model';


    protected function _construct()
    {
        $this->_init('Magenest\Checkout\Model\ResourceModel\Coupon');

    }



}
