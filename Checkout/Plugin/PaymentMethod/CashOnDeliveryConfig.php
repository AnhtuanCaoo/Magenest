<?php
namespace Magenest\Checkout\Plugin\PaymentMethod;
use Magento\OfflinePayments\Model\Cashondelivery;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\ProductRepository;
class CashOnDeliveryConfig
{
    protected $productRepository;
    protected $cart;
    public function __construct(
        Cart $cart,
        ProductRepository $productRepository
    ){
        $this->productRepository = $productRepository;
        $this->cart = $cart;
    }
    public function afterIsAvailable(Cashondelivery $subject, $result)
    {
        $arr = [];
        $product = $this->cart->getQuote()->getAllItems();
        foreach ($product as $item){
            $id = $item->getProduct_id();
            $tmp = $this->productRepository->getById($id);
            $cod = $tmp->getEngraving_services();
            if($cod == 1){
                array_push($arr,$cod);
            }
        }
        if($arr != []){
            return false;
        }else return true;
    }

}
