<?php
namespace Magenest\Ecommerce\Observer;
use Magenest\Ecommerce\Model\Link;
use Magento\Framework\Event\ObserverInterface;
use Magenest\Ecommerce\Model\LinkFactory;
use Magento\Framework\Serialize\Serializer\Json;

class SaveCourse implements ObserverInterface
{
    protected $linkFactory;
    protected $request;
    protected $productFactory;
    protected $serialize;
    public function __construct(
        Json $serialize,
        \Magento\Framework\App\RequestInterface $request,
        LinkFactory $linkFactory
    )
    {
        $this->serialize = $serialize;
        $this->linkFactory = $linkFactory;
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();
        $course = $this->request->getPostValue();
        $id = $data['id'];
        $result =  $this->serialize->serialize($course['product']['dynamic_rows']);
        $collection = $this->linkFactory->create();
        $collection->setData('link', $result);
        $collection->save();


    }
}
