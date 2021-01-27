<?php

namespace Meetanshi\SocialMetaTag\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\Category;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallData
 * @package Meetanshi\SocialMetaTag\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            Product::ENTITY,
            'opengraph_meta_title',
            [
                'group' => 'Search Engine Optimization',
                'type' => 'text',
                'label' => 'Open Graph Title',
                'input' => 'text',
                'required' => false,
                'sort_order' => 51,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Product::ENTITY,
            'opengraph_meta_description',
            [
                'group' => 'Search Engine Optimization',
                'type' => 'text',
                'label' => 'Open Graph Description',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 52,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Product::ENTITY,
            'twitter_meta_title',
            [
                'group' => 'Search Engine Optimization',
                'type' => 'text',
                'label' => 'Twitter Title',
                'input' => 'text',
                'required' => false,
                'sort_order' => 53,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Product::ENTITY,
            'twitter_meta_description',
            [
                'group' => 'Search Engine Optimization',
                'type' => 'text',
                'label' => 'Twitter Description',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 54,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Product::ENTITY,
            'fb_share_image',
            [
                'type' => 'varchar',
                'label' => 'Open Graph Share Image',
                'input' => 'media_image',
                'frontend' => 'Magento\Catalog\Model\Product\Attribute\Frontend\Image',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'filterable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'sort_order' => 10,
                'required' => false,
            ]
        );
        $eavSetup->addAttribute(
            Product::ENTITY,
            'twitter_share_image',
            [
                'type' => 'varchar',
                'label' => 'Twitter Card Image',
                'input' => 'media_image',
                'frontend' => 'Magento\Catalog\Model\Product\Attribute\Frontend\Image',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'filterable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'sort_order' => 10,
                'required' => false,
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'fb_share_image',
            [
                'group' => 'Social Meta Information',
                'type' => 'varchar',
                'label' => 'Open Graph Image',
                'input' => 'image',
                'required' => false,
                'sort_order' => 54,
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'facebook_meta_title',
            [
                'group' => 'Social Meta Information',
                'type' => 'text',
                'label' => 'Open Graph Title',
                'input' => 'text',
                'required' => false,
                'sort_order' => 54,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'facebook_meta_description',
            [
                'group' => 'Social Meta Information',
                'type' => 'text',
                'label' => 'Open Graph Description',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 54,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'twitter_share_image',
            [
                'group' => 'Social Meta Information',
                'type' => 'varchar',
                'label' => 'Twitter Card Image',
                'input' => 'image',
                'required' => false,
                'sort_order' => 54,
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'twitter_meta_title',
            [
                'group' => 'Social Meta Information',
                'type' => 'text',
                'label' => 'Twitter Title',
                'input' => 'text',
                'required' => false,
                'sort_order' => 54,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'twitter_meta_description',
            [
                'group' => 'Social Meta Information',
                'type' => 'text',
                'label' => 'Twitter Description',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 54,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'fb_share_image',
            [
                'type' => Table::TYPE_TEXT,
                'length' => '255',
                'nullable' => true,
                'comment' => 'added from extension SocialMetaTags'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'facebook_meta_title',
            [
                'type' => Table::TYPE_TEXT,
                'length' => '255',
                'nullable' => true,
                'comment' => 'added from extension SocialMetaTags'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'facebook_meta_description',
            [
                'type' => Table::TYPE_TEXT,
                'length' => '255',
                'nullable' => true,
                'comment' => 'added from extension SocialMetaTags'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'twitter_share_image',
            [
                'type' => Table::TYPE_TEXT,
                'length' => '255',
                'nullable' => true,
                'comment' => 'added from extension SocialMetaTags'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'twitter_meta_title',
            [
                'type' => Table::TYPE_TEXT,
                'length' => '255',
                'nullable' => true,
                'comment' => 'added from extension SocialMetaTags'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'twitter_meta_description',
            [
                'type' => Table::TYPE_TEXT,
                'length' => '255',
                'nullable' => true,
                'comment' => 'added from extension SocialMetaTags'
            ]
        );

        $installer->endSetup();
    }
}
