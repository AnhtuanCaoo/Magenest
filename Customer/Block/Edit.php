<?php
namespace Magenest\Customer\Block;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeInterface;
use Magento\Customer\Model\CustomerFactory;
class Edit extends Template
{
    protected $_attributeInterface;
    protected $_session;
    protected $_customerRepository;
    protected $customerFactory;
    public function __construct(
        CustomerFactory $customerFactory,
        AttributeInterface $attributeInterface,
        Session $session,
        Template\Context $context,
        CustomerRepositoryInterface $customerRepository,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->customerFactory = $customerFactory;
        $this->_customerRepository = $customerRepository;
        $this->_session = $session;
        $this->_attributeInterface = $attributeInterface;
    }



    public function getPhone(){
        $customerId = $this->_session->getCustomerId();
        if($customerId){
            $customer = $this->customerFactory->create()->load($customerId);
            return $customer->getData('phone_number');
        }
        else return Null;
    }
}
