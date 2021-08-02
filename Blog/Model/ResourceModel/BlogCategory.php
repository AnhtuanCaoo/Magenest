<?php

namespace Magenest\Blog\Model\ResourceModel;

class BlogCategory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_blog_category', 'id');
    }

}
