<?php

namespace Magenest\Ecommerce\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
class EndTime extends Column
{

    protected $logger;
    protected $productFactory;
    protected $dateTime;
    public function __construct(
        DateTime $dateTime,
        ProductFactory $productFactory,
        \Psr\Log\LoggerInterface $logger,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->dateTime = $dateTime;
        $this->productFactory = $productFactory;
        $this->logger = $logger;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $time = $this->productFactory->create()->load($item['entity_id']);
                $item['end_time'] = $time->getData('end_time');



//                $product = $this->productFactory->create();
            }
        }
        return $dataSource;
    }
}
