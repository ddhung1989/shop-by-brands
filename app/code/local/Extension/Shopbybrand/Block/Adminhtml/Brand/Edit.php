<?php
class Extension_Shopbybrand_Block_Adminhtml_Brand_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
	/**
	 * Init class
	 */
	public function __construct() {
		$this->_blockGroup = 'extension_shopbybrand';
		$this->_controller = 'adminhtml_brand';
		
		parent::__construct();
		
		$this->_updateButton('save', 'label', $this->__('Save Brand'));
		$this->_updateButton('delete', 'label', $this->__('Delete Brand'));
	}
	
	/**
	 * Get Header text
	 *
	 * @return string
	 */
	public function getHeaderText() {
		if (Mage::registry('extension_shopbybrand') && Mage::registry('extension_shopbybrand')->getId()) {
			return $this->__('Edit Brand');
		} else {
			return $this->__('New Brand');
		}
	}
}