<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		
		// Set some defaults for our grid
		$this->setDefaultSort('brand_id');
		$this->setId('bluecom_shopbybrand_brand_grid');
		$this->setDefaultDir('asc');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _getCollectionClass() {
		// This is the model we are using for the grid
		return 'bluecom_shopbybrand/brand_collection';
	}
	
	protected function _prepareCollection() {
		// Get and set our collection for the grid
		$collection = Mage::getResourceModel($this->_getCollectionClass());
		$this->setCollection($collection);
		
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns() {
		// Add the columns that should appear in the grid
		$this->addColumn('brand_id', array(
            'header'    => Mage::helper('bluecom_shopbybrand')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'brand_id',
            'filter_index'=>'main_table.brand_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('bluecom_shopbybrand')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));
        
        $this->addColumn('image', array(
            'header'    => Mage::helper('bluecom_shopbybrand')->__('Image'),
            'width'     => '150px',
            'index'     => 'image',
            'filter'    => false,
            'sortable'  => false,
            'renderer'  => 'bluecom_shopbybrand/adminhtml_brand_renderer_image'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('bluecom_shopbybrand')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action', array(
            'header'    =>    Mage::helper('bluecom_shopbybrand')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'    => Mage::helper('bluecom_shopbybrand')->__('Edit'),
                    'url'        => array('base'=> '*/*/edit/store/'.$this->getRequest()->getParam('store')),
                    'field'      => 'id'
                )),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
        ));
		
		return parent::_prepareColumns();
	}
	
	public function getRowUrl($row) {
		// This is where our row data will link to
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}