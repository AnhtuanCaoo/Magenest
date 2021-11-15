<?php

namespace Magenest\Checkout\Controller\Coupon;

class Claim extends \Magento\Framework\App\Action\Action
{
    protected $json;
    protected $resultJsonFactory;
    protected $couponFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magenest\Checkout\Model\CustomerCouponFactory $couponFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->couponFactory = $couponFactory;
        $this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //lấy dữ liệu từ ajax gửi sang
        $response = $this->getRequest()->getParams();
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        $model = $this->couponFactory->create();
        $model->addData($response);
        $model->save();
        // chuyển kết quả về dạng object json và trả về cho ajax
        return $resultJson->setData($response);
    }
}
