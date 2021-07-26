<?php
/**
 * Created By : Rohan Hapani
 */
namespace Magenest\Ecommerce\Block\Adminhtml\Config;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magenest\Ecommerce\Block\Adminhtml\Config\CustomColumn;
class Ranges extends AbstractFieldArray
{
    /**
     * @var CustomColumn
     */
    private $dropdownRenderer;
    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareToRender()
    {

        $this->addColumn(
            'customer_group',
            [
                'label' => __('Group'),
                'renderer' => $this->getDropdownRenderer(),
                'style' => 'width:100px',
            ]
        );
        $this->addColumn(
            'start_time',
            [
                'label' => __('Start '),
                'class' => 'daterecuring',
                'style' => 'width:100px',

            ]
        );
        $this->addColumn(
            'end_time',
            [
                'label' => __('End '),
                'class' => 'daterecuring',
                'style' => 'width:100px',


            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
    /**
     * @param DataObject $row
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $options = [];
        $dropdownField = $row->getDropdownField();
        if ($dropdownField !== null)
        {
            $options['option_' . $this->getDropdownRenderer()->calcOptionHash($dropdownField)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
    /**
     * @return CustomColumn
     * @throws LocalizedException
     */
    private function getDropdownRenderer()
    {
        if (!$this->dropdownRenderer)
        {
            $this->dropdownRenderer = $this->getLayout()->createBlock(
                CustomColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]);
        }
        return $this->dropdownRenderer;
    }
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = parent::_getElementHtml($element);

        $script = '<script type="text/javascript">
                require(["jquery", "jquery/ui", "mage/calendar"], function (jq) {
                    jq(function(){
                        function bindDatePicker() {
                            setTimeout(function() {
                                jq(".daterecuring").datepicker( { dateFormat: "mm/dd/yy" } );
                            }, 50);
                        }
                        bindDatePicker();
                        jq("button.action-add").on("click", function(e) {
                            bindDatePicker();
                        });
                    });
                });
            </script>';
        $html .= $script;
        return $html;
    }
}
