<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
	/**
	 * Init class
	 */
	public function __construct() {
		$this->_blockGroup = 'bluecom_shopbybrand';
		$this->_controller = 'adminhtml_brand';
		
		parent::__construct();
		
		$this->_updateButton('save', 'label', $this->__('Save Brand'));
		$this->_updateButton('delete', 'label', $this->__('Delete Brand'));
		
		$this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
		
		$this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action + 'back/edit/');
            }
			
			if ($('icon').parentNode.childElementCount == 1) {
				$('icon').addClassName('required-file');
			}
			
			if ($('image').parentNode.childElementCount == 1) {
				$('image').addClassName('required-file');
			}
        ";
	}
	
	/**
	 * Get Header text
	 *
	 * @return string
	 */
	public function getHeaderText() {
		if (Mage::registry('bluecom_shopbybrand') && Mage::registry('bluecom_shopbybrand')->getId()) {
			return $this->__('Edit Brand');
		} else {
			return $this->__('New Brand');
		}
	}
}