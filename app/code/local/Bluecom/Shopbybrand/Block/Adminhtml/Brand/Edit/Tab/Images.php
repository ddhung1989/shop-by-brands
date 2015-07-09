<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand_Edit_Tab_Images extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare tab form's information
     *
     * @return Bluecom_Shopbybrand_Block_Adminhtml_Shopbybrand_Edit_Tab_Images
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $dataObj = new Varien_Object(array(
            'store_id' => '',            
            'icon_in_store' =>  '',
            'image_in_store' =>  '',
        ));
        
        if (Mage::getSingleton('adminhtml/session')->getBrandImagesData()) {
            $data = Mage::getSingleton('adminhtml/session')->getBrandImagesData();
            Mage::getSingleton('adminhtml/session')->setBrandImagesData(null); 
        }
        
        if (isset($data)) {
			$dataObj->addData($data);
		}
        $data = $dataObj->getData();        
        
		$fieldset = $form->addFieldset('shopbybrand_images', array(
            'legend'=>Mage::helper('bluecom_shopbybrand')->__('Images')
        ));
        
        if(isset($data['icon']) && $data['icon'])
        {
            $fieldset->addField('old_icon', 'hidden', array(
                'label'     => Mage::helper('bluecom_shopbybrand')->__('Current Icon'),
                'required'  => false,
                'name'      => 'old_icon',
                'value'     =>$data['icon'],
            ));
         }	
        $fieldset->addField('icon', 'image', array(
            'label'     =>  Mage::helper('bluecom_shopbybrand')->__('Upload Icon'),
			'required'  =>  false,
            'name'      =>  'icon',
        ));
		
        if(isset($data['image']) && $data['image'])
        {
            $fieldset->addField('old_image', 'hidden', array(
                'label'     => Mage::helper('bluecom_shopbybrand')->__('Current image'),
                'required'  => false,
                'name'      => 'old_image',
                'value'     => $data['image'],
            ));
        }	
        $fieldset->addField('image', 'image', array(
            'label'     =>  Mage::helper('bluecom_shopbybrand')->__('Upload image'),
			'required'  =>  false,
            'name'      =>  'image',            
        ));
        
        if(isset($data['icon']) && $data['icon'])
        {
            $data['old_icon'] =  $data['icon'];
            $data['icon'] =  Mage::helper('bluecom_shopbybrand')->getUrlIconPath($data['brand_id']) . '/' . $data['icon'];
        }
		
		if(isset($data['image']) && $data['image'])
        {
            $data['old_image'] =  $data['image'];
            $data['image'] =  Mage::helper('bluecom_shopbybrand')->getUrlImagePath($data['brand_id']) . '/' . $data['image'];
        }

        $form->setValues($data);
        return parent::_prepareForm();
    }
}