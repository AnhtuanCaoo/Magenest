<?php
namespace Magenest\ProductRecommendations\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Customer\Model\Session;
use Phpml\Association\Apriori;

class Product extends Template
{
    private $productRepository;
    private $session;
    private $productCollectionFactory;
    public function __construct(
        Template\Context $context,
        Session $session,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        Json $json,
        \Magenest\ProductRecommendations\Model\ResourceModel\ProductViewer\CollectionFactory $productCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->session = $session;
        $this->json = $json;
        $this->productCollectionFactory = $productCollectionFactory;
    }
    public function getProduct() {
        $result = [];
        $itemData = [];
        $collection = $this->productCollectionFactory->create();
        $user = $this->session->getCustomerId();
        $collection->addFieldToFilter('user_id', $user);
        foreach ($this->productCollectionFactory->create()->addFieldToFilter('user_id', $user) as $item){
            array_push($itemData, $item->getData('count_view'));
        }
        $max = max($itemData);
        foreach($this->productCollectionFactory->create()->addFieldToFilter('user_id', $user) as $item) {
            if($item->getData('count_view') == $max){
                array_push( $result,(int)$item->getData('product_id'));
            }
        }
        $collection->addFieldToFilter('product_id', $result);

        $associator = new Apriori($support = 0.5, $confidence = 0.5);
        $associator2 = new Apriori($support = 0.5, $confidence = 0.5);

//        $associator->train([['beta', 'alpha', 'epsilon'], ['beta', 'alpha', 'theta'], ['beta', 'alpha', 'epsilon'], ['alpha', 'beta', 'theta']], []);
        $temp =[[308, 406, 566,555,443],[305,306,308,468,3,2]];
        $associator->train($temp,[]);

        $tmp = $associator->predict($result);
        $associator2->train($tmp,[]);
        $x = $associator2->predict([305, 306]);
        return $collection;

    }
    public function getProductDetail($data){
        return $this->productRepository->getById($data);
    }
}
