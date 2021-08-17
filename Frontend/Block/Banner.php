<?php
namespace Magenest\Frontend\Block;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magenest\Frontend\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magenest\Customer\Block\Customer;
class Banner extends Template
{
    protected $customer;
    protected $customerRepository;
    protected $bannerCollectionFactory;
    protected $serialize;
    public function __construct(
        Template\Context $context,
        Customer $customer,
        Json $serialize,
        CustomerRepositoryInterface $customerRepository,
        CollectionFactory $bannerCollectionFactory,
        array $data = [])
    {
        $this->customer = $customer;
        $this->serialize = $serialize;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }
    public function getBanner() {
        $result = [];
        $banner = $this->bannerCollectionFactory->create()->load();
        foreach($banner as $value){
            $tmp = $this->serialize->unserialize($value->getImages());
            array_push($result,$tmp);
        }
        return $result;


    }
    public function isB2b(){
        return $this->customer->getB2b();
    }


}
