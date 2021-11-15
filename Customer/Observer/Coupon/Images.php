<?php

namespace Magenest\Customer\Observer\Coupon;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\RequestInterface;
use Magento\SalesRule\Model\RuleFactory;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magenest\Customer\Model\CouponFactory;
class Images implements ObserverInterface
{
    protected $couponFactory;
    protected $ruleInterface;
    protected $rule;
    protected $_request;
    protected $serializer;

    public function __construct(RequestInterface $request,CouponFactory $couponFactory, Json $serializer,RuleRepositoryInterface $ruleInterface,RuleFactory $rule)
    {
        $this->ruleInterface = $ruleInterface;
        $this->couponFactory = $couponFactory;
        $this->rule = $rule;
        $this->_request = $request;
        $this->serializer = $serializer;
    }

    public function execute(Observer $observer)
    {
        $data = $observer->getData('rule');
        $images = $data->getData('images');
        $serializeData = $this->serializer->serialize($images);
        $data->setData('images', $serializeData);
        $observer->setData('rule', $data);
    }
}
