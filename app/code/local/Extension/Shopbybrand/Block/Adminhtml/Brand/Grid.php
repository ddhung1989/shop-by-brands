<?php
class Extension_Shopbybrand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		
		// Set some defaults for our grid
		$this->setDefaultSort('id');
		$this->setId('extension_shopbybrand_brand_grid');
		$this->setDefaultDir('asc');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _getCollectionClass() {
		// This is the model we are using for the grid
		return 'extension_shopbybrand/brand_collection';
	}
	
	protected function _prepareCollection() {
		// Get and set our collection for the grid
		$collection = Mage::getResourceModel($this->_getCollectionClass());
		$this->setCollection($collection);
		
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns() {
		// Add the columns that should appear in the grid
		$this->addColumn('id',
			array(
				'header' => $this->__('ID'),
				'align'  => 'right',
				'width'  => '50px',
				'index'  => 'id'
			)
		);
		
		$this->addColumn('name',
			array(
				'header' => $this->__('Name'),
				'index'  => 'name'
			)
		);
		
		return parent::_prepareColumns();
	}
	
	public function getRowUrl($row) {
		// This is where our row data will link to
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}