<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class Actor extends Template
{
    private $_actorCollectionFactory;
    private $_resultCollection;
    public function __construct(
        Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory $actorCollectionFactory,
        \Magenest\Movie\Model\ResourceModel\Actor\Collection $resultCollection,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_actorCollectionFactory = $actorCollectionFactory;
        $this->_resultCollection = $resultCollection;
    }
    public function getActor() {
        $collection = $this->_actorCollectionFactory->create();
        
        return $collection;

    }
    public function countRow(){
        $count= $this->_resultCollection->countRowInTable();
        return $count;
    }
}