<?php                                                                 
 namespace Magenest\Movie\Block\System\Config\Source;  
                       
 class Options  implements \Magento\Framework\Option\ArrayInterface            
 {

/**
 * Options for Type
 *
 * @return array
 */
public function toOptionArray()
{   
    return [['value' => 1, 'label' => __('Yes')], ['value' => 2, 'label' => __('No')]];

}

}