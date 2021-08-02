<?php
namespace Magenest\Blog\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;
class BlogId extends Template
{
    private $_blogCollectionFactory;
    protected $_urlInterface;
    protected $blogCollection;
    public function __construct(
        Template\Context $context,
        UrlInterface $urlInterface,
        \Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
        \Magenest\Blog\Model\ResourceModel\Blog\Collection $blogCollection,

        array $data = [])
    {
        parent::__construct($context, $data);
        $this->blogCollection = $blogCollection;
        $this->_urlInterface = $urlInterface;
        $this->_blogCollectionFactory = $blogCollectionFactory;
    }
    public function getBlog(){
        $tmp = explode("/",$this->_urlInterface->getCurrentUrl());
        if(isset($tmp['6'])){
            $id = $tmp['6'];
            $blog = $this->_blogCollectionFactory->create()->addFieldToFilter('id',$id);
            return $blog;

        }else{
            $id = explode('g',$tmp['3']);

            $blog = $this->_blogCollectionFactory->create()->addFieldToFilter('id',$id['1']);
            return $blog;
        }
    }



}
