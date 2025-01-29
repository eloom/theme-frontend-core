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

namespace Eloom\ThemeFrontendCore\Block\Brand;

use Eloom\ThemeFrontendCore\Helper\Brand as Helper;
use Eloom\ThemeFrontendCore\Model\BrandFactory;
use Eloom\ThemeFrontendCore\Model\ResourceModel\Brand\Collection;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\View\Element\Template\Context;

class Brand extends \Magento\Framework\View\Element\Template {

	/**
	 * @var Helper
	 */
	public $helper;

	protected $imageFactory;

	protected $brands = [];

	/**
	 * @var BrandFactory
	 */
	protected $brandFactory;

	protected $attribute = [];

	/**
	 * @var UrlInterface
	 */
	protected $backendUrl;

	/**
	 * @var Collection
	 */
	protected $brandCollection;

	public function __construct(Context        $context,
	                            AdapterFactory $imageFactory,
	                            UrlInterface   $backendUrl,
	                            BrandFactory   $brandFactory,
	                            Helper           $helper,
	                            array          $data = []) {
		$this->imageFactory = $imageFactory;
		$this->backendUrl = $backendUrl;
		$this->brandFactory = $brandFactory;
		$this->helper = $helper;

		parent::__construct($context, $data);
	}

	public function getAdminUrl($adminPath, $routeParams = [], $storeCode = 'default') {
		$routeParams[] = ['_nosid' => true, '_query' => ['___store' => $storeCode]];
		return $this->backendUrl->getUrl($adminPath, $routeParams);
	}

	public function getBrandCollection() {
		if (!$this->brandCollection) {
			$store = $this->_storeManager->getStore()->getStoreId();
			$collection = $this->brandFactory->create()->getCollection()
				->addFieldToFilter('stores', array(array('finset' => 0), array('finset' => $store)))
				->addFieldToFilter('status', 1);
			$this->brandCollection = $collection;
		}
		return $this->brandCollection;
	}

	public function getImage($brand) {
		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $brand->getImage();
	}
}
