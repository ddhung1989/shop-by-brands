<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'bluecom_shopbybrand'
 */
$table = $installer->getConnection()
	// The following call to getTable('bluecom_shopbybrand') will lookup the resource for bluecom_shopbybrand (bluecom_shopbybrand_mysql4), and lookup
	// for a corresponding entity called brand. The table name in the XML is bluecom_shopbybrand, so this is what is created.
	->newTable($installer->getTable('bluecom_shopbybrand'))
	->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
		'identity' 	=> true,
		'unsigned' 	=> true,
		'nullable' 	=> false,
		'primary' 	=> true,
	), 'Brand Id')
	->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' 	=> false,
		'default'	=> '',
	  ), 'Name')
	->addColumn('icon', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(		
	  ), 'Icon')
	->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
	), 'Image')
	->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable' 	=> false,
		'default'	=> '',
	  ), 'Description')
	->addColumn('option_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
	), 'Option Id')
	->addColumn('product_ids', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable' 	=> false,
		'default'	=> '',
	  ), 'Product Ids')
	->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
		'nullable' 	=> false,
		'default'	=> '0000-00-00 00:00:00',
	  ), 'Created Time')
	->addColumn('updated_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
		'nullable' 	=> false,
		'default'	=> '0000-00-00 00:00:00',
	  ), 'Updated Time')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
		'nullable' 	=> false,
		'default'	=> '1',
	  ), 'Status')
	;
	
$installer->getConnection()->createTable($table);

$installer->endSetup();