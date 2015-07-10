<?php
class Bluecom_Shopbybrand_Model_Brandvalue extends Mage_Core_Model_Abstract {
	public function _construct() {
		//parent::_construct();
		$this->_init('bluecom_shopbybrand/brandvalue');
	}
	
	public function loadAttributeValue($brandId, $storeId, $attributeCode) {
		$attributeValue = $this->getCollection()
			->addFieldToFilter('brand_id', $brandId)
			->addFieldToFilter('store_id', $storeId)
			->addFieldToFilter('attribute_code', $attributeCode)
			->getFirstItem();
		
		// Initialize its data if this attribute hasn't been saved
		$this->setData('brand_id', $brandId)
			->setData('store_id', $storeId)
			->setData('attribute_code', $attributeCode);
		
		// Seemed like $this doesn't have enough data so need to get it from $attributeValue
		$this->addData($attributeValue->getData())
			->setId($attributeValue->getId());
		
		return $this;
	}
}