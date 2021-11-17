<?php
/**
* 
* Temas para Magento 2
* 
* @category     elOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontend\Controller\Adminhtml\Brand;

class MassStatus extends \Eloom\ThemeFrontend\Controller\Adminhtml\Brand {

	public function execute() {
		$brandIds = $this->getRequest()->getParam('brand');
		$status = $this->getRequest()->getParam('status');
		$storeViewId = $this->getRequest()->getParam('store');
		if (!is_array($brandIds) || empty($brandIds)) {
			$this->messageManager->addError(__('Please select Brand(s).'));
		} else {
			$collection = $this->brandCollectionFactory->create()->addFieldToFilter('entity_id', ['in' => $brandIds]);
			try {
				foreach ($collection as $item) {
					$item->setStoreViewId($storeViewId)
						->setStatus($status)
						->setIsMassupdate(true)
						->save();
				}
				$this->messageManager->addSuccess(__('A total of %1 record(s) have been changed status.', count($brandIds)));
			} catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
			}
		}
		$resultRedirect = $this->resultRedirectFactory->create();

		return $resultRedirect->setPath('*/*/', ['store' => $this->getRequest()->getParam('store')]);
	}
}
