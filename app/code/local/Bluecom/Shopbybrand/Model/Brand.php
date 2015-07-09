<?php
class Bluecom_Shopbybrand_Model_Brand extends Mage_Core_Model_Abstract {
	protected $_storeId = null;
	protected $_productIds = array();
	
	public function getStoreId() {
		return $this->_storeId;
	}
	
	public function setStoreId($storeId) {
		$this->_storeId = $storeId;
		return $this;
	}
		
	// "Override"" this function to get all product ids that have been having this brand in catalog tables.
	public function getProductIds() {
		if (count($this->_productIds) == 0) {
			if ($this->getId()) {
				$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
				$optionId = $this->getOptionId();
				$collection = Mage::getModel('catalog/product')
						->getCollection()
						->addAttributeToSelect('*')
						->addAttributeToFilter($attributeCode, $optionId);
				$this->_productIds = $collection->getAllIds();
			}
		}
		
		return $this->_productIds;
	}
		
	protected function _construct() {
		$this->_init('bluecom_shopbybrand/brand');
	}
}