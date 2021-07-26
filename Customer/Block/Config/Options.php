<?php
namespace Magenest\Customer\Block\Config;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Options extends AbstractSource
{

/**
* Retrieve All options
*
* @return array
*/
public function getAllOptions()
{
$this->_options = [
['label'=>__('North side'),'value'=>'1'],
['label'=>__('West side'),'value'=>'2'],
['label'=>__('South side'),'value'=>'3']
];

return $this->_options;
}
}
