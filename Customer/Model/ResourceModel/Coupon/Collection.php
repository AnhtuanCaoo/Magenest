<?php

namespace Magenest\Customer\Model\ResourceModel\Coupon;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Magenest\Customer\Model\Coupon', 'Magenest\Customer\Model\ResourceModel\Coupon');
    }

}
