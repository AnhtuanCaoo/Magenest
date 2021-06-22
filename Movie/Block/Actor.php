<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class Actor extends Template
{
    private $_actorCollectionFactory;

    public function __construct(
        Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory $actorCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_actorCollectionFactory = $actorCollectionFactory;
    }
    public function getActor() {
        $collection = $this->_actorCollectionFactory->create();
        
        return $collection;
        }
}