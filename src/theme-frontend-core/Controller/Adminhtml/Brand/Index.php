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

class Index extends \Eloom\ThemeFrontendCore\Controller\Adminhtml\Brand {

	public function execute() {
		if ($this->getRequest()->getQuery('ajax')) {
			$resultForward = $this->resultForwardFactory->create();
			$resultForward->forward('grid');

			return $resultForward;
		}

		return $this->resultPageFactory->create();
	}
}
