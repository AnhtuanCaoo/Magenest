<?php
namespace Magenest\Frontend\Block\Adminhtml\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Color extends \Magento\Config\Block\System\Config\Form\Field {
    protected $_template = 'Magenest_Frontend::color.phtml';
    protected $config;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        ScopeConfigInterface $config,
        array $data = []
    ) {
        $this->config = $config;
        parent::__construct($context, $data);
    }
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {

        return $this->_toHtml();
    }
    public function getColor(){
        return json_decode($this->config->getValue('colors/color/option'));

    }

}
