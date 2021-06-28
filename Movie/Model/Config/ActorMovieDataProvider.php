<?php

namespace Magenest\Movie\Model\Config;

use Magenest\Movie\Model\MovieActorFactory;
use Magenest\Movie\Model\ResourceModel\MovieActor\CollectionFactory;

class ActorMovieDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    protected $collection;

    public function __construct(
        
        $name,
        $primaryFieldName,
        $requestFieldName,
        // MovieActorFactory $loadedData,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        // $this->_loadedData = $loadedData;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
    }
}