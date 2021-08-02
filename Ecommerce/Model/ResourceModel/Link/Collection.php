<?php

namespace Magenest\Ecommerce\Model\ResourceModel\Link;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{


    protected function _construct()
    {
        $this->_init('Magenest\Ecommerce\Model\Link', 'Magenest\Ecommerce\Model\ResourceModel\Link');
    }

}
