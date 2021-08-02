<?php
namespace Magenest\Customer\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Helper\Session\CurrentCustomer;

class B2bBanner extends Template implements BlockInterface {

    protected $currentCustomer;
    protected $_template = "widget/banner.phtml";
    protected $customerRepository;
    protected $_session;
    public function __construct(
        CurrentCustomer $currentCustomer,
        Template\Context $context,
        CustomerRepositoryInterface $customerRepository,
        Session $session,
        array $data = [])
{
    $this->currentCustomer = $currentCustomer;
    $this->_session = $session;
    $this->customerRepository = $customerRepository;
    parent::__construct($context, $data);
}
    public function getB2bCustomer(){
        $id = $this->currentCustomer->getCustomerId();

        return 1;


    }
}
