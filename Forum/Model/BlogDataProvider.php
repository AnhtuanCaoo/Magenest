<?php

namespace Magenest\Forum\Model;

use Magenest\Forum\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Serialize\Serializer\Json;

class BlogDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
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
            if(isset($item->getData()['image']))
            {
                try
                {
                    $data = $item->getData('image');
                    $image = $this->serialize->unserialize($data);
                    $item->setData('image', $image);
                }catch (\Exception $e){
                    $item->setData('image','');
                }
            }
            $this->_loadedData[$item->getData('post_id')] = $item->getData();
        }
        return $this->_loadedData;
    }
}
