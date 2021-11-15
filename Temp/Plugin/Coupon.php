<?php
namespace Magenest\Temp\Plugin;
use Magenest\CouponCode\Model\ResourceModel\ClaimCoupon\CollectionFactory;
use Magento\Authorization\Model\UserContextInterface;

class Coupon {
    private $userContext;
    private $collectionFactory;
    public function __construct(
        CollectionFactory $collectionFactory,
        UserContextInterface $userContext
    )
    {
        $this->userContext = $userContext;
        $this->collectionFactory = $collectionFactory;
    }

    public function afterGetConfig(\Magento\Checkout\Model\CompositeConfigProvider $object, $result){
        $customerId = $this->userContext->getUserId();
        if ($customerId == null){
            return $result;
        }else{
            $customerCoupon = $this->collectionFactory->create()->addFieldToFilter('customer_id', $customerId)->getData();
            $result['rules'] =  $customerCoupon;
            return $result;
        }
    }
}
