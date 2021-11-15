<?php
namespace Magenest\NotificationBox\Block\Adminhtml\System\Config;

class Color extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Get element html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html  = $element->getElementHtml();
        $value = $element->getData('value');
        $html .= '<script type="text/javascript">
            require(["jquery","jquery/colorpicker/js/colorpicker"], function ($) {
                $(document).ready(function () {
                    var $currentelement = $("#' . $element->getHtmlId() . '");
                    $currentelement.css("backgroundColor", "' . $value . '");

                    // Attach the color picker
                    $currentelement.ColorPicker({
                        color: "' . $value . '",
                        onChange: function (hsb, hex, rgb) {
                            $currentelement.css("backgroundColor", "#" + hex).val("#" + hex);
                        }
                    });
                });
            });
            </script>';

        return $html;
    }
}
