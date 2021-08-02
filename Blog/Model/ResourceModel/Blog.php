<?php

namespace Magenest\Blog\Model\ResourceModel;

class Blog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_blog', 'id');
    }

}
