<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		// The blockGroup must match the first half of how we call the block, and controller matches the second half
		// i.e. bluecom_shopbybrand/adminhtml_brand
		$this->_blockGroup = 'bluecom_shopbybrand';
		$this->_controller = 'adminhtml_brand';
		$this->_headerText = $this->__('Brand');
		
		parent::__construct();
	}
}