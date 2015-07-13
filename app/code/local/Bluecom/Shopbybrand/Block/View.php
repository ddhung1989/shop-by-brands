<?php
class Bluecom_Shopbybrand_Block_View extends Mage_Core_Block_Template {
	public function _prepareLayout() {
		return parent::_prepareLayout();
	}
	
	public function getStoreId() {
		$storeId = Mage::app()->getStore()->getId();
		return $storeId;
	}
	
	public function getBrand() {
		return Mage::getModel('bluecom_shopbybrand/brand')->load(Mage::app()->getRequest()->getParam('id'));
	}
	
	protected function _getProductCollection() {
		$websiteId = Mage::app()->getWebsite()->getId();
		$storeId = $this->getStoreId();
		$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
		$brand = $this->getBrand();
		$optionId = $brand->getOptionId();
		
		$collection = Mage::getModel('catalog/product')
				->getCollection()
				->addWebsiteFilter($websiteId)
				->addStoreFilter($storeId)
				->addAttributeToSelect('*')
				->addAttributeToFilter($attributeCode, $optionId)
				->addMinimalPrice()
				->addFinalPrice()
				->addTaxPercents();
		
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		
		//die(var_dump($collection->getData()));
		return $collection;
	}
	
	public function setListCollection() {
		$this->getChild('product_list')->setCollection($this->_getProductCollection());
	}
}