<?php

namespace Magenest\Blog\Model\Config\Backend;
use GraphQL\Examples\Blog\Data\User;
use Magento\User\Model\UserFactory;
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $_collectionFactory;
    public function __construct(
        UserFactory $collectionFactory
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
