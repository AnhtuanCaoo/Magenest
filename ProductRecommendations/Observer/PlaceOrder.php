<?php

namespace Magenest\ProductRecommendations\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
use Magenest\ProductRecommendations\Logger\ProductRecommendations;
class PlaceOrder implements ObserverInterface
{
    protected $logger;
    protected $session;
    public function __construct(
        ProductRecommendations $logger,
        Session $session
    ){
        $this->logger = $logger;
        $this->session = $session;
    }
    public function execute(Observer $observer)
    {
        $data = $observer->getData('order');
        $tmp = 0;
        $itemData = [];
        foreach ($data->getItems() as $item){
            array_push($itemData,[
                'Product ID' => $item->getData('product_id'),
                'Product SKU' => $item->getData('sku'),
                'Product name' => $item->getData('name'),
                'Price' => $item->getData('base_original_price'),
                'Qty' => $item->getData('qty_ordered')
            ]);
        }
        $log = [
            'Order detail' =>
                [
                    'Order ID' => $data->getData('increment_id'),
                    'Order total' => $data->getData('grand_total'),
                    'Discount' => $data->getData('discount_amount'),
                    'Order subtotal' => $data->getData('subtotal'),
                    'Quote ID' => $data->getData('quote_id'),
                    'Payment' => $data->getPayment()->getData('method')
                ],
            'User Data' =>
                [
                    'User ID' => $data->getCustomerId(),
                    'User Name' => $data->getData('customer_firstname').' '.$data->getData('customer_lastname'),
                    'Email' => $data->getData('customer_email'),
                    'Customer Group' => $data->getData('customer_group_id'),
                    'IP' => $data->getData('remote_ip'),
                    'Guest ?' => $data->getData('customer_is_guest')
                ],
            'Items Data' => $itemData
        ];
        $this->logger->info(print_r('Customer '. $data->getCustomerId() . ' have an order', true));
        $this->logger->info(print_r($log, true));
    }
}
