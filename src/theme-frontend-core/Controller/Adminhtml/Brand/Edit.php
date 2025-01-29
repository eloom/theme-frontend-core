<?php
/**
* 
* Temas para Magento 2
* 
* @category     elOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2025 Ã©lOOm (https://eloom.com.br)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontendCore\Controller\Adminhtml\Brand;

class Edit extends \Eloom\ThemeFrontendCore\Controller\Adminhtml\Brand {

	public function execute() {
		$id = $this->getRequest()->getParam('entity_id');
		$storeViewId = $this->getRequest()->getParam('store');
		$model = $this->brandFactory->create();

		if ($id) {
			$model->setStoreViewId($storeViewId)->load($id);
			if (!$model->getId()) {
				$this->messageManager->addError(__('This Brand no longer exists.'));
				$resultRedirect = $this->resultRedirectFactory->create();

				return $resultRedirect->setPath('*/*/');
			}
		}

		$data = $this->_getSession()->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		$this->coreRegistry->register('brand', $model);

		return $this->resultPageFactory->create();
	}
}
