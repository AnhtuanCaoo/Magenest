<?php
namespace Magenest\Checkout\Block\Cart\Item;
use Magento\Catalog\Model\Product\Configuration\Item\ItemResolverInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;
use Magento\Framework\View\Element\Template;

class Renderer extends \Magento\Checkout\Block\Cart\Item\Renderer implements
\Magento\Framework\DataObject\IdentityInterface {

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Catalog\Helper\Product\Configuration $productConfig, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder, \Magento\Framework\Url\Helper\Data $urlHelper, \Magento\Framework\Message\ManagerInterface $messageManager, PriceCurrencyInterface $priceCurrency, \Magento\Framework\Module\Manager $moduleManager, InterpretationStrategyInterface $messageInterpretationStrategy, array $data = [], ItemResolverInterface $itemResolver = null)
    {
        parent::__construct($context, $productConfig, $checkoutSession, $imageBuilder, $urlHelper, $messageManager, $priceCurrency, $moduleManager, $messageInterpretationStrategy, $data, $itemResolver);
    }
    public function getProductName()
    {
        if ($this->hasProductName()) {
            return $this->getData('product_name');
        }
        return $this->getProduct()->getSku();
    }


}
