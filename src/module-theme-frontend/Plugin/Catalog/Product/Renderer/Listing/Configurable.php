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

namespace Eloom\ThemeFrontend\Plugin\Catalog\Product\Renderer\Listing;

use Magento\Catalog\Helper\Image;
use Magento\Framework\Serialize\Serializer\Json;

class Configurable {

	protected $serializer;

	/**
	 * @var \Magento\Catalog\Helper\Image
	 */
	protected $imageHelper;

	public function __construct(Json $serializer, Image $imageHelper) {
		$this->serializer = $serializer;
		$this->imageHelper = $imageHelper;
	}

	public function afterGetJsonConfig(\Magento\Swatches\Block\Product\Renderer\Listing\Configurable $subject, $config) {
		$config = $this->serializer->unserialize($config);
		$baseHoverImage = $subject->getProduct()->getData('hover_image');

		if ($baseHoverImage) {
			$hoverImage = $this->imageHelper
				->init($subject->getProduct(), 'category_page_grid_hover')
				->setImageFile($baseHoverImage)
				->getUrl();

			$config['hover_image'] = $hoverImage;
		}

		return $this->serializer->serialize($config);
	}
}
