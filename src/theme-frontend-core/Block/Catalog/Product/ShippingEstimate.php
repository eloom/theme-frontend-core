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

namespace Eloom\ThemeFrontendCore\Block\Catalog\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class ShippingEstimate extends Template implements BlockInterface {
	
	public function __construct(Context $context,
	                            array $data = []) {
		
		parent::__construct($context, $data);
	}
	
	/**
	 * @inheritdoc
	 */
	public function getJsLayout() {
		$this->jsLayout['components']['shipping-estimate']['component'] = 'Eloom_ThemeFrontendCore/js/catalog/product/shipping-estimate';
		
		return parent::getJsLayout();
	}
}