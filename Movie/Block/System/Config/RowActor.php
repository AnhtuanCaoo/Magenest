<?php
namespace Magenest\Movie\Block\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
class RowActor extends \Magento\Config\Block\System\Config\Form\Field
{    
    private $_resultCollection;
    private $_scopeConfigInterface;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Actor\Collection $resultCollection,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
        array $data = []
    ) {
        $this->_resultCollection = $resultCollection;
        $this->_scopeConfigInterface = $scopeConfigInterface;
        parent::__construct($context, $data);
    }

    

    protected function _getElementHtml(AbstractElement $element)
    {           
        // $data = $this->_scopeConfigInterface->getValue('movie/magenest_movie/custom_select_field',\Magento\Store\Model\ScopeInterface::SCOPE_STORE,);       
        $element->setReadonly('true');
        $value = $this->_resultCollection->countRowInTable();
        $html = $element->getElementHtml();
        $html .= '<script type="text/javascript">
        require(["jquery"], function($) {
            $(document).ready(function(e) {
                $("#'.$element->getHtmlId().'").val('.$value.');
            });
        });
        </script>';
        return $html;
        
    }
    
    
}



