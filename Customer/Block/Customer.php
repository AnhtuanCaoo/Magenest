<?php
namespace Magenest\Customer\Block;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeInterface;
use Magento\Customer\Model\CustomerFactory;
class Customer extends Template
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


    public function getFirstname(){
        $customerId = $this->_session->getCustomerId();
        if($customerId){
            $customer = $this->_customerRepository->getById($customerId);
            $firstname = $customer->getFirstname();
            return $firstname;
        }else return Null;

    }
    public function getLastname(){
        $customerId = $this->_session->getCustomerId();
        if($customerId){
            $customer = $this->_customerRepository->getById($customerId);
            $lastname = $customer->getLastname();
            return $lastname;
        }else return Null;

    }
    public function getEmail(){
        $customerId = $this->_session->getCustomerId();
        if($customerId){
            $customer = $this->_customerRepository->getById($customerId);
            $email = $customer->getEmail();
            return $email;
        }else return Null;

    }
    public function getAvatar(){
        $customerId = $this->_session->getCustomerId();
        if($customerId){
            $customer = $this->customerFactory->create()->load($customerId);
            return $customer->getData('avatar_url');
        }
        else return Null;
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
