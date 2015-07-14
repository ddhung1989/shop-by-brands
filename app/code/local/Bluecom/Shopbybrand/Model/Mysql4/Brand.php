<?php
class Bluecom_Shopbybrand_Model_Mysql4_Brand extends Mage_Core_Model_Mysql4_Abstract {
	protected function _construct() {
		$this->_init('bluecom_shopbybrand/brand', 'brand_id');
	}
	
	public function getOption($allStore = false) {
		$prefix = (string)Mage::getConfig()->getTablePrefix();
		$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
		$select = $this->_getReadAdapter()->select()
			->from(array('eao' 	=> $prefix . 'eav_attribute_option'), array('option_id', 'eaov.value', 'eaov.store_id'))
			->join(array('ea'	=> $prefix . 'eav_attribute'), 'eao.attribute_id = ea.attribute_id', array())
			->join(array('eaov'	=> $prefix . 'eav_attribute_option_value'), 'eao.option_id = eaov.option_id', array())
			->where('ea.attribute_code = ?', $attributeCode);
		
		if ($allStore) {
			$select->where('eaov.store_id = ?', 0);
		} else {
			$select->where('eaov.store_id != ?', 0);
		}
		
		$option = $this->_getReadAdapter()->fetchAll($select);
		return $option;
	}
	
	public function addOption($brand) {
		$prefix = (string)Mage::getConfig()->getTablePrefix();
		$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
		$brandStoreId = 0;
		$brandOptionId = $brand->getOptionId();
		$brandName = $brand->getName();
		
		if ($brandOptionId) {
			if ($brand->getStoreId()) {
				$brandStoreId = $brand->getStoreId();
			}
			
			$select = $this->_getReadAdapter()->select()
				->from(array('eao' 	=> $prefix . 'eav_attribute_option'), array('option_id', 'eaov.value', 'eaov.store_id'))
				->join(array('ea'	=> $prefix . 'eav_attribute'), 'eao.attribute_id = ea.attribute_id', array())
				->join(array('eaov'	=> $prefix . 'eav_attribute_option_value'), 'eao.option_id = eaov.option_id', array())
				->where('ea.attribute_code = ?', $attributeCode)
				->where('eao.option_id = ?', $brandOptionId)
				->where('eaov.store_id = ?', $brandStoreId)
			;
			
			$storeValues = $this->_getReadAdapter()->fetchAll($select);
			if (count($storeValues)) {
				foreach ($storeValues as $value) {
					if (isset($value['value']) && $value['value']) {
						if ($value['value'] == $brandName) {
							return null;
						} else {
							$data = array(
								'value'	=> $brandName
							);
							$where = array(
								'option_id = ?'	=> $brandOptionId,
								'store_id = ?'	=> $brandStoreId
							);
							$this->_getWriteAdapter()->update($prefix . 'eav_attribute_option_value', $data, $where);
						}
					}
				}
			} else {
				$data = array(
					'value'		=> $brandName,
					'option_id'	=> $brandOptionId,
					'store_id'	=> $brandStoreId
				);
				$this->_getWriteAdapter()->insert($prefix . 'eav_attribute_option_value', $data);
			}
		} else {
			$attributeId = Mage::getSingleton('eav/config')
				->getAttribute('catalog_product', $attributeCode)
				->getId()
			;
			$setup = new Mage_Catalog_Model_Resource_Eav_Mysql4_Setup('catalog_setup');
			$option['attribute_id'] = $attributeId;
			
			if ($brand->getStoreId()) {
				$option['value']['option'][$brand->getStoreId()] = $brandName;
			} else {
				$option['value']['option'][0] = $brand->getName();
			}
			
			$setup->addAttributeOption($option);
			
			// Get option id
			$select = $this->_getReadAdapter()->select()
				->from(array('eao'	=> $prefix . 'eav_attribute_option'), array('option_id', 'eaov.value', 'eaov.store_id'))
				->join(array('ea'	=> $prefix . 'eav_attribute'), 'eao.attribute_id = ea.attribute_id', array())
				->join(array('eaov'	=> $prefix . 'eav_attribute_option_value'), 'eao.option_id = eaov.option_id', array())
				->where('ea.attribute_code = ?', $attributeCode)
				->where('eaov.value = ?', $brandName)
				->where('eaov.store_id = ?', $brandStoreId)
			;
			
			$option = $this->_getReadAdapter()->fetchAll($select);
			if (count($option)) {
				$optionId = $option[0]['option_id'];
				return $optionId;
			}
		}
		
		return null;
	}
	
	public function removeOption($brand) {
		$brandStoreId = 0;
		if ($brand->getOptionId()) {
			if ($brand->getStoreId()) {
				$brandStoreId = $brand->getStoreId();
			}
			$option = Mage::getModel('eav/entity_attribute_option')->load($brand->getOptionId());
			
			try {
				$option->delete();
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
	}
	
	public function getAttributeOptions($value) {
		$prefix = (string)Mage::getConfig()->getTablePrefix();
		$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
		
		$select = $this->_getReadAdapter()->select()
			->from(array('eao' 	=> $prefix . 'eav_attribute_option'), array('option_id', 'eaov.value', 'eaov.store_id'))
			->join(array('ea'	=> $prefix . 'eav_attribute'), 'eao.attribute_id = ea.attribute_id', array())
			->join(array('eaov'	=> $prefix . 'eav_attribute_option_value'), 'eao.option_id = eaov.option_id', array())
			->where('ea.attribute_code = ?', $attributeCode)
			->where('eaov.value = ?', $value)
		;
		$option = $this->_getReadAdapter()->fetchAll($select);
		
		return $option;
	}
}