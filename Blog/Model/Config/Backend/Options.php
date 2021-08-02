<?php

namespace Magenest\Blog\Model\Config\Backend;
use Magento\User\Model\ResourceModel\User\CollectionFactory;
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $_collectionFactory;
    public function __construct(
        CollectionFactory $collectionFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $array[] = ['label' => '-- Please Select --', 'value' => ''];
        $movie = $this->_collectionFactory->create();
        foreach($movie as $value){
            $array[] = [
                'value' => $value->getUser_id(), 'label' => $value->getFirstname().$value->getLastname(),
            ];
        }

        return $array;
    }
}
