<?php
namespace Magenest\Frontend\Block;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;

class Banner extends Template
{
    protected $customerRepository;
    public function __construct(
        Template\Context $context,
        CustomerRepositoryInterface $customerRepository,
        array $data = [])
    {

        $this->customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }
    public function validate() {
        return null;


    }


}
