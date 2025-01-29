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

namespace Eloom\ThemeFrontendCore\Model\System\Config;

use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\ScopeInterface;

class Brand implements ArrayInterface {

	protected $scopeConfig;

	protected $options = [];

	/**
	 * @var Repository $productAttributeRepository
	 */
	protected $productAttributeRepository;

	public function __construct(ScopeConfigInterface $scopeConfig, Repository $productAttributeRepository) {
		$this->productAttributeRepository = $productAttributeRepository;
		$this->scopeConfig = (object)$scopeConfig->getValue('eloom_themefrontend', ScopeInterface::SCOPE_STORE);
	}

	public function toOptionArray() {
		if (!$this->options) {
			$options = [];
			$cfg = $this->scopeConfig->brand;
			if (isset($cfg['attribute'])) {
				$brands = $this->productAttributeRepository->get($cfg['attribute'])->getOptions();
				foreach ($brands as $brand) {
					$options[$brand->getValue()] = $brand->getLabel();
				}
			}

			$this->options = $options;
		}

		return $this->options;
	}

}
