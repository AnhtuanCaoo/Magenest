<?php
namespace Magenest\Forum\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
class Comment extends Template
{
    private $timezone;
    private $_blogCollectionFactory;
    private $json;
    public function __construct(
        Template\Context $context,
        DateTimeFactory $timezone,
        Json $json,
        \Magenest\Forum\Model\ResourceModel\Comment\CollectionFactory $blogCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->timezone = $timezone;
        $this->json = $json;
        $this->_blogCollectionFactory = $blogCollectionFactory;
    }
    public function getComment() {
        $request = array_keys($this->getRequest()->getParams())[0];
        $collection = $this->_blogCollectionFactory->create()
            ->addFieldToFilter('post_id', $request);
        return $collection;

    }
    public function handleDate($data)
    {
        $date = $this->timezone->create()->gmtDate("F j, Y, g:i a",$data);
        return $date;
    }
}
