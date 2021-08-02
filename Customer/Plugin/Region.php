<?php
namespace Magenest\Customer\Plugin;
use Magento\Customer\Model\Address\AddressModelInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Region extends AbstractExtensibleModel
{
    public function beforeSave(){
        parent::beforeSave();
        $oke = 1;
    }
}
