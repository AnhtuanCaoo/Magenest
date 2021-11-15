<?php

namespace Magenest\Forum\Model\ResourceModel;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_forum_post', 'post_id');
    }
}
