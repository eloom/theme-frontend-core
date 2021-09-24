<?php
/**
* 
* Temas para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontend\Plugin\Catalog\Product;

use Eloom\ThemeFrontend\Block\Catalog\Product\Badges;
use Magento\Catalog\Block\Product\Image;
use Magento\Framework\View\LayoutInterface;

class ImagePlugin {
	
	/**
	 * @var LayoutInterface
	 */
	private $layout;
	
	public function __construct(LayoutInterface $layout) {
		$this->layout = $layout;
	}
	
	public function afterToHtml(Image $image, $result) {
		if ($image->getData('product') && $result) {
			$block = $this->layout->createBlock(Badges::class)->setProduct($image->getData('product'))->setTemplate('Eloom_ThemeFrontend::catalog/badges.phtml');
			
			return $result . $block->toHtml();
		}
		
		return $result;
	}
}