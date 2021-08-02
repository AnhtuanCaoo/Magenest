<?php

namespace Magenest\Blog\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magenest\Blog\Model\BlogFactory;
class UpdateAt extends Column
{

    protected $blogFactory;



    public function __construct(
        ContextInterface $context,
        BlogFactory $blogFactory,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->blogFactory = $blogFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $item['update_at'] = $this->blogFactory->create()->load($item['id'])->getData('updated_at');
                }
            }
        }

        return $dataSource;
    }
}
