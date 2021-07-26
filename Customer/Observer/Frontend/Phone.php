<?php
namespace Magenest\Customer\Observer\Frontend;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
class Phone implements ObserverInterface
{
    protected $request;
    protected $customerFactory;
    protected $customerRepository;
    protected $session;
    public function __construct(
        Session $session,
        CustomerRepositoryInterface $customerRepository,
        CustomerFactory $customerFactory,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->session = $session;
        $this->customerRepository = $customerRepository;
        $this->customerFactory =$customerFactory;
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();



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
            $customer = $observer->getEvent()->getData('customer');
            $customer->setData('phone_number', $phone);
            $observer->setData('customer', $customer);










    }
}
