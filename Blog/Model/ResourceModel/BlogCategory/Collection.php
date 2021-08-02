<?php

namespace Magenest\Blog\Model\ResourceModel\BlogCategory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Magenest\Blog\Model\BlogCategory', 'Magenest\Blog\Model\ResourceModel\BlogCategory');
    }

}
