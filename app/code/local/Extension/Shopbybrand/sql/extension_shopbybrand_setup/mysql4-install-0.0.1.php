<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'extension_shopbybrand'
 */
$table = $installer->getConnection()
	// The following call to getTable('extension_shopbybrand') will lookup the resource for extension_shopbybrand (extension_shopbybrand_mysql4), and lookup
	// for a corresponding entity called brand. The table name in the XML is extension_shopbybrand, so this is what is created.
	->newTable($installer->getTable('extension_shopbybrand'))
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity' => true,
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
	), 'ID')
	->addColumn('name', Varien_Db_Ddl_Table::TYPE_CLOB, 0, array(
		'nullable' => false,
	), 'Name');
$installer->getConnection()->createTable($table);

$installer->endSetup();