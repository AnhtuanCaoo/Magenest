<?php
namespace Magenest\Forum\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
class Blog extends Template
{
    private $timezone;
    private $_blogCollectionFactory;
    private $json;
    private $templateProcessor;
    public function __construct(
        Template\Context $context,
        DateTimeFactory $timezone,
        \Zend_Filter_Interface $templateProcessor,
        Json $json,
        \Magenest\Forum\Model\ResourceModel\Post\CollectionFactory $blogCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->templateProcessor = $templateProcessor;
        $this->timezone = $timezone;
        $this->json = $json;
        $this->_blogCollectionFactory = $blogCollectionFactory;
    }
    public function getBlog() {
        $collection = $this->_blogCollectionFactory->create()
            ->setOrder('post_id', 'DESC');
        return $collection;

    }

    public function handleImage($data)
    {
        $img = $this->json->unserialize($data);
        if (isset($img[0]['url'])) {
            return $img[0]['url'];
        }
        return null;
    }
    public function handleDate($data)
    {
        $date = $this->timezone->create()->gmtDate("F j, Y, g:i a",$data);
        return $date;
    }
    public function handleDate2($data)
    {
        $date = $this->timezone->create()->gmtDate("F j, Y",$data);
        return $date;
    }
    public function getBlogDetail() {
        $request = array_keys($this->getRequest()->getParams())[0];
        $collection = $this->_blogCollectionFactory->create()
            ->addFieldToFilter('post_id', $request);
        return $collection;

    }
    public function handleContent($data) {
        return $this->templateProcessor->filter($data);
    }
}
