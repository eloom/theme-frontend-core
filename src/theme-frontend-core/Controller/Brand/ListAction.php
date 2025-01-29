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

namespace Eloom\ThemeFrontendCore\Controller\Brand;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class ListAction extends Action {

	protected $pageFactory;

	public function __construct(Context $context, PageFactory $pageFactory) {
		$this->pageFactory = $pageFactory;

		return parent::__construct($context);
	}

	public function execute() {
		return $this->pageFactory->create();
	}
}