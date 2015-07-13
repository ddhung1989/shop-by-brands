<?php
class Bluecom_Shopbybrand_Model_Observer {
	public function updateBrand($observer) {/*
		$attributeCode = Mage::helper('bluecom_shopbybrand/brand')->getAttributeCode();
		$attribute = $observer->getAttribute();
		
		if ($attribute->getAttributeCode() == $attributeCode) {
			$attributeOption = $attribute->getOption();
			$values = $attributeOption['value'];
			$deletes = $attributeOption['delete'];
			$stores = Mage::getModel('core/store')
				->getCollection()
				->addFieldToFilter('store_id', array('neq'	=> 0))
			;
			
			foreach ($values as $id => $option) {
				if (intval($id) == 0) { // This option just has been added
					$optionDatabase = Mage::getResourceModel('bluecom_shopbybrand/brand')->getAttributeOptions($option[0]);
					$optionDatabase = $optionDatabase[0];
					if ($optionDatabase['option_id']) {
						$id = $optionDatabase['option_id'];
					}
				}
				
				$brand = Mage::getModel('bluecom_shopbybrand/brand')->load($id, 'option_id');
				
				if (isset($deletes[$id]) && $deletes[$id]) {
					$brand->delete();
				} else {
					$op['store_id'] = 0;
					$op['option_id'] = $id;
					$op['value'] = $option[0];
					Mage::helper('bluecom_shopbybrand/brand')->insertBrandFromOption($op);
					
					foreach ($stores as $store) {
						if (isset($option[$store->getId()]) && $option[$store->getId()]) {
							$brand = Mage::getModel('bluecom_shopbybrand/brand')->load($id, 'option_id');
							$brandValue = Mage::getModel('bluecom_shopbybrand/brandvalue')->loadAttributeValue($brand->getId(), $store->getId(), 'name');
							if ($brandValue->getValue() != $option[$store->getId()]) {
								$brandValue->setData('value', $option[$store->getId()])->save();
							}
						}
					}
				}
			}
		}*/
	}
	
	public function addTopMenu($observer) {
		$parent = new Varien_Data_Tree_Node(array(), 'id', new Varien_Data_Tree());
		$parent->addData(array(
					'name'		=> 'Brands',
					'id'		=> 'brands',
					'url'		=> Mage::getUrl('bluecom_shopbybrand'),
					'is_active'	=> false
				)
			);
		
		$brandCollection = Mage::getModel('bluecom_shopbybrand/brand')->getCollection();
		foreach ($brandCollection as $brand) {
			$child = new Varien_Data_Tree_Node(array(), 'id', new Varien_Data_Tree());
			$child->addData(array(
						'name'		=> $brand->getName(),
						'id'		=> 'brands-' . str_replace(' ', '-', $brand->getName()),
						'url'		=> 	Mage::getUrl('bluecom_shopbybrand/index/view', array('id'	=> $brand->getId())),
						'is_active'	=> false
					)
				);
			$parent->addChild($child);
		}
		
		$observer->getMenu()->addChild($parent);
	}
}