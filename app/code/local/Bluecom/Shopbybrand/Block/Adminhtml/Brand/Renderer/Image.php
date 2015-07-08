<?php
class Bluecom_Shopbybrand_Block_Adminhtml_Brand_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $brandImage = $row->getImage();
        if($brandImage){
            $path = 'brands' . DS . 'image' . DS . $row->getId();
            $img = Mage::helper('bluecom_shopbybrand/image')->init($row, $path)->resizeImage(100, 75);
            return '<img src='.$img.' />';
        }
        return '';
    }
}