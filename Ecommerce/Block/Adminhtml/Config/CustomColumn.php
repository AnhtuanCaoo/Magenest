<?php
/**
 * Created By : Rohan Hapani
 */
namespace Magenest\Ecommerce\Block\Adminhtml\Config;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use Magento\Customer\Model\ResourceModel\Group\Collection;

class CustomColumn extends Select
{
    protected $groupCollection;
    public function __construct(Context $context,
                                Collection $groupCollection,
                                array $data = []
    )
    {
        $this->groupCollection = $groupCollection;
        parent::__construct($context, $data);
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }
    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions())
        {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }
    private function getSourceOptions()
    {
        return $this->groupCollection->toOptionArray();
    }
}
