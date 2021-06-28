<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class Director extends Template
{
    private $_directorCollectionFactory;

    public function __construct(
        Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Director\CollectionFactory $directorCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_directorCollectionFactory = $directorCollectionFactory;
    }
    public function getDirector() {
        $collection = $this->_directorCollectionFactory->create();
        return $collection;
        }
}