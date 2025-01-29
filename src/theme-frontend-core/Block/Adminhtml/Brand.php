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

namespace Eloom\ThemeFrontendCore\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Brand extends Container {

	protected function _construct() {
		$this->_controller = 'adminhtml_brand';
		$this->_blockGroup = 'Eloom_ThemeFrontendCore';
		$this->_headerText = __('Brand');
		$this->_addButtonLabel = __('Add New Brand');

		parent::_construct();
	}
}
