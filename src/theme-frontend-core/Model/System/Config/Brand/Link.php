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

namespace Eloom\ThemeFrontendCore\Model\System\Config\Brand;

use Magento\Framework\Option\ArrayInterface;

class Link implements ArrayInterface {

	public function toOptionArray() {
		return array(
			['value' => 0, 'label' => __('Shop By Brand Url')],
			['value' => 1, 'label' => __('Quick Search Results')],
			['value' => 2, 'label' => __('Advanced Search Results')],
			['value' => 3, 'label' => __('Custom Extra Link')]
		);
	}
}

