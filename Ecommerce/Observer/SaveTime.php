<?php
namespace Magenest\Ecommerce\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Stdlib\DateTime\TimezoneInterface;
class SaveTime implements ObserverInterface
{
    protected $timeZoneInterface;
    protected $request;
    protected $logger;
    protected $productFactory;
    public function __construct(
        TimezoneInterface $timeZoneInterface,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Model\ProductFactory $productFactory
    )
    {
        $this->timeZoneInterface = $timeZoneInterface;
        $this->productFactory = $productFactory;
        $this->request = $request;
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();
        $time = $this->request->getPostValue();
        $id = $data['id'];
//        $product = $observer->getEvent()->getData('product');
        $start = $time['product']['start_time'];
        $end = $time['product']['end_time'];
        $start_date = $this->timeZoneInterface->convertConfigTimeToUtc($start);
        $result = $this->productFactory->create()->load($id);
        $result->setData('start_time',$start_date);
        $result->setData('end_time',$end);

    }
}
