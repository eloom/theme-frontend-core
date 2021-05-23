<?php
/**
* 
* Temas para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2021 Ã©lOOm (https://www.eloom.com.br)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontend\Block\Catalog\Product;

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
		$this->jsLayout['components']['shipping-estimate']['component'] = 'Eloom_ThemeFrontend/js/catalog/product/shipping-estimate';
		
		return parent::getJsLayout();
	}
}