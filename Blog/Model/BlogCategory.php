<?php

namespace Magenest\Blog\Model;
class BlogCategory extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'blog_category_model';


    protected function _construct()
    {
        $this->_init('Magenest\Blog\Model\ResourceModel\BlogCategory');

    }



}
