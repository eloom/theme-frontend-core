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

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportXml extends \Eloom\ThemeFrontend\Controller\Adminhtml\Brand {

	public function execute() {
		$fileName = 'brands.xml';
		$resultPage = $this->resultPageFactory->create();
		$content = $resultPage->getLayout()->createBlock('Eloom\ThemeFrontend\Block\Adminhtml\Brand\Grid')->getXml();

		return $this->fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
	}
}
