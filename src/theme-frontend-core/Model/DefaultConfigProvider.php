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

namespace Eloom\ThemeFrontendCore\Model;

use Eloom\ThemeFrontendCore\Helper\Data;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Store\Model\StoreManagerInterface;

class DefaultConfigProvider {
	
	private $storeManager;
	
	private $localeResolver;
	
	private $helper;
	
	public function __construct(StoreManagerInterface $storeManager,
	                            ResolverInterface $localeResolver,
	                            Data $helper) {
		$this->storeManager = $storeManager;
		$this->localeResolver = $localeResolver;
		$this->helper = $helper;
	}
	
	public function getConfig() {
		return [
			'theme' => [
				'storeId' => $this->storeManager->getStore()->getId()
			]
		];
	}
}