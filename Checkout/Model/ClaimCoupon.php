<?php

namespace Magenest\Checkout\Model;
class ClaimCoupon extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'claim_coupon_model';


    protected function _construct()
    {
        $this->_init('Magenest\Checkout\Model\ResourceModel\ClaimCoupon');

    }



}
