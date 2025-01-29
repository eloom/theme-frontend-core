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

namespace Eloom\ThemeFrontendCore\Plugin\Catalog;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Image;
use Magento\Catalog\Model\Product;

class ProductPlugin {
	
	public function afterGetImage(AbstractProduct $subject, $result, $product, $imageId, $attribute = []) {
		if ($result instanceof Image) {
			$result->setData('product', $product);
		}
		
		return $result;
	}
}