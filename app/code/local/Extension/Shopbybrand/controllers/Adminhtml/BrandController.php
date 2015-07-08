<?php
class Extension_Shopbybrand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action {
	/**
	 * Initialize action
	 *
	 * Here, we set the breadcrumbs and the active menu
	 *
	 * @return Mage_Adminhtml_Controller_Action
	 */
	protected function _initAction() {
		$this->loadLayout()
			// Make the active menu match the menu config nodes (without 'children' in-between)
			->_setActiveMenu('catalog/extension_shopbybrand_brand')
			->_title($this->__('Catalog'))->_title($this->__('Brand'))
			->_addBreadcrumb($this->__('Catalog'), $this->__('Catalog'))
			->_addBreadcrumb($this->__('Brand'), $this->__('Brand'));
			
		return $this;
	}
	
	public function indexAction() {
		// Let's call our initAction method which will set some basic params for each action
		$this->_initAction()
			->renderLayout();
	}
	
	public function newAction() {
		// We just forward the new action to a blank edit form
		$this->_forward('edit');
	}
	
	public function editAction() {
		$this->_initAction();
		
		// Get id if available
		$id = $this->getRequest()->getParam('id');
		$store = $this->getRequest()->getParam('store');
		$model = Mage::getModel('extension_shopbybrand/brand')->setStoreId($store);
		
		if ($id) {
			// Load record
			$model->load($id);
			
			// Check if record is loaded
			if (!$model->getId()) {
				Mage::getSingleton('adminhtml/session')->addError($this->__('This brand no longer exists.'));
				$this->_redirect('*/*/');
				
				return;
			}
		}
		
		$this->_title($model->getId() ? $model->getName() : $this->__('New Brand'));
		
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}
		
		Mage::register('brand_data', $model);
		
		$this->_initAction();
		$this->_addBreadcrumb($id ? $this->__('Edit Brand') : $this->__('New Brand'), $id ? $this->__('Edit Brand') : $this->__('New Brand'));
		$this->_addContent($this->getLayout()->createBlock('extension_shopbybrand/adminhtml_brand_edit'));
		$this->_addLeft($this->getLayout()->createBlock('extension_shopbybrand/adminhtml_brand_edit_tabs'));
		$this->renderLayout();
	}
	
	public function saveAction() {
		if ($postData = $this->getRequest()->getPost()) {
			$store = $this->getRequest()->getParam('store', 0);
			
			// Process post data before doing anything else
			// Icon
			if (isset($postData['icon']['delete'])) {
                Mage::helper('extension_shopbybrand')->deleteIconFile($postData['name'], $postData['old_icon']);
                unset($postData['icon']);
            }
            $postData['icon'] = "";

            if (isset($_FILES['icon'])) {
				$postData['icon'] = Mage::helper('extension_shopbybrand')->refineImageName($_FILES['icon']['name']);
			}

            if (!$postData['icon'] && isset($postData['old_icon'])) {
                $postData['icon'] = $postData['old_icon'];
            }
			
			// Image
			if (isset($postData['image']['delete'])) {
                Mage::helper('extension_shopbybrand')->deleteImageFile($postData['name'], $postData['old_image']);
                unset($postData['old_image']);
            }
            $postData['image'] = "";
            
			if (isset($_FILES['image'])) {
				$postData['image'] = Mage::helper('extension_shopbybrand')->refineImageName($_FILES['image']['name']);
			}

            if (!$postData['image'] && isset($postData['old_image'])) {
                $postData['image'] = $postData['old_image'];
            }
			
			// Product ids
			$productIds = array();
            if (isset($postData['sproducts']) && $postData['sproducts']) {
                if (is_string($postData['sproducts'])) {
                    parse_str($postData['sproducts'], $productIds);
                    $productIds = array_unique(array_keys($productIds));
                }
            }
			
			// Start saving model
			$model = Mage::getModel('extension_shopbybrand/brand');
			$model->load($this->getRequest()->getParam('id'))
				  ->addData($postData);
			
			try {
				if (count($productIds)) {
					$model->setData('product_ids', implode(',', $productIds));
				}
			
				$model->setStoreId($store);
				
				if ($model->getCreatedTime() == null) {
					$model->setCreatedTime(now());
				}
				$model->setUpdatedTime(now());
				
				$model->save();
				
				// Upload image
				$icon = $model->getIcon();
                if (isset($_FILES['icon'])) {
                    if (isset($_FILES['icon']['name']) && $_FILES['icon']['name']) {
						$icon = Mage::helper('extension_shopbybrand')->uploadIcon($model->getId(), $_FILES['icon']);
					}
                }
				
				$image = $model->getImage();
                if (isset($_FILES['image'])) {
                    if (isset($_FILES['image']['name']) && $_FILES['image']['name']){
						$image = Mage::helper('extension_shopbybrand')->uploadImage($model->getId(), $_FILES['image']);
					}
                }
				
                if ($icon != $model->getIcon() || $image != $model->getImage()) {
                    $model->setIcon($icon);
					$model->setImage($image);
                    $model->save();
                }
				
				// Need to update product's attribute manufacturer here
				
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Brand has been saved.'));
				$this->_redirect('*/*/');
				
				return;
			} catch (Mage_Core_Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this brand.'));
			}
			
			Mage::getSingleton('adminhtml/session')->setBrandData($postData);
			$this->_redirectReferer();
		}
	}
	
	/**
	 * Check currently called action by permissions for current user
	 * 
	 * @return bool
	 */
	protected function _isAllowed() {
		return Mage::getSingleton('admin/session')->isAllowed('catalog/extension_shopbybrand_brand');
	}
	
	/**
	 * Actions for tabs
	 */
	public function imageAction() {
		$this->loadLayout();
		$this->getLayout()->getBlock('shopbybrand.block.adminhtml.brand.edit.tab.images');
        $this->renderLayout();
	}
	
	public function productAction() {
		$this->loadLayout();
		$this->getLayout()->getBlock('shopbybrand.block.adminhtml.brand.edit.tab.products')
                ->setBrandProducts($this->getRequest()->getPost('brand_products', null));
        $this->renderLayout();
	}
	
	/*
	 *
	 */
	public function productGridAction() {
		$this->loadLayout();
		$this->getLayout()->getBlock('shopbybrand.block.adminhtml.brand.edit.tab.products')
                ->setBrandProducts($this->getRequest()->getPost('brand_products', null));
        $this->renderLayout();
	}
}