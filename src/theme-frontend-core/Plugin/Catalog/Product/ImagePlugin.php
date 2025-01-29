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

namespace Eloom\ThemeFrontendCore\Plugin\Catalog\Product;

use Eloom\ThemeFrontendCore\Block\Catalog\Product\Badges;
use Eloom\ThemeFrontendCore\Block\Catalog\ImageHover;
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
		$product = $image->getData('product');
		if ($product && $result) {
			$block = $this->layout
				->createBlock(Badges::class)
				->setProduct($product)
				->setTemplate('Eloom_ThemeFrontendCore::catalog/badges.phtml');
			
			$result .= $block->toHtml();
			
			$block = $this->layout
				->createBlock(ImageHover::class)
				->setProduct($product)
				->setTemplate('Eloom_ThemeFrontendCore::catalog/image-hover.phtml');
			
			$result .= $block->toHtml();
		}
		
		return $result;
	}
}