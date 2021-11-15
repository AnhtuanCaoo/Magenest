<?php

namespace Magenest\Checkout\Plugin;

use Magento\Checkout\Block\Checkout\LayoutProcessor as LayoutProcessorCore;
use Magento\Customer\Model\Session;

class Address
{
    /**
     * @var Session
     */
    protected $session;

    public function __construct(
        Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @param LayoutProcessorCore $subject
     * @param array $jsLayout
     *
     * @return array
     */
    public function afterProcess(
        LayoutProcessorCore $subject,
        array  $jsLayout
    ) {
        $customAttributeCode = 'vn_region';
        $customAttributeCode2 = 'privacy';
        $customAttributeCode3 = 'privacy_content';

        $customField = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'tooltip' => [
                    'description' => 'Select your region',
                ],

            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $customAttributeCode,
            'label' => 'Region',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'validation' => [
                'required-entry' => false
            ],
            'options' => [
                [
                    'value' => '',
                    'label' => 'Please Select',
                ],
                [
                    'value' => '1',
                    'label' => 'North Side',
                ],
                [
                    'value' => '2',
                    'label' => 'West Side',
                ],
                [
                    'value' => '1',
                    'label' => 'South Side',
                ]

            ],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];
        $customCheckbox = [
            'component' => 'Magento_Ui/js/form/element/single-checkbox',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'elementTmpl' => 'ui/form/element/checkbox',

            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $customAttributeCode2,
            'label' => 'I agree to all privacy above',
            'provider' => 'checkoutProvider',
            'sortOrder' => 999,
            'validation' => [
                'required-entry' => true
            ],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];
        $customPrivacy = [
            'component' => 'Magento_Ui/js/form/element/textarea',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/textarea',
                'tooltip' => [
                    'description' => 'Privacy',
                ]


            ],
            'label' => 'Privacy',
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $customAttributeCode3,
            'provider' => 'checkoutProvider',
            'sortOrder' => 998,
            'validation' => [
                'required-entry' => false
            ],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'disable' => true
        ];


            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode] = $customField;

//            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
//            ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode2] = $customCheckbox;

//            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
//            ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode3] = $customPrivacy;

            $configuration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'];
            foreach ($configuration as $paymentGroup => $groupConfig) {
                if (isset($groupConfig['component']) AND $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {

                    $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                    ['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['custom_attribute_code'] = $customField;
//                    $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
//                    ['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children'][$customAttributeCode2] = $customCheckbox;

                }
            }





        return $jsLayout;
    }
}
