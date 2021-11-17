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

namespace Eloom\ThemeFrontend\Block\Brand;

use Magento\Framework\App\Filesystem\DirectoryList;

class ListBrand extends Brand implements \Magento\Framework\DataObject\IdentityInterface {

	const DEFAULT_CACHE_TAG = 'ELOOM_BRAND_LIST';

	protected function _construct() {
		parent::_construct();
	}

	protected function getCacheLifetime() {
		return parent::getCacheLifetime() ?: 86400;
	}

	public function getCacheKeyInfo() {
		$keyInfo = parent::getCacheKeyInfo();
		$id = $this->getRequest()->getParam('keyword');
		$key = $this->_storeManager->getStore()->getStoreId();
		if ($id) $key = $key . '-' . $id;
		$keyInfo[] = $key;
		return $keyInfo;
	}

	/**
	 * @return array
	 */
	public function getIdentities() {
		$keyword = $this->getRequest()->getParam('keyword');
		$key = $this->_storeManager->getStore()->getStoreId();
		if ($keyword) $key = $key . '-' . $keyword;
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

		$title = $this->helper->getTitle();
		if ($brandId = $this->getRequest()->getParam('id')) {
			$brand = $this->brandFactory->create()->load($brandId);
			$title = $brand->getData('title');
			$breadcrumbs->addCrumb($title, [
				'label' => $title,
				'title' => $title
			]);
		}
		if (!$title) {
			$title = __('Brand');
		}
		$this->pageConfig->getTitle()->set(__($title));

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

	public function getBrands() {
		$keyword = $this->getRequest()->getParam('keyword');
		$collection = $this->getBrandCollection();
		if ($keyword) {
			$collection->addFieldToFilter('title', ['like' => $keyword . '%']);
			$collection->setOrder('title', 'ASC');
		}
		return $collection;
	}

	public function getBrand() {
		$brandId = $this->getRequest()->getParam('id');
		if (!$brandId) {
			return;
		}

		return $this->brandFactory->create()->load($brandId);
	}

	/**
	 * @return number
	 */
	public function getProductCount(\Eloom\ThemeFrontend\Model\Brand $brand) {
		$collection = $brand->getProductCollection();

		return $collection->count();
	}
}
