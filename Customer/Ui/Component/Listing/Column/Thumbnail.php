<?php

namespace Magenest\Customer\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Customer\Model\CustomerFactory;
class Thumbnail extends Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';
    protected $customerFactory;
    protected $dateTime;
    public function __construct(
        CustomerFactory $customerFactory,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $customer = $this->customerFactory->create()->load($item['entity_id']);
                $item['avatar_url'] = $customer->getData('avatar_url');
                $item[$fieldName . '_src'] = $item['avatar_url'];
                $item[$fieldName . '_orig_src'] = $item['avatar_url'];


//                $product = $this->productFactory->create();
            }
        }
        return $dataSource;
    }
}
