<?php
namespace Magenest\Ecommerce\Observer;
use Magenest\Ecommerce\Model\Link;
use Magento\Framework\Event\ObserverInterface;
use Magenest\Ecommerce\Model\LinkFactory;
class SaveCourse implements ObserverInterface
{
    protected $linkFactory;
    protected $request;
    protected $productFactory;
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        LinkFactory $linkFactory
    )
    {
        $this->linkFactory = $linkFactory;
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();
        $course = $this->request->getPostValue();
        $id = $data['id'];
        $result =  json_encode($course['product']['dynamic_rows']);
        $link = $course['product']['dynamic_rows']['0']['link'];
        $description = $course['product']['dynamic_rows']['0']['link_description'];

        $record_id = $course['product']['dynamic_rows']['0']['record_id'];

        $collection = $this->linkFactory->create();
        $collection->setData('record_id', $record_id);
        $collection->setData('link', $link);
        $collection->setData('link_description', $description);
        $collection->save();


    }
}
