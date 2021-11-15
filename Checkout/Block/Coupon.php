<?php
namespace Magenest\Checkout\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Customer\Model\Session;
class Coupon extends Template
{
    private $session;
    private $couponCollectionFactory;
    private $json;
    private $date;
    private $userContext;
    public function __construct(
        Session $session,
        Template\Context $context,
        DateTime $date,
        \Magenest\Checkout\Model\ResourceModel\Coupon\CollectionFactory $couponCollectionFactory,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $salesRuleCollectionFactory,
        UserContextInterface $userContext,
        Json $json,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->userContext = $userContext;
        $this->session = $session;
        $this->date = $date;
        $this->json = $json;
        $this->couponCollectionFactory = $couponCollectionFactory;
    }
    public function getCoupon() {
        $coupon = [];
       $collection = $this->couponCollectionFactory->create()
           ->addFieldToFilter('is_active', 1);
       foreach($collection as $value) {
           $images = $value->getData('images');
           $customerGroup = $value->getData('customer_group_id');
           if(!empty($images)){
               $value->setData('images', $this->json->unserialize($images));
           }
           if($customerGroup == $this->session->getCustomerGroupId() || $customerGroup == 0){
               array_push($coupon, $value);
           }
       }
        return $coupon;
    }
    public function getToday(){
        return $this->date->gmtTimestamp();
    }
    public function getCurrentCustomer(){
        return $this->session->getCustomerGroupId();
    }
    public function getUserId(){
        return $this->userContext->getUserId();
    }
}
