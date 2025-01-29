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

class Delete extends \Eloom\ThemeFrontendCore\Controller\Adminhtml\Brand {

	public function execute() {
		$id = $this->getRequest()->getParam('entity_id');
		try {
			$item = $this->brandFactory->create()->setId($id);
			$item->delete();
			$this->messageManager->addSuccess(__('Delete successfully !'));
		} catch (\Exception $e) {
			$this->messageManager->addError($e->getMessage());
		}

		$resultRedirect = $this->resultRedirectFactory->create();

		return $resultRedirect->setPath('*/*/');
	}
}
