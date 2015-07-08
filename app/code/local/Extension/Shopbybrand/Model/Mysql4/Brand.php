<?php
class Extension_Shopbybrand_Model_Mysql4_Brand extends Mage_Core_Model_Mysql4_Abstract {
	protected function _construct() {
		$this->_init('extension_shopbybrand/brand', 'brand_id');
	}
}