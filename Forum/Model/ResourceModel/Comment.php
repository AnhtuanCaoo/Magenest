<?php

namespace Magenest\Forum\Model\ResourceModel;

class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_forum_comment', 'id');
    }
}
