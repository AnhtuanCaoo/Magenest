<?php

namespace Magenest\Ecommerce\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Zend_Validate_Exception;

class AvatarUrl implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * Example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - then under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     *
     * @return void
     * @throws LocalizedException
     * @throws Zend_Validate_Exception
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('customer', 'avatar_url', [
            'type' => 'text',
            'label' => 'Avatar url',
            'input' => 'text',
            'backend' => '',
            'default' => '',
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'visible' => false,
            'used_in_product_listing' => true,
            'user_defined' => true,
            'required' => false,
            'group' => 'General',
            'sort_order' => 10,
        ]);
        $attribute = $eavSetup->getEavConfig()->getAttribute('customer', 'avatar_url')->addData([
            'used_in_forms' => [
                'adminhtml_customer'
            ]
        ]);
        $attribute->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
