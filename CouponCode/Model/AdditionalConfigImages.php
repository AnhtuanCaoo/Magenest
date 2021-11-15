<?php

namespace Magenest\CouponCode\Model;

use \Magento\Checkout\Model\ConfigProviderInterface;
use Magenest\CouponCode\Model\ResourceModel\ClaimCoupon\CollectionFactory;
use Magento\Authorization\Model\UserContextInterface;
use Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory as RuleFactory;

class AdditionalConfigImages implements ConfigProviderInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var UserContextInterface
     */
    private $userContext;
    private $ruleFactory;
    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param UserContextInterface $userContext
     */
    public function __construct(
        RuleFactory $ruleFactory,
        CollectionFactory $collectionFactory,
        UserContextInterface $userContext
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->userContext = $userContext;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Additional config
     *
     * @return array|null
     */
    public function getConfig()
    {
        $userId = $this->userContext->getUserId();
        if ($userId != null) {
            $additionalData = $this->collectionFactory->create()
                ->addFieldToFilter('customer_id', $userId)
                ->setOrder('claimed_at', 'DESC')
                ->setOrder('to_date', 'DESC')
                ->getData();
            $additionalVariables['customer_coupon'] = $additionalData;
            return $additionalVariables;
        } else {
            $additionalVariables['customer_coupon'] = $this->ruleFactory->create()->getData();
        return $additionalVariables;
        }
    }
}
