<?php

namespace Magenest\ProductRecommendations\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
use Magenest\ProductRecommendations\Logger\ProductRecommendations;
use Magento\Setup\Exception;
use Magenest\ProductRecommendations\Model\ProductViewerFactory;
use Magenest\ProductRecommendations\Model\ResourceModel\ProductViewer\CollectionFactory;
class ProductView implements ObserverInterface
{
    protected $collection;
    protected $model;
    protected $logger;
    protected $session;
    public function __construct(
        CollectionFactory $collection,
        ProductRecommendations $logger,
        Session $session,
        ProductViewerFactory $model
    ){
        $this->collection = $collection;
        $this->model = $model;
        $this->logger = $logger;
        $this->session = $session;
    }
    public function execute(Observer $observer)
    {
        $exist = false;
        $data = $observer->getData('product');
        $product_id = $data->getData('entity_id');
        $user_data = $this->session->getCustomerData();
        if($user_data != null) {
            $log = [
                'Product Data' =>
                    [
                        'Product ID' => $product_id,
                        'Product SKU' => $data->getData('sku'),
                        'Product name' => $data->getData('name'),
                        'Price' => $data->getData('price'),
                        'Category' => $data->getCategory()->getData('name')
                    ],
                'User Data' =>
                    [
                        'User ID' => $user_data->getId(),
                        'User Name' => $user_data->getFirstname().' '.$user_data->getLastname(),
                        'Email' => $user_data->getEmail(),
                        'Gender' => $user_data->getGender(),
                        'Customer Group' => $this->session->getCustomerGroupId()
                    ]
            ];
            $this->logger->info(print_r('Customer '. $user_data->getId() . ' view product', true));
            $this->logger->info(print_r($log, true));
            $model = $this->model->create();
            $collection = $this->collection->create();
            foreach($collection as $item) {
                if($item->getData('product_id') == $product_id && $item->getData('user_id') == $user_data->getId()){
                    $id = $item->getData('id');
                    $exist = true;
                    $model->load($id);
                    $count = (int)($item->getData('count_view'));
                    $count = $count + 1;
                }
            };
            if($exist){
                $model->setData('count_view', $count);
                $model->save();
            } else {
                $model->addData(
                    [
                        'product_id' => $product_id,
                        'user_id' =>  $user_data->getId(),
                        'count_view' => 1
                    ]
                );
                $model->save();
            }
        }else {
            $log = [
                'Product Data' =>
                    [
                        'Product ID' => $product_id,
                        'Product SKU' => $data->getData('sku'),
                        'Product name' => $data->getData('name'),
                        'Price' => $data->getData('price'),
                        'Category' => $data->getCategory()->getData('name')
                    ],
            ];
            $this->logger->info(print_r('Guest view product', true));
            $this->logger->info(print_r($log, true));
            $model = $this->model->create();
            $model->addData(
                [
                    'product_id' => $product_id,
                    'user_id' => null
                ]
            );
            $model->save();
        }
    }
}
