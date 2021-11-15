<?php
namespace Magenest\Checkout\Block\Onepage\Success;
use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Session as CheckoutSession;

class OrderInformation extends Template
{
    protected $checkoutSession;
    public function __construct(Template\Context $context,CheckoutSession $checkoutSession,array $data = [])
    {
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    public function getCurrentOrder()
    {

        $tmp = $this->checkoutSession->getLastRealOrder();
        return $tmp;
    }
    public function getPaymentMethod(){
        $payment = $this->getCurrentOrder()->getPayment()->getData('additional_information');
        return $payment['method_title'];
    }
    public function getTotalMoney(){
        $total = $this->getCurrentOrder()->getData('grand_total');
        return $total;
    }
    public function getShippingMethod(){
        return $this->getCurrentOrder()->getData('shipping_description');
    }
    public function getCreateAt(){
        return $this->getCurrentOrder()->getData('created_at');
    }

}
