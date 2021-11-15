<?php

namespace Magenest\ProductRecommendations\Model;

use Magenest\ProductRecommendations\Model\ResourceModel\ProductViewer as ResourceModel;

class ProductViewer extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
