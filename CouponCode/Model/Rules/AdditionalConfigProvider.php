<?php
namespace Magenest\CouponCode\Model\Rules;

use Magento\Framework\View\Asset\Repository;

class AdditionalConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    /**
     * @var Repository
     */
    protected $asset;
    /**
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\Collection
     */
    protected $_collection;

    /**
     * @var \Magenest\CouponCode\Model\Configurations
     */
    protected $_configurations;

    /**
     * @var \Magenest\CouponCode\Helper\Data
     */
    protected $_dataHelper;

    /**
     * AdditionalConfigProvider constructor.
     * @param Repository $asset
     * @param \Magento\SalesRule\Model\ResourceModel\Rule\Collection $collection
     * @param \Magenest\CouponCode\Model\Configurations $configurations
     * @param \Magenest\CouponCode\Helper\Data $dataHelper
     */
    public function __construct(
        Repository $asset,
        \Magento\SalesRule\Model\ResourceModel\Rule\Collection $collection,
        \Magenest\CouponCode\Model\Configurations $configurations,
        \Magenest\CouponCode\Helper\Data $dataHelper
    ) {
        $this->asset = $asset;
        $this->_configurations = $configurations;
        $this->_collection = $collection;
        $this->_dataHelper = $dataHelper;
    }

    /**
     * Get config
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig()
    {
        $rules = $this->_collection;
        $configurations = $this->_configurations->getData();
        foreach ($configurations as $configuration) {
            $rules = $configuration['class']->apply($rules);
        }

        $currentWebsiteId = $this->_dataHelper->getCurrentWebsiteId();
        $enableCouponListing = $this->_dataHelper->getEnableCouponListingConfiguration();
        $fieldDisplayListing = $this->_dataHelper->getFieldDisplayListingConfiguration();

        return ['rules' =>$rules->getData(),
            'website_id' => $currentWebsiteId,
            'enable' => $enableCouponListing,
            'fieldDisplay' => $fieldDisplayListing,
            'default_image' => $this->asset->getUrl('Magenest_CouponCode::image/default-coupon.png')
        ];
    }
}
