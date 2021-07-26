<?php
namespace Magenest\Customer\Observer\Adminhtml;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Action\Context;
use Magento\Eav\Model\Config;

class Phone implements ObserverInterface
{
    protected $eavConfig;
    protected $request;
    protected $customerFactory;
    protected $getmessenger;
    protected $attributeResource;
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
        Config $eavConfig,
        CustomerFactory $customerFactory,
        \Magento\Framework\App\RequestInterface $request,
        Context $context
    )
    {
        $this->attributeResource = $attributeResource;
        $this->eavConfig = $eavConfig;
        $this->getmessenger = $context->getMessageManager();
        $this->customerFactory = $customerFactory;
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {


        $data = $observer->getData('customer');
        if($data->getData('phone_number')){
            $telephone = $data->getData('phone_number');
            if ($telephone != '') {
                $a = substr($telephone, 0, 3);

                if (strlen($telephone) > 13) {
                    throw new \Exception('Invalid Number');

                } else if ($a == '+84') {
                    $newphone = str_replace('+84', '0', $telephone);
                    $data->setData('phone_number', $newphone);
                    $observer->setData('customer', $data);
                }else{
                    $tmp = $data->setData('phone_number', $telephone);
                    $observer->setData('customer', $tmp);
                }
            }

        }

    }
}
