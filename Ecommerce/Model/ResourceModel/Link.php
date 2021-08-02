<?php

namespace Magenest\Ecommerce\Model\ResourceModel;

class Link extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_course', 'id');
    }

}
