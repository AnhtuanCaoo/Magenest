<?php

namespace Magenest\Customer\Model\ResourceModel;

class Coupon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('coupon_extra_information', 'id');
    }

}
