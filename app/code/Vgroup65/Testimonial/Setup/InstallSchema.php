<?php

namespace Vgroup65\Testimonial\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $setup->startSetup();

        //testimonial table
        $table = $setup->getConnection()->newTable(
                        $setup->getTable('vgroup_testimonial')
                )->addColumn(
                        'testimonial_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Testimonial Id'
                )->addColumn(
                        'first_name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'First Name'
                )->addColumn(
                        'last_name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Last Name'
                )
                ->addColumn(
                        'gender', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Gender'
                )
                ->addColumn(
                        'age', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Age'
                )
                ->addColumn(
                        'designation', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Designation'
                )
                ->addColumn(
                        'company', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Company'
                )
                ->addColumn(
                        'image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'Image'
                )
                ->addColumn(
                    'resize_image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'Resize Image'
                )
                ->addColumn(
                        'testimonial', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'Testimonial'
                )
                ->addColumn(
                        'website', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Website'
                )
                ->addColumn(
                        'address', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'Address'
                )
                ->addColumn(
                        'city', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'City'
                )
                ->addColumn(
                        'state', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'State'
                )
                ->addColumn(
                        'country', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Country'
                )
                ->addColumn(
                        'status', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 255, ['nullable' => false, 'default' => '1'], 'Status'
                )->addColumn(
                        'created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, ['nullable' => false], 'Created At'
                )
                ->setComment(
                'Vgroup Testimonial Table'
        );
        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }

}
