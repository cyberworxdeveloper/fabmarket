<?php
/**
 * Copyright © 2015 Fabmarket. All rights reserved.
 */

namespace Fabmarket\Subscribedetails\Setup;

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
         * Create table 'subscribedetails_index'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('subscribedetails_index')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'subscribedetails_index'
        )
		->addColumn(
            'quoteid',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'quoteid'
        )
		->addColumn(
            'noofepisode',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'noofepisode'
        )
		->addColumn(
            'itemid',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'itemid'
        )
		->addColumn(
            'customerid',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'customerid'
        )
		->addColumn(
            'produtid',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'produtid'
        )
		->addColumn(
            'frequency',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'frequency'
        )
		->addColumn(
            'subscriptionprice',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'subscriptionprice'
        )
		->addColumn(
            'productsku',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'productsku'
        )
		->addColumn(
            'subscriptiondate',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'subscriptiondate'
        )
		->addColumn(
            'flag',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'flag'
        )
		->addColumn(
            'nextepisodedate',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'nextepisodedate'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Fabmarket Subscribedetails subscribedetails_index'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/

        $installer->endSetup();

    }
}
