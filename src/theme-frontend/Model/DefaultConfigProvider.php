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

namespace Eloom\ThemeFrontend\Model;

use Eloom\ThemeFrontend\Helper\Data;
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
		$storeId = $this->storeManager->getStore()->getId();
		
		return [];
	}
}