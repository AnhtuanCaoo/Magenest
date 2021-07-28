<?php
namespace Magenest\Customer\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;

class B2bBanner extends Template implements BlockInterface {

    protected $_template = "widget/banner.phtml";
    protected $customerRepository;
    protected $_session;
    public function __construct(
        Template\Context $context,
        CustomerRepositoryInterface $customerRepository,
        Session $session,
        array $data = [])
{
    $this->_session = $session;
    $this->customerRepository = $customerRepository;
    parent::__construct($context, $data);
}
    public function getB2bCustomer(){
        $id = $this->_session->getCustomerId();

        return $id;


    }
}
