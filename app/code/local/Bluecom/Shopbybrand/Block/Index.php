<?php
class Bluecom_Shopbybrand_Block_Index extends Mage_Core_Block_Template {
	protected $_brandCollection = null;
	
	public function _prepareLayout() {
		return parent::_prepareLayout();
	}
	
	public function getBrands() {
		if (is_null($this->_brandCollection)) {
			$brandCollection = Mage::getModel('bluecom_shopbybrand/brand')->getCollection();
			$this->_brandCollection = $brandCollection;
		}
		return $this->_brandCollection;
	}
}