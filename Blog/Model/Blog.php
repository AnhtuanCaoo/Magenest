<?php

namespace Magenest\Blog\Model;
class Blog extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'blog_model';


    protected function _construct()
    {
        $this->_init('Magenest\Blog\Model\ResourceModel\Blog');

    }



}
