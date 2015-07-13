<?php
class Bluecom_Shopbybrand_Block_Productinfo extends Mage_Core_Block_Template {
	public function _prepareLayout() {
		return parent::_prepareLayout();
	}
	
	public function getStoreId() {
		return Mage::app()->getStore()->getStoreId();
	}
	
	public function getProduct() {
		$product = Mage::registry('current_product');
		return $product;
	}
	
	public function getBrand() {
		$brand = Mage::getModel('bluecom_shopbybrand/brand');
		$product = $this->getProduct();
		$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
		
		if ($product->getId()) {
			$optionId = $product->getData($attributeCode);
			if ($optionId) {
				$brand->load($optionId, 'option_id');
			}
		}
		
		return $brand;
	}
}