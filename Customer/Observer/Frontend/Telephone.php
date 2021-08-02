<?php
namespace Magenest\Customer\Observer\Frontend;
use Magento\Framework\Event\ObserverInterface;

class Telephone implements ObserverInterface
{
    protected $request;
    protected $customerFactory;
    protected $customerRepository;
    protected $session;
    public function __construct(

        \Magento\Framework\App\RequestInterface $request
    )
    {

        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();


    if(isset($data['phone_number'])){
        $phone = $data['phone_number'];
        if(strlen($phone) >10){
            $phone = 'Invalid number';
        }
        else {
            $tmp = substr($phone, 0, 1);
            if ($tmp != "0") {
                $tmp = substr($phone, 0, 3);
                if ($tmp != "+84") {
                    $phone = "Invalid number";
                } else {
                    $phone = substr_replace($phone,"0",0,3);
                }
            }
        }
        $customer = $observer->getEvent()->getData('customer_address');
        $customer->setData('telephone', $phone);
        $observer->setData('customer', $customer);
    }











    }
}
