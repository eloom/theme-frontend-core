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

namespace Eloom\ThemeFrontend\Helper;

use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Brand extends \Magento\Framework\App\Helper\AbstractHelper {

	const XML_PATH_BRAND_ACTIVE = 'eloom_themefrontend/brand/active';
	const XML_PATH_BRAND_TITLE = 'eloom_themefrontend/brand/title';
	const XML_PATH_BRAND_TOP_MENU_ACTIVE = 'eloom_themefrontend/brand/top_menu_active';
	const XML_PATH_BRAND_ROUTER = 'eloom_themefrontend/brand/router';
	const XML_PATH_BRAND_ATTRIBUTE = 'eloom_themefrontend/brand/attribute';
	const XML_PATH_BRAND_LINK = 'eloom_themefrontend/brand/link';
	const XML_PATH_BRAND_URL_SUFFIX = 'eloom_themefrontend/brand/url_suffix';

	private $storeManager;

	/**
	 * @var string
	 */
	protected $urlMedia;

	/**
	 * @var
	 */
	protected $attribute;

	/**
	 * @var Repository
	 */
	protected $productAttributeRepository;

	public function __construct(Context               $context,
	                            ScopeConfigInterface  $scopeConfig,
	                            StoreManagerInterface $storeManager,
	                            Repository $productAttributeRepository) {
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;
		$this->productAttributeRepository = $productAttributeRepository;

		parent::__construct($context);
	}

	public function isActive($storeId = null): bool {
		return (boolean)$this->scopeConfig->getValue(self::XML_PATH_BRAND_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function isTopMenuActive($storeId = null): bool {
		return (boolean)$this->scopeConfig->getValue(self::XML_PATH_BRAND_TOP_MENU_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getTitle($storeId = null) {
		return $this->scopeConfig->getValue(self::XML_PATH_BRAND_TITLE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getRouter($storeId = null) {
		$router = $this->scopeConfig->getValue(self::XML_PATH_BRAND_ROUTER, ScopeInterface::SCOPE_STORE, $storeId);

		return $router ? $router : 'brand';
	}

	public function getUrlRouter($storeId = null) {
		return $this->storeManager->getStore()->getBaseUrl() . $this->getRouter($storeId);
	}

	public function getAttributeCode($storeId = null) {
		return $this->scopeConfig->getValue(self::XML_PATH_BRAND_ATTRIBUTE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getLinkType($storeId = null) {
		return $this->scopeConfig->getValue(self::XML_PATH_BRAND_LINK, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getUrlSuffix($storeId = null) {
		return $this->scopeConfig->getValue(self::XML_PATH_BRAND_URL_SUFFIX, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getLink($brand, $storeId = null) {
		$typeLink = $this->getLinkType($storeId);
		$baseUrl = $this->storeManager->getStore()->getBaseUrl();
		$attributeCode = $this->getAttributeCode($storeId);

		$link = '#';
		if (!$typeLink) {
			$key = $brand->getUrlkey();
			$link = $key ? $baseUrl . $this->getUrlKey($key) : '#';
		} elseif ($typeLink == '2' && $brand->getOptionId()) {
			$link = $baseUrl . 'catalogsearch/advanced/result/?' . $attributeCode . urlencode('[]') . '=' . $brand->getOptionId();
		} elseif ($typeLink == '1') {
			$attr = $this->getAttributeCode();
			if ($attr->usesSource()) {
				$option = $attr->getSource()->getOptionText($brand->getOptionId());
				$link = $baseUrl . 'catalogsearch/result/?q=' . $option;
			}
		} else {
			$link = $brand->getUrlkey();
		}

		return $link;
	}

	public function getBrandUrl($key = '', $suffix = true) {
		return $this->storeManager->getStore()->getBaseUrl() . $this->getUrlKey($key, $suffix);
	}

	public function getUrlKey($key = '', $suffix = true) {
		$key = trim($key, '/');
		if ($key) $key = '/' . $key;
		if ($suffix) $key = $key . $this->getUrlSuffix();

		return $this->getRouter() . $key;
	}

	public function getMediaUrl($image = "") {
		if (!$this->urlMedia) {
			$this->urlMedia = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
		}

		return $this->urlMedia . $image;
	}

	public function getAttribute() {
		if (!$this->attribute) {
			$attributeCode = $this->getAttributeCode();
			$this->attribute = $this->productAttributeRepository->get($attributeCode);
		}

		return $this->attribute;
	}
}