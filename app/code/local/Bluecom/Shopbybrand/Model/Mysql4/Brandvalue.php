<?php
class Bluecom_Shopbybrand_Model_Mysql4_Brandvalue extends Mage_Core_Model_Mysql4_Abstract {
	public function _construct() {
		$this->_init('bluecom_shopbybrand/brandvalue', 'value_id');
	}
}