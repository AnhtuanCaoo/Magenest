<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class ActorMovie extends Template
{
    private $_ActorMovieCollectionFactory;

    public function __construct(
        Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\MovieActor\CollectionFactory $ActorMovieCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_ActorMovieCollectionFactory = $ActorMovieCollectionFactory;
    }
    public function getActorMovie() {
        $collection = $this->_ActorMovieCollectionFactory->create();
        return $collection;
        }
}