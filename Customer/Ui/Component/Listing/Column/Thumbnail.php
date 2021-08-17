<?php

namespace Magenest\Customer\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Store\Model\StoreManagerInterface;

class Thumbnail extends Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';
    protected $customerFactory;
    protected $storeManager;
    public function __construct(
        StoreManagerInterface $storeManager,
        CustomerFactory $customerFactory,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $customer = $this->customerFactory->create()->load($item['entity_id']);
                $url = $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ).substr($item['avatar'], 1);
                $item['avatar_images'] = $url;
                $item[$fieldName . '_src'] = $item['avatar_images'];
                $item[$fieldName . '_orig_src'] = $item['avatar_images'];


//                $product = $this->productFactory->create();
            }
        }
        return $dataSource;
    }
}
