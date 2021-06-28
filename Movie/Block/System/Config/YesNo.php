<?php
namespace Magenest\Movie\Block\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
class YesNo extends \Magento\Config\Block\System\Config\Form\Field
{    

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    protected function _getElementHtml(AbstractElement $element)
    {   

        $html = $element->getElementHtml();
        // $html .= '<div> ok </div>';
        $html .= '<script type="text/javascript">
        require(["jquery"], function($) {
            $(document).ready(function(e) {
                $("#'.$element->getHtmlId().'").css("color", "red");

            });
        });
        </script>';
        return $html;
        
    }
    
}



