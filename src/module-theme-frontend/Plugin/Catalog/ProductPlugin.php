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

namespace Eloom\ThemeFrontend\Plugin\Catalog;

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