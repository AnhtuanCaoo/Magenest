<?php

namespace Magenest\Frontend\Model\DataProvider;

use Magenest\Frontend\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\Serialize\Serializer\Json;

class BannerProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
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
        $this->collection = $collectionFactory->create();
        $this->serialize = $serialize;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            if(isset($item->getData()['images']))
            {
                try
                {
                    $item->setData('images',$this->serialize->unserialize($item->getImages()));
                }catch (\Exception $e){
                    $item->setData('images','');
                }
            }
            $this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
    }
}
