<?php
class Extension_Shopbybrand_Block_Adminhtml_Brand_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
	public function __construct() {
        parent::__construct();
		
        $this->setId('extension_shopbybrand_brand_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('extension_shopbybrand')->__('Brand Information'));
    }

    /**
     * prepare before render block to html
     *
     * @return Magestore_Shopbybrand_Block_Adminhtml_Shopbybrand_Edit_Tabs
     */
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('extension_shopbybrand')->__('General Information'),
            'title' => Mage::helper('extension_shopbybrand')->__('General Information'),
            'content' => $this->getLayout()
                    ->createBlock('extension_shopbybrand/adminhtml_brand_edit_tab_form')
                    ->toHtml(),
        ));

        $this->addTab('image', array(
            'label' => Mage::helper('extension_shopbybrand')->__('Images'),
            'url' => $this->getUrl('*/*/image', array('_current' => true)),
            'class' => 'ajax',
        ));
        
		$this->addTab('product', array(
            'label' => Mage::helper('extension_shopbybrand')->__('Products'),
            'url' => $this->getUrl('*/*/product', array('_current' => true)),
            'class' => 'ajax',
        ));
		
        return parent::_beforeToHtml();
    }
}