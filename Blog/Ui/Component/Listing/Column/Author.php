<?php

namespace Magenest\Blog\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magenest\Blog\Model\BlogFactory;
use Magento\User\Model\ResourceModel\User\CollectionFactory;
class Author extends Column
{

    protected $blogFactory;

    protected $userCollection;

    public function __construct(
        ContextInterface $context,
        CollectionFactory $userCollection,
        BlogFactory $blogFactory,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->userCollection = $userCollection;
        $this->blogFactory = $blogFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $author = $this->blogFactory->create()->load($item['id'])->getData('author_id');

                    $user = $this->userCollection->create()->getItemById($author)->getData('firstname');
                    $item['firstname'] = $user;
                }
            }
        }

        return $dataSource;
    }
}
