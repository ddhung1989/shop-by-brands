<?php
class Bluecom_Shopbybrand_Helper_Data extends Mage_Core_Helper_Abstract {
	public function getUrlImagePath($brandId) {
        $brandImagePathUrl = Mage::getBaseUrl('media') . 'brands/cache/' . $brandId;
        return $brandImagePathUrl;
    }

    public function getUrlIconPath($brandId) {
        $brandIconPathUrl = Mage::getBaseUrl('media') . 'brands/icon/' . $brandId;
        return $brandIconPathUrl;
    }
	
	public function getIconPath($brandId) {
        $brandIconPath = Mage::getBaseDir('media') . DS . 'brands' . DS . 'icon' . DS . $brandId;
        return $brandIconPath;
    }
	
	public function getImagePath($brandId) {
        $brandImagePath = Mage::getBaseDir('media') . DS . 'brands' . DS . 'image' . DS . $brandId;
        return $brandImagePath;
    }
	
	public function createIconFolder($brandId) {
        $brandPath = Mage::getBaseDir('media') . DS . 'brands';
        $brandIconPath = Mage::getBaseDir('media') . DS . 'brands' . DS . 'icon';
		
        $brandIconImagePath = $this->getIconPath($brandId);

        if (!is_dir($brandPath)) {
            try {

                chmod(Mage::getBaseDir('media'), 0777);

                mkdir($brandPath);

                chmod($brandPath, 0777);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        if (!is_dir($brandIconPath)) {
            try {

                chmod($brandPath, 0777);

                mkdir($brandIconPath);

                chmod($brandIconPath, 0777);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
		
		if (!is_dir($brandIconImagePath)) {
            try {

                chmod($brandPath, 0777);

                mkdir($brandIconImagePath);

                chmod($brandIconImagePath, 0777);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    }

    public function createImageFolder($brandName) {
        $brandPath = Mage::getBaseDir('media') . DS . 'brands';
		$brandImagePath = Mage::getBaseDir('media') . DS . 'brands' . DS . 'image';

        $brandImageImagePath = $this->getImagePath($brandName);

        if (!is_dir($brandPath)) {
            try {

                chmod(Mage::getBaseDir('media'), 0777);

                mkdir($brandPath);

                chmod($brandPath, 0777);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        if (!is_dir($brandImagePath)) {
            try {
                chmod($brandPath, 0777);

                mkdir($brandImagePath);

                chmod($brandImagePath, 0777);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        if (!is_dir($brandImageImagePath)) {
            try {

                mkdir($brandImageImagePath);

                chmod($brandImageImagePath, 0777);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    }
	
	public function refineImageName($imageName) {
        while (strpos($imageName, "  ") !== false) {
            $imageName = str_replace("  ", " ", $imageName);
        }
        $imageName = str_replace(" ", "-", $imageName);
        $imageName = strtolower($imageName);

        return $imageName;
    }
	
	public function uploadIcon($brandId, $iconFile) {
        $this->createIconFolder($brandId);

        $iconPath = $this->getIconPath($brandId);

        $iconName = "";
        $newIconName = "";
        
		if (isset($iconFile['name']) && $iconFile['name'] != '') {
            try {
                /* Starting upload */
                $iconName = $iconFile['name'];
                $uploader = new Varien_File_Uploader('icon');
                $newIconName = $this->refineImageName($iconName);
				
                // Any extention would work
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(true);

                $uploader->setFilesDispersion(false);
                $uploader->save($iconPath, $newIconName);
                $newIconName = $uploader->getUploadedFileName();
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }

            $iconName = $newIconName;
        }
        return $iconName;
    }
	
	public function uploadImage($brandId, $imageFile) {
        $this->createImageFolder($brandId);

        $imagePath = $this->getImagePath($brandId);

        $imageName = "";
        $newImageName = "";
        
		if (isset($imageFile['name']) && $imageFile['name'] != '') {
            try {
                /* Starting upload */
                $imageName = $imageFile['name'];
                $uploader = new Varien_File_Uploader('image');
                $newImageName = $this->refineImageName($imageName);
				
                // Any extention would work
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(true);

                $uploader->setFilesDispersion(false);
                $uploader->save($imagePath, $newImageName);
                $newImageName = $uploader->getUploadedFileName();
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }

            $imageName = $newImageName;
        }
        return $imageName;
    }
}