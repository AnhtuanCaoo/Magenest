<?php
namespace Magenest\Movie\Block\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
class RowMovie extends \Magento\Config\Block\System\Config\Form\Field
{    
    private $_resultCollection;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Movie\Collection $resultCollection,
        array $data = []
    ) {
        $this->_resultCollection = $resultCollection;
        parent::__construct($context, $data);
    }
    protected function _getElementHtml(AbstractElement $element)
    {   
        $element->setReadonly('true');

        $html = $element->getElementHtml();
        $value = $this->_resultCollection->countRowInTable();
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



