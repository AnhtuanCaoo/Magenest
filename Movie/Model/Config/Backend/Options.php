<?php

namespace Magenest\Movie\Model\Config\Backend;
use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory;
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $_movieFactory;
    public function __construct(
         CollectionFactory $movieFactory
    )
    {
        $this->_movieFactory = $movieFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $array[] = ['label' => '-- Please Select --', 'value' => ''];
        $movie = $this->_movieFactory->create();
        foreach($movie as $value){
            $array[] = [
                'value' => $value->getDirector_id(), 'label' => $value->getName(),
            ];
        }
        
        return $array;
    }
}