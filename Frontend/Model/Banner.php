<?php

namespace Magenest\Frontend\Model;
class Banner extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'banner_model';


    protected function _construct()
    {
        $this->_init('Magenest\Frontend\Model\ResourceModel\Banner');

    }



}
