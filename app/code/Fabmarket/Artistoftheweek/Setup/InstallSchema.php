<?php
/**
 * Copyright © 2015 Fabmarket. All rights reserved.
 */

namespace Fabmarket\Artistoftheweek\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'artistoftheweek_index'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('artistoftheweek_index')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'artistoftheweek_index'
        )
		->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'title'
        )
		->addColumn(
            'sortdescription',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'sortdescription'
        )
		->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'description'
        )
		->addColumn(
            'audiourl',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'audiourl'
        )
		->addColumn(
            'imageurl',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'imageurl'
        )
		->addColumn(
            'linkurl',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'linkurl'
        )
		->addColumn(
            'extrainfo',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'extrainfo'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Fabmarket Artistoftheweek artistoftheweek_index'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/

        $installer->endSetup();

    }
}
