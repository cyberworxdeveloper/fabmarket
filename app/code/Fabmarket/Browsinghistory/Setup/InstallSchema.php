<?php
/**
 * Copyright © 2015 Fabmarket. All rights reserved.
 */

namespace Fabmarket\Browsinghistory\Setup;

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
         * Create table 'browsinghistory_index'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('browsinghistory_index')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'browsinghistory_index'
        )
		->addColumn(
            'customerid',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'customerid'
        )
		->addColumn(
            'productid',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'productid'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Fabmarket Browsinghistory browsinghistory_index'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/

        $installer->endSetup();

    }
}
