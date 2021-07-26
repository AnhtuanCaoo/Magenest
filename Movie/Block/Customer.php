<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeInterface;
class Customer extends Template
{
    protected $_attributeInterface;
    protected $_session;
    protected $_customerRepository;
    public function __construct(
        AttributeInterface $attributeInterface,
        Session $session,
        Template\Context $context,
        CustomerRepositoryInterface $customerRepository,
        array $data = [])
    {
        parent::__construct($context, $data);
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
}