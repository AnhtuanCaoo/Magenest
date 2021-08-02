<?php
namespace Magenest\Customer\Observer\Adminhtml;
use Magento\Framework\Event\ObserverInterface;
class Address implements ObserverInterface
{
    protected $request;
    protected $customerFactory;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();











    }
}
