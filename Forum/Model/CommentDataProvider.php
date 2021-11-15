<?php

namespace Magenest\Forum\Model;

use Magenest\Forum\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Serialize\Serializer\Json;

class CommentDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    protected $collection;
    protected $serialize;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Json $serialize,
        CollectionFactory $collectionFactory,

        array $meta = [],
        array $data = []
    )
    {
        $this->serialize = $serialize;
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getData('comment_id')] = $item->getData();
        }
        return $this->_loadedData;
    }
}
