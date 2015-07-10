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
	
	public function getStoreAttributes() {
		return array(
			'name',
			'description',
			'status'
		);
	}
	
	public function load($id, $field = null) {
		parent::load($id, $field);
		$this->loadStoreValue();
		
		return $this;
	}
	
	public function loadStoreValue() {
		$storeId = $this->getStoreId();
		if (!$storeId) {
			return $this;
		}
		
		$storeValues = Mage::getModel('bluecom_shopbybrand/brandvalue')
			->getCollection()
			->addFieldToFilter('brand_id', $this->getId())
			->addFieldToFilter('store_id', $storeId);
		
		foreach ($storeValues as $value) {
			$this->setData($value->getAttributeCode() . '_in_store', true);
			$this->setData($value->getAttributeCode(), $value->getValue());
		}
		
		return $this;
	}
	
	// "Override" this function to get all product ids that have been having this brand in catalog tables.
	public function getProductIds() {
		if (count($this->_productIds) == 0) {
			//if ($this->getId()) {
				$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
				$optionId = $this->getOptionId();
				$collection = Mage::getModel('catalog/product')
						->getCollection()
						->addAttributeToSelect('*')
						->addAttributeToFilter($attributeCode, $optionId);
				$this->_productIds = $collection->getAllIds();
			//}
		}
		
		return $this->_productIds;
	}
	
	protected function _beforeSave() {
		if ($storeid = $this->getStoreId()) {
			$defaultBrand = Mage::getModel('bluecom_shopbybrand/brand')->load($this->getId());
			$storeAttributes = $this->getStoreAttributes();
			
			foreach ($storeAttributes as $attribute) {
				// Set store value
				if ($this->getData($attribute . '_default')) {
					$this->setData($attribute . '_in_store', false);
				} else {
					$this->setData($attribute . '_in_store', true);
					$this->setData($attribute . '_value', $this->getData($attribute));
				}
				
				// Set default value back to its original
				$this->setData($attribute, $defaultBrand->getData($attribute));
			}
		}
		
		return parent::_beforeSave();
	}
	
	protected function _afterSave() {
		if ($storeId = $this->getStoreId()) {
			$storeAttributes = $this->getStoreAttributes();
			
			foreach ($storeAttributes as $attribute) {
				$attributeValue = Mage::getModel('bluecom_shopbybrand/brandvalue')
					->loadAttributeValue($this->getId(), $storeId, $attribute);
				
				if ($this->getData($attribute . '_in_store')) {
					try {
						$attributeValue->setValue($this->getData($attribute . '_value'))
							->save();
					} catch (Exception $e) {
						// Fail quietly..
					}
				} elseif ($attributeValue && $attributeValue->getId()) { // This case ever happens?
					try {
						$attributeValue->delete();
					} catch (Exception $e) {
						// Fail quietly..
					}
				}
			}
		}
		
		return parent::_afterSave();
	}
	
	protected function _construct() {
		$this->_init('bluecom_shopbybrand/brand');
	}
}