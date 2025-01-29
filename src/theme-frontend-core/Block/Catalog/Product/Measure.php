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

namespace Eloom\ThemeFrontendCore\Block\Catalog\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Measure extends Template {
	
	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $coreRegistry = null;
	
	public function __construct(Context $context,
	                            Registry $registry,
	                            array $data = []) {
		$this->coreRegistry = $registry;
		parent::__construct($context, $data);
	}
	
	public function getMeasure() {
			$product = $this->coreRegistry->registry('product');
			if (!$product || !$product->getMeasures()) {
				return null;
			}
		
		return $product;
	}
}