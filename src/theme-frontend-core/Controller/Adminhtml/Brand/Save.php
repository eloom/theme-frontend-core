<?php
/**
* 
* Temas para Magento 2
* 
* @category     elOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2025 elOOm (https://eloom.com.br)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontendCore\Controller\Adminhtml\Brand;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Image\Adapter\AdapterInterface;
use Magento\Framework\Filesystem\Directory\Read;

class Save extends \Eloom\ThemeFrontendCore\Controller\Adminhtml\Brand {

	/**
	 * @var PageFactory
	 */
	public function execute() {
		$resultRedirect = $this->resultRedirectFactory->create();

		if ($data = $this->getRequest()->getPostValue()) {
			$model = $this->brandFactory->create();
			$storeViewId = $this->getRequest()->getParam('store');

			if ($id = $this->getRequest()->getParam('entity_id')) {
				$model->load($id);
			}

			if (isset($_FILES['image']) && isset($_FILES['image']['name']) && strlen($_FILES['image']['name'])) {
				/*
				 * Save image upload
				 */
				try {
					$uploader = $this->objectManager->create('Magento\MediaStorage\Model\File\Uploader', ['fileId' => 'image']);
					$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

					/** @var AdapterInterface $imageAdapter */
					$imageAdapter = $this->objectManager->get('Magento\Framework\Image\AdapterFactory')->create();

					$uploader->addValidateCallback('brand_image', $imageAdapter, 'validateUploadFile');
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);

					/** @var Read $mediaDirectory */
					$mediaDirectory = $this->objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA);
					$result = $uploader->save($mediaDirectory->getAbsolutePath('eloom/brand/brand/'));
					$data['image'] = 'eloom/brand/brand' . $result['file'];
				} catch (\Exception $e) {
					if ($e->getCode() == 0) {
						$this->messageManager->addError($e->getMessage());
					}
				}
			} else {
				if (isset($data['image']) && isset($data['image']['value'])) {
					if (isset($data['image']['delete'])) {
						$data['image'] = null;
						$data['delete_image'] = true;
					} elseif (isset($data['image']['value'])) {
						$data['image'] = $data['image']['value'];
					} else {
						$data['image'] = null;
					}
				}
			}
			if (isset($data['stores'])) $data['stores'] = implode(',', $data['stores']);
			$model->setData($data)
				->setStoreViewId($storeViewId);

			try {
				$model->save();

				$this->messageManager->addSuccess(__('The Brand menu has been saved.'));
				$this->_getSession()->setFormData(false);

				if ($this->getRequest()->getParam('back') === 'edit') {
					return $resultRedirect->setPath(
						'*/*/edit',
						[
							'entity_id' => $model->getId(),
							'_current' => true,
							'store' => $storeViewId,
							'current_brand_id' => $this->getRequest()->getParam('current_brand_id'),
							'saveandclose' => $this->getRequest()->getParam('saveandclose'),
						]
					);
				} elseif ($this->getRequest()->getParam('back') === 'new') {
					return $resultRedirect->setPath(
						'*/*/new',
						['_current' => TRUE]
					);
				}

				return $resultRedirect->setPath('*/*/');
			} catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
				$this->messageManager->addException($e, __('Something went wrong while saving the brand.'));
			}

			$this->_getSession()->setFormData($data);

			return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
		}

		return $resultRedirect->setPath('*/*/');
	}
}
