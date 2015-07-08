<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare tab form's information
     *
     * @return Bluecom_Shopbybrand_Block_Adminhtml_Shopbybrand_Edit_Tab_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $dataObj = new Varien_Object(array(
            'store_id' => '',
            'name_in_store' => '',
            'description_in_store' =>  '',
            'status_in_store_in_store' => ''
        ));
        
        if (Mage::getSingleton('adminhtml/session')->getBrandData()) {
            $data = Mage::getSingleton('adminhtml/session')->getBrandData();
            Mage::getSingleton('adminhtml/session')->setBrandData(null);
        } elseif (Mage::registry('brand_data')) {
            $data = Mage::registry('brand_data')->getData();
        }
        
        if (isset($data)) $dataObj->addData($data);
            $data = $dataObj->getData();
        
        $storeId = $this->getRequest()->getParam('store');
        if($storeId)
            $store = Mage::getModel('core/store')->load($storeId);
        else
            $store = Mage::app()->getStore();
        $inStore = $this->getRequest()->getParam('store');
        $defaultLabel = Mage::helper('bluecom_shopbybrand')->__('Use Default');
        $defaultTitle = Mage::helper('bluecom_shopbybrand')->__('-- Please Select --');
        $scopeLabel = Mage::helper('bluecom_shopbybrand')->__('STORE VIEW');
        
        $fieldset = $form->addFieldset('shopbybrand_form', array(
            'legend'=>Mage::helper('bluecom_shopbybrand')->__('Brand information')
        ));

        $fieldset->addField('name', 'text', array(
            'label'        => Mage::helper('bluecom_shopbybrand')->__('Name'),
            'class'        => 'required-entry',
            'required'    => true,
            'name'        => 'name',
            'disabled'  => ($inStore && !$data['name_in_store']),
            'after_element_html' => $inStore ? '</td><td class="use-default">
			<input id="name_default" name="name_default" type="checkbox" value="1" class="checkbox config-inherit" '.($data['name_in_store'] ? '' : 'checked="checked"').' onclick="toggleValueElements(this, Element.previous(this.parentNode))" />
			<label for="name_default" class="inherit" title="'.$defaultTitle.'">'.$defaultLabel.'</label>
          </td><td class="scope-label">
			['.$scopeLabel.']
          ' : '</td><td class="scope-label">
			['.$scopeLabel.']',
        ));
        
        $fieldset->addField('description', 'editor', array(
            'name'      => 'description',
            'label'     => Mage::helper('bluecom_shopbybrand')->__('Description'),
            'title'     => Mage::helper('bluecom_shopbybrand')->__('Description'),
            'style'     => 'width:600px; height:100px;',
            'wysiwyg'   => false,
            'required'  => false,
            'disabled'  => ($inStore && !$data['description_in_store']),
            'after_element_html' => $inStore ? '</td><td class="use-default">
			<input id="description_default" name="description_default" type="checkbox" value="1" class="checkbox config-inherit" '.($data['description_in_store'] ? '' : 'checked="checked"').' onclick="toggleValueElements(this, Element.previous(this.parentNode))" />
			<label for="description_default" class="inherit" title="'.$defaultTitle.'">'.$defaultLabel.'</label>
          </td><td class="scope-label">
			['.$scopeLabel.']
          ' : '</td><td class="scope-label">
			['.$scopeLabel.']',
        ));
        
		$fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('bluecom_shopbybrand')->__('Status'),
            'name'      => 'status',
            'values'    => Mage::getSingleton('bluecom_shopbybrand/status')->getOptionHash(),
            'disabled'  => ($inStore && !$data['status_in_store']),
            'after_element_html' => $inStore ? '</td><td class="use-default">
			<input id="status_default" name="status_default" type="checkbox" value="1" class="checkbox config-inherit" '.($data['status_in_store'] ? '' : 'checked="checked"').' onclick="toggleValueElements(this, Element.previous(this.parentNode))" />
			<label for="status_default" class="inherit" title="'.$defaultTitle.'">'.$defaultLabel.'</label>
          </td><td class="scope-label">
			['.$scopeLabel.']
          ' : '</td><td class="scope-label">
			['.$scopeLabel.']',
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }
}