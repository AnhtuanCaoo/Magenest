<?php

namespace Magenest\Blog\Model\ResourceModel\Category;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Magenest\Blog\Model\Category', 'Magenest\Blog\Model\ResourceModel\Category');
    }

}
