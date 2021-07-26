<?php
namespace Magenest\Ecommerce\Ui\DataProvider\Modifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

class Fields extends AbstractModifier
{
    private $locator;
    public function __construct(
        LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }
    public function modifyData(array $data)
    {
        $product   = $this->locator->getProduct();
        $productId = $product->getId();
        $data = array_replace_recursive(
            $data, [
            $productId => [

                    'dynamic_rows'=>[
                        '0' =>[
                            'link' => 'example.com'
                        ]
                    ]
                ]

        ]);
        return $data;
    }

    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
