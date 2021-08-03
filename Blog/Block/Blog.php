<?php
namespace Magenest\Blog\Block;
use Magento\Framework\View\Element\Template;
class Blog extends Template
{
    private $_blogCollectionFactory;
    public function __construct(
        Template\Context $context,
        \Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_blogCollectionFactory = $blogCollectionFactory;
    }
    public function getBlog() {
        $collection = $this->_blogCollectionFactory->create();

        return $collection;

    }


}
