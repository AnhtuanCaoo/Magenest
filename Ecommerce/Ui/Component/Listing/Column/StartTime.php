<?php

namespace Magenest\Ecommerce\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Catalog\Model\ProductFactory;

class StartTime extends Column
{

    protected $logger;
    protected $productFactory;

    public function __construct(
        ProductFactory $productFactory,
        \Psr\Log\LoggerInterface $logger,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->logger = $logger;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                    $time = $this->productFactory->create()->load($item['entity_id']);
                    $item['start_time'] = $time->getData('start_time');



//                $product = $this->productFactory->create();
            }
        }
        return $dataSource;
    }
}
