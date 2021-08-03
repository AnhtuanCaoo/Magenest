<?php

namespace Magenest\Blog\Model;
class Category extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'category_model';


    protected function _construct()
    {
        $this->_init('Magenest\Blog\Model\ResourceModel\BlogCategory');

    }



}
