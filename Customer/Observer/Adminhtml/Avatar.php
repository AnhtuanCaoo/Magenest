<?php
namespace Magenest\Customer\Observer\Adminhtml;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\CustomerFactory;
class Avatar implements ObserverInterface
{
    protected $request;
    protected $customerFactory;

    public function __construct(
        CustomerFactory $customerFactory,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->customerFactory =$customerFactory;
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();
        if($data['customer']['avatar_url'] != ""){
            $avatar = $data['customer']['avatar_url'];

        }else{
            $avatar = $data['customer']['avatar']['0']['url'];

        }
        $id = $data['customer_id'];
        $customer = $this->customerFactory->create()->load($id);
        $customer->setData('avatar_url', $avatar);
        $customer->save();










    }
}
