<?php
class Extension_Shopbybrand_Model_Mysql4_Brand_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
	protected function _construct() {
		$this->_init('extension_shopbybrand/brand');
	}
}