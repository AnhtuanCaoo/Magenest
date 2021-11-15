<?php

namespace Magenest\Forum\Model;

use Magenest\Forum\Model\ResourceModel\Post as ResourceModel;

class Post extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
