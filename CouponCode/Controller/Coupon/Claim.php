<?php

namespace Magenest\CouponCode\Controller\Coupon;

use Magento\Framework\Controller\Result\JsonFactory;
use Magenest\CouponCode\Model\ClaimCouponFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\PageCache\Model\Cache\Type;
use Magenest\CouponCode\Block\MyCoupon;
use Magenest\CouponCode\Model\ResourceModel\ClaimCoupon;

class Claim extends \Magento\Framework\App\Action\Action
{

    /**
     * @var Type
     */
    protected $flush;
    /**
     * @var Json
     */
    protected $json;
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @var ClaimCouponFactory
     */
    protected $couponFactory;
    /**
     * @var ClaimCoupon
     */
    protected $resource;
    /**
     * Data constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param Type $flush
     * @param Json $json
     * @param ClaimCoupon $resourceMyCoupon
     * @param ClaimCouponFactory $couponFactory
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Type $flush,
        Json $json,
        ClaimCoupon $resource,
        ClaimCouponFactory $couponFactory,
        JsonFactory $resultJsonFactory
    ) {
        $this->flush = $flush;
        $this->resource = $resource;
        $this->couponFactory = $couponFactory;
        $this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * Claim a coupon
     *
     * @return \Magento\Framework\Controller\Result\Json
     * @throws \Exception
     */
    public function execute()
    {
        $response = $this->getRequest()->getParams();
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        $model = $this->couponFactory->create();
        $model->addData($response);
        $this->resource->save($model);
        return $resultJson->setData($response);
    }
}
