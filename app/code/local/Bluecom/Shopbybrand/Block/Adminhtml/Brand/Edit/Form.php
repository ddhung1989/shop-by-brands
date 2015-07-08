<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {
	/**
	 * Init class
	 */
	public function __construct() {
		parent::__construct();
		
		$this->setId('bluecom_shopbybrand_brand_form');
		$this->setTitle($this->__('Brand Information'));
	}
	
	/**
	 * Setup form fields for inserts/updates
	 *
	 * return Mage_Adminhtml_Block_Widget_Form
	 */
	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
			'id'		=> 'edit_form',
			'action'	=> $this->getUrl('*/*/save', array(
				'id' 	=> $this->getRequest()->getParam('id'),
				'store'	=> $this->getRequest()->getParam('store'),
			)),
			'method'	=> 'post',
			'enctype'	=> 'multipart/form-data'
		));
		
		$form->setUseContainer(true);
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
}