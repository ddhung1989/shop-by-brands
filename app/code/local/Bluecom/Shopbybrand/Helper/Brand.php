<?php
class Bluecom_Shopbybrand_Helper_Brand extends Mage_Core_Helper_Abstract {
	public function getAttributeCode() {
		return 'manufacturer';
	}
	
	public function insertBrandFromOption($option) {
		if (isset($option['store_id'])) {
			$model = Mage::getModel('bluecom_shopbybrand/brand')
				->load($option['option_id'], 'option_id');
			
			$data['name'] = $option['value'];
			$data['option_id'] = $option['option_id'];
			$data['product_ids'] = implode(',', $model->getProductIds());
			$data['status'] = 1;
			$data['created_time'] = now();
			$data['update_time'] = now();
			
			$model->addData($data)
				->setStoreId($option['store_id']);
			$model->save();
			;
		}
	}
	
	public function updateProductsForBrands($productIds, $newBrand) {
		// Update for old brands
		$brandCollection = Mage::getModel('bluecom_shopbybrand/brand')
			->getCollection()
			->addFieldToFilter('brand_id', array('neq'	=> $newBrand->getId()))
			;
        foreach ($productIds as $productId) {
            foreach ($brandCollection as $brand) {
				$brandProductIds = $brand->getData('product_ids');
                $pos = strpos($brandProductIds, $productId);
				if ($pos === 0) {
					if ($productId == $brandProductIds) {
						$brandProductIds = '';
					} else {
						$brandProductIds = str_replace($productId . ',', '', $brandProductIds);
					}
				} elseif ($pos > 0) {
					$brandProductIds = str_replace(',' . $productId, '', $brandProductIds);
				} else {
                    continue;
                }
                
                $brand->setProductIds($brandProductIds)->save();
				break;
            }
        }		
			
		if ($newBrand->getId()) {	
			// Update for new brand
			if ($newBrand->getData('product_ids')) {
				$newBrand->setProductIds($newBrand->getData('product_ids') . ',' . implode(',', $productIds))->save();
			} else {
				$newBrand->setProductIds(implode(',', $productIds))->save();
			}
		}
	}
}