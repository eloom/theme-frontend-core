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

namespace Eloom\ThemeFrontend\Block\Catalog;

use Eloom\ThemeFrontend\Helper\Data;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Helper\Image;

class ImageHover extends Template {
	
	private $helper;
	
	private $jsonEncoder;
	
	private $storeManager;
	
	/**
	 * @var ProductInterface
	 */
	private $product;
	
	/**
	 * @var Image
	 */
	private $imageHelper;
	
	public function __construct(Context $context,
	                            EncoderInterface $jsonEncoder,
	                            StoreManagerInterface $storeManager,
	                            Data $helper,
	                            Image $imageHelper,
	                            array $data = []) {
		$this->jsonEncoder = $jsonEncoder;
		$this->helper = $helper;
		$this->storeManager = $storeManager;
		$this->imageHelper = $imageHelper;
		
		parent::__construct($context, $data);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setProduct(ProductInterface $product) {
		$this->product = $product;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getProduct() {
		return $this->product;
	}
	
	/**
	 * Composes configuration for js
	 *
	 * @return string
	 */
	public function getSerializedConfig() {
		$baseHoverImage = $this->product->getData('hover_image');
		$url = '';
		if ($baseHoverImage) {
			$url = $this->imageHelper
				->init($this->product, 'category_page_grid_hover')
				->setImageFile($baseHoverImage)
				->getUrl();
		}
		
		return $this->jsonEncoder->encode([
			'image' => $url
		]);
	}
}