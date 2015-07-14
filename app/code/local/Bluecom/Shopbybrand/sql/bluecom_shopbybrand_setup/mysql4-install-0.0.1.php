<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'bluecom_shopbybrand_brand'
 * Create table 'bluecom_shopbybrand_brand_store_value'
 */
$brandTable = $installer->getConnection()
	// The following call to getTable('bluecom_shopbybrand') will lookup the resource for bluecom_shopbybrand (bluecom_shopbybrand_mysql4), and lookup
	// for a corresponding entity called brand. The table name in the XML is bluecom_shopbybrand, so this is what is created.
	->newTable($installer->getTable('bluecom_shopbybrand/brand'))
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

$brandValueTable = $installer->getConnection()
	->newTable($installer->getTable('bluecom_shopbybrand/brandvalue'))
	->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
		'identity' 	=> true,
		'unsigned' 	=> true,
		'nullable' 	=> false,
		'primary' 	=> true,
	  ), 'Value Id')
	->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
		'unsigned' 	=> true,
		'nullable' 	=> false,
	  ), 'Brand Id')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
		'unsigned' 	=> true,
		'nullable' 	=> false,
	  ), 'Store Id')
	->addColumn('attribute_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' 	=> false,
		'default'	=> '',
	  ), 'Attribute Code')
	->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable' 	=> false,
	  ), 'Brand Id')
	->addIndex(
		$installer->getIdxName('bluecom_shopbybrand/brandvalue', array('brand_id')),
		array('brand_id'),
		array(
			'type'	=> Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
		)
	  )
	->addIndex(
		$installer->getIdxName('bluecom_shopbybrand/brandvalue', array('brand_id')),
		array('store_id'),
		array(
			'type'	=> Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
		)
	  )
	->addIndex(
		$installer->getIdxName('bluecom_shopbybrand/brandvalue', array('brand_id')),
		array('attribute_ocde'),
		array(
			'type'	=> Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
		)
	  )  
	->addIndex(
		$installer->getIdxName('bluecom_shopbybrand/brandvalue', array('brand_id')),
		array('brand_id')
	  )
	->addIndex(
		$installer->getIdxName('bluecom_shopbybrand/brandvalue', array('store_id')),
		array('store_id')
	  )
	->addForeignKey(
		$installer->getFkName(
			'bluecom_shopbybrand/brandvalue',
			'brand_id',
			'bluecom_shopbybrand/brand',
			'brand_id'
		),
		'brand_id',
		$installer->getTable('bluecom_shopbybrand/brand'),
		'brand_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE,
		Varien_Db_Ddl_Table::ACTION_CASCADE
	  )
	->addForeignKey(
		$installer->getFkName(
			'bluecom_shopbybrand/brandvalue',
			'store_id',
			'core/store',
			'store_id'
		),
		'store_id',
		$installer->getTable('core/store'),
		'store_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE,
		Varien_Db_Ddl_Table::ACTION_CASCADE
	  )
	;
	
$installer->getConnection()->createTable($brandTable);
$installer->getConnection()->createTable($brandValueTable);

$installer->endSetup();

Mage::helper('bluecom_shopbybrand/brand')->insertBrandsFromCatalog();