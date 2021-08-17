<?php
namespace Magenest\BuyNow\Block\Product;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ProductList\Item\Block;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Url\Helper\Data as UrlHelper;

class Detail extends Block
{
    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * ListProduct constructor.
     * @param Context $context
     * @param UrlHelper $urlHelper
     * @param array $data
     */
    protected $userContext;
    public function __construct(
        UserContextInterface $userContext,
        Context $context,
        UrlHelper $urlHelper,
        array $data = []
    ) {
        $this->userContext = $userContext;
        $this->urlHelper = $urlHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get post parameters
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return array
     */
    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $product)
    {
        $url = $this->getAddToCartUrl($product);
        return [
            'action' => $url,
            'data' => [
                'product' => $product->getEntityId(),
                ActionInterface::PARAM_NAME_URL_ENCODED => $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }
    public function getCustomerId(){
        if($this->userContext->getUserId() != null){

            return 1;
        }
        else return 0;
    }
}
