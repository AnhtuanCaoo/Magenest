<?php
namespace Magenest\Checkout\Plugin\Minicart;

class Image

{
    protected $_product;
    protected $_logger;
    protected $_helper;
    protected $_productRepository;
    public function __construct(
        \Magento\Catalog\Helper\Product $helper,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\Product $products,
        \Magento\Catalog\Model\ProductRepository $productRepository
    )
    {
        $this->_productRepository = $productRepository;
        $this->_helper = $helper;
        $this->_product = $products;
        $this->_logger = $logger;
    }
    public function aroundGetItemData($subject, $proceed, $item)

    {
        $result = $proceed($item);
        $sku = $item->getSku();
        $product = $this->_productRepository->get($sku);

        //thumbnail
        $url = $this->_helper->getThumbnailUrl($product);
        $result['product_image']['src'] = $url;
        $attributes =[
            'product_name' => $sku,

        ];
        return array_merge($result, $attributes);


    }

}
