<?php
class Bluecom_Shopbybrand_Block_Moreproduct extends Mage_Catalog_Block_Product_List_Upsell {
	public function getProduct() {
		$product = Mage::registry('current_product');
		return $product;
	}
	
	protected function _prepareData() {
		$product = $this->getProduct();
		$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
		$websiteId = Mage::app()->getWebsite()->getId();
		$storeId = Mage::app()->getStore()->getId();
		
		if ($product->getId()) {
			$optionId = $product->getData($attributeCode);
		}
		
		$this->_itemCollection = Mage::getModel('catalog/product')
						->getCollection()
						->addWebsiteFilter($websiteId)
						->addStoreFilter($storeId)
						->addAttributeToFilter('entity_id', array('neq' => $product->getId()))
						->addAttributeToSelect('*')
						->addAttributeToFilter($attributeCode, $optionId)
						;
						
		Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);
		
		$this->_itemCollection->load();
		
		return $this;
	}
}