<?php

namespace Magenest\ProductRecommendations\Model\ResourceModel;

class ProductViewer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_view_product', 'id');
    }
}
