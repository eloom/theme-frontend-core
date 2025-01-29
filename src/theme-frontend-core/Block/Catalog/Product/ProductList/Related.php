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

namespace Eloom\ThemeFrontendCore\Block\Catalog\Product\ProductList;

use Magento\Framework\ObjectManagerInterface;
use Eloom\ThemeFrontendCore\Model\Product\ProductList\Related\Collection;
use Eloom\ThemeFrontendCore\Helper\Data as Helper;
use Magento\Catalog\Block\Product\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Registry;
use Magento\Checkout\Model\ResourceModel\Cart;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Checkout\Model\Session;
use Magento\Framework\Module\Manager;
use Magento\Store\Model\Store;

class Related extends \Magento\Catalog\Block\Product\ProductList\Related {

	/**
	 * @var Helper
	 */
	protected $helper;


	/**
	 * @var StoreManagerInterface
	 */
	protected $storeManager;


	/**
	 * @var Registry
	 */
	protected $registry;


	/**
	 * @var Collection
	 */
	protected $collection;


	public function __construct(Context    $context,
	                            Cart       $checkoutCart,
	                            Visibility $catalogProductVisibility,
	                            Session    $checkoutSession,
	                            Manager    $moduleManager,
	                            Helper     $helper,
	                            Collection $collection,
	                            array      $data = []) {
		$this->helper = $helper;
		$this->registry = $context->getRegistry();
		$this->storeManager = $context->getStoreManager();;
		$this->collection = $collection;

		parent::__construct(
			$context,
			$checkoutCart,
			$catalogProductVisibility,
			$checkoutSession,
			$moduleManager,
			$data
		);

		$lifeTime = $this->helper->getRelatedProductsCacheLifetime();
		if ($lifeTime > 0 && $cacheKey = $this->_cacheKey()) {
			$this->addData(array(
				'cache_lifetime' => $lifeTime,
				'cache_tags' => array(Store::CACHE_TAG),
				'cache_key' => $cacheKey,
			));
		}
	}

	protected function _cacheKey(): string | null {
		$product = $this->registry->registry('product');
		if ($product) {
			//return get_class($this) . '::' . $this->storeManager->getStore()->getCode() . '::' . $product->getId();
		}

		return null;
	}

	protected function _prepareData() {
		parent::_prepareData();

		$isActive = $this->helper->isRelatedProductsActive();

		if ($isActive && count($this->getItems()) == 0) {
			$products = $this->collection->getRelatedProducts();
			if ($products) {
				$this->_itemCollection = $products;
			}
		}

		return $this;
	}

	public function getIdentities() {
		$identities = [];
		if (is_array($this->getItems()) || is_object($this->getItems())) {
			foreach ($this->getItems() as $item) {
				$identities = array_merge($identities, $item->getIdentities());
			}
		}

		return $identities;
	}
}