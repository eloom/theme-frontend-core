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

class ExportCsv extends \Eloom\ThemeFrontendCore\Controller\Adminhtml\Brand {

	public function execute() {
		$fileName = 'brands.csv';

		/** @var \\Magento\Framework\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$content = $resultPage->getLayout()->createBlock('Eloom\ThemeFrontendCore\Block\Adminhtml\Brand\Grid')->getCsv();

		return $this->fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
	}
}
