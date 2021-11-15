<?php

namespace Magenest\Forum\Model;

use Magenest\Forum\Model\ResourceModel\Comment as ResourceModel;

class Comment extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
