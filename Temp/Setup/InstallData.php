<?php
namespace Magenest\Temp\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'start',
            [
                'group' => 'Default',
                'label' => 'Start course',
                'type' => 'datetime',
                'input' => 'datetime',
                'class' => 'validate-datetime',
                'backend' => 'Magento\Catalog\Model\Attribute\Backend\Startdate',
                'required' => false,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'user_defined' => true,
                'default' => '',
                'searchable' => true,
                'filterable' => true,
                'filterable_in_search' => true,
                'visible_in_advanced_search' => true,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'end',
            [
                'group' => 'Default',
                'label' => 'End course',
                'type' => 'datetime',
                'input' => 'datetime',
                'class' => 'validate-datetime',
                'backend' => 'Magento\Catalog\Model\Attribute\Backend\Startdate',
                'required' => false,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'user_defined' => true,
                'default' => '',
                'searchable' => true,
                'filterable' => true,
                'filterable_in_search' => true,
                'visible_in_advanced_search' => true,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );
    }
}
