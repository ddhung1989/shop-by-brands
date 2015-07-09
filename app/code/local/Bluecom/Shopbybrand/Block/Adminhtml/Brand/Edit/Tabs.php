<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
	public function __construct() {
        parent::__construct();
		
        $this->setId('bluecom_shopbybrand_brand_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bluecom_shopbybrand')->__('Brand Information'));
    }

    /**
     * prepare before render block to html
     *
     * @return Magestore_Shopbybrand_Block_Adminhtml_Shopbybrand_Edit_Tabs
     */
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' 	=> Mage::helper('bluecom_shopbybrand')->__('General Information'),
            'title' 	=> Mage::helper('bluecom_shopbybrand')->__('General Information'),
            'content' 	=> $this->getLayout()
							->createBlock('bluecom_shopbybrand/adminhtml_brand_edit_tab_form')
							->toHtml(),
        ));

        $this->addTab('image', array(
            'label' 	=> Mage::helper('bluecom_shopbybrand')->__('Images'),
            'title'		=> Mage::helper('bluecom_shopbybrand')->__('Images'),
			'content'	=> $this->getLayout()
							->createBlock('bluecom_shopbybrand/adminhtml_brand_edit_tab_images')
							->toHtml(),
        ));
        
		$this->addTab('product', array(
            'label' => Mage::helper('bluecom_shopbybrand')->__('Products'),
            'url' => $this->getUrl('*/*/product', array('_current' => true)),
            'class' => 'ajax',
        ));
		
        return parent::_beforeToHtml();
    }
}