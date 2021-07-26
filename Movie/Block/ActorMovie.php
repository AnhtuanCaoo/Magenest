<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class ActorMovie extends Template
{
    private $_ActorMovieCollectionFactory;
    private $_collection;
    public function __construct(
        Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\MovieActor\CollectionFactory $ActorMovieCollectionFactory,
        \Magenest\Movie\Model\ResourceModel\MovieActor\Collection $collection,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_collection = $collection;
        $this->_ActorMovieCollectionFactory = $ActorMovieCollectionFactory;
    }
    public function getActorMovie() {
        $collection = $this->_ActorMovieCollectionFactory->create();
        return $collection;
        }
    public function getMovies(){
        $result = $this->_ActorMovieCollectionFactory->create();
        $result = $this->_collection->joinTable();
        return $result;
    }
    
}