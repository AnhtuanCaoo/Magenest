<?php

namespace Magenest\Checkout\Model\ResourceModel\CustomerCoupon;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';


    protected function _construct()
    {
        $this->_init('Magenest\Checkout\Model\CustomerCoupon', 'Magenest\Checkout\Model\ResourceModel\CustomerCoupon');
    }


}
