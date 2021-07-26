<?php

namespace Magenest\Ecommerce\Block\Config;
use Magento\Customer\Model\ResourceModel\Group\Collection;
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $groupCollectionFactory;
    public function __construct(
        Collection $groupCollectionFactory
    )
    {
        $this->groupCollectionFactory = $groupCollectionFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $group = $this->groupCollectionFactory->toOptionArray();

        return $group;
    }
}
