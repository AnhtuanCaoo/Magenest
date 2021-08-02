<?php
namespace Magenest\Customer\Block\Adminhtml;
use Magento\Backend\Block\Template;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeInterface;
use Magento\Customer\Model\CustomerFactory;

class Edit extends Template
{
    protected $_attributeInterface;
    protected $_session;
    protected $customerFactory;
    protected $_request;
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        CustomerFactory $customerFactory,
        AttributeInterface $attributeInterface,
        Session $session,
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_request = $request;
        $this->customerFactory = $customerFactory;
        $this->_session = $session;
        $this->_attributeInterface = $attributeInterface;
    }



    public function getPhone(){

        $customerId = $this->_request->getParams();
        if($customerId){
            $customer = $this->customerFactory->create()->load($customerId);
            return $customer->getData('phone_number');
        }
        else return Null;
    }
}
