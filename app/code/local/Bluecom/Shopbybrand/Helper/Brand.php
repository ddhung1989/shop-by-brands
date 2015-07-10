<?php
class Bluecom_Shopbybrand_Helper_Brand extends Mage_Core_Helper_Abstract {
	public function getAttributeCode() {
		return 'manufacturer';
	}
	
	public function insertBrandFromOption($option) {
		if (isset($option['store_id'])) {
			$model = Mage::getModel('bluecom_shopbybrand/brand');
			$data['name'] = $option['value'];
			$data['option_id'] = $option['option_id'];
			$data['product_ids'] = $model->getProductIds();
			$data['status'] = 1;
			$data['created_time'] = now();
			$data['update_time'] = now();
			
			$model = Mage::getModel('bluecom_shopbybrand/brand');
			$mode->setData($data)
				->setStoreId($option['store_id'])
				->save();
			;
		}
	}
}