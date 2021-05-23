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

namespace Eloom\ThemeFrontend\Block\Catalog;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class InfinateScroll extends Template {

	protected $serializer;

	public function __construct(Context $context,
	                            Json $serializer,
	                            array $data = []) {

		$this->serializer = $serializer;
		parent::__construct($context, $data);
	}

	public function getContainer() {
		return '.products.list.items.product-items';
	}

	public function getSerializedConfig(): ?string {
		$config = [];
		$config['hideNav'] = '.products.wrapper ~ .toolbar-products .pages';

		$settings = [];
		$settings['text'] = __('No more products');

		return $this->serializer->serialize(['config' => $config, 'settings' => $settings]);
	}
}