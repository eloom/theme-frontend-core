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

namespace Eloom\ThemeFrontendCore\Block\Brand;

use Eloom\ThemeFrontendCore\Helper\Brand as Helper;
use Eloom\ThemeFrontendCore\Model\BrandFactory;
use Magento\Backend\Model\UrlInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\View\Element\Template\Context;

class View extends Brand implements IdentityInterface {

	const DEFAULT_CACHE_TAG = 'ELOOM_BRAND_VIEW';

	protected $filterProvider;

	protected $brand;

	public function __construct(Context        $context,
	                            AdapterFactory $imageFactory,
	                            UrlInterface   $backendUrl,
	                            ProductFactory $product,
	                            Visibility     $catalogProductVisibility,
	                            FilterProvider $filterProvider,
	                            BrandFactory   $brandFactory,
	                            Helper         $helper,
	                            array          $data = []) {
		$this->filterProvider = $filterProvider;

		parent::__construct($context, $imageFactory, $backendUrl, $brandFactory, $helper, $data);
	}

	protected function _construct() {
		parent::_construct();
	}

	protected function getCacheLifetime() {
		return parent::getCacheLifetime() ?: 86400;
	}

	public function getCacheKeyInfo() {
		$keyInfo = parent::getCacheKeyInfo();
		$id = $this->getRequest()->getParam('id');
		$key = $this->_storeManager->getStore()->getStoreId();
		if ($id) {
			$key = $key . '-' . $id;
		}
		$keyInfo[] = $key;

		return $keyInfo;
	}

	/**
	 * @return array
	 */
	public function getIdentities() {
		$id = $this->getRequest()->getParam('id');
		$key = $this->_storeManager->getStore()->getStoreId();
		if ($id) $key = $key . '-' . $id;

		return [self::DEFAULT_CACHE_TAG, self::DEFAULT_CACHE_TAG . '_' . $key];
	}

	protected function _prepareLayout() {
		if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
			$breadcrumbs->addCrumb('home', [
				'label' => __('Home'),
				'title' => __('Go to Home Page'),
				'link' => $this->_storeManager->getStore()->getBaseUrl()
			])->addCrumb('brand', $this->getBreadcrumbsData());
		}

		if ($brandId = $this->getRequest()->getParam('id')) {
			$brand = $this->brandFactory->create()->load($brandId);
			$title = $brand->getData('title');
			$breadcrumbs->addCrumb($title, [
				'label' => $title,
				'title' => $title
			]);
			$this->pageConfig->getTitle()->set(__($title));
		}

		return parent::_prepareLayout();
	}

	/**
	 * @return array
	 */
	protected function getBreadcrumbsData() {
		$data = [
			'label' => __('Brand'),
			'title' => __('Brand')
		];
		$data['link'] = $this->helper->getBrandUrl();

		return $data;
	}

	public function getBrand() {
		if ($this->brand) return $this->brand;
		$brandId = $this->getRequest()->getParam('id');
		if (!$brandId) {
			return;
		}
		$this->brand = $this->brandFactory->create()->load($brandId);

		return $this->brand;
	}

	public function getDescription() {
		$brand = $this->getBrand();
		$description = $brand->getDescription();
		if ($description) {
			$storeId = $this->_storeManager->getStore()->getStoreId();

			return $this->filterProvider->getBlockFilter()->setStoreId($storeId)->filter($description);
		}
	}

	/**
	 * @return number
	 */
	public function getProductCount(\Eloom\ThemeFrontendCore\Model\Brand $brand) {
		$collection = $brand->getProductCollection();

		return $collection->count();
	}
}
