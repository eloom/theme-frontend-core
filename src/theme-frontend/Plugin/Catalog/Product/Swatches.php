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

namespace Eloom\ThemeFrontend\Plugin\Catalog\Product;

use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product;
use Magento\Swatches\Helper\Data;

class Swatches {
	/**
	 * @var Image
	 */
	private $imageHelper;

	public function __construct(Image $imageHelper) {
		$this->imageHelper = $imageHelper;
	}

	public function aroundGetProductMediaGallery(Data $subject, \Closure $proceed, Product $product) {
		$result = $proceed($product);

		$baseHoverImage = $product->getData('hover_image');
		if ($baseHoverImage) {
			$hoverImage = $this->imageHelper
				->init($product, 'category_page_grid_hover')
				->setImageFile($baseHoverImage)
				->getUrl();
			$result['hover_image'] = $hoverImage;
		}

		return $result;
	}
}
