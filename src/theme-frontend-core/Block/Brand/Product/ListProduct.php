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

namespace Eloom\ThemeFrontendCore\Block\Brand\Product;

use Eloom\ThemeFrontendCore\Helper\Brand as Helper;
use Eloom\ThemeFrontendCore\Model\BrandFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Resource\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Helper\Stock;
use Magento\CatalogInventory\Model\Configuration;
use Magento\Eav\Model\Config;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Url\Helper\Data;
use Magento\Catalog\Block\Product\Context;
use Magento\Store\Model\StoreManagerInterface;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct {

	/**
	 * Catalog Layer
	 *
	 * @var Resolver
	 */
	protected $catalogLayer;

	/**
	 * @var PostHelper
	 */
	protected $postDataHelper;

	/**
	 * @var Data
	 */
	protected $urlHelper;

	/**
	 * @var CategoryRepositoryInterface
	 */
	protected $categoryRepository;

	/**
	 * Catalog product visibility
	 *
	 * @var Visibility
	 */
	protected $catalogProductVisibility;

	/**
	 * Product collection factory
	 *
	 * @var CollectionFactory
	 */
	protected $productCollectionFactory;

	/**
	 *
	 * @var StoreManagerInterface
	 */
	protected $objectManager;

	protected $stockConfig;

	/**
	 * @var Stock
	 */
	protected $stockFilter;

	/**
	 * [$_brandFactory description]
	 * @var BrandFactory
	 */
	protected $brandFactory;

	/**
	 * [$_limit description]
	 * @var [type]
	 */
	protected $limit;

	/**
	 * [$_helperData description]
	 * @var [type]
	 */
	protected $helper;

	public function __construct(Context                     $context,
	                            PostHelper                  $postDataHelper,
	                            Resolver                    $layerResolver,
	                            CategoryRepositoryInterface $categoryRepository,
	                            Data                        $urlHelper,
	                            Config                      $eavConfig,
	                            BrandFactory                $brandFactory,
	                            Helper                      $helperData,
	                            ObjectManagerInterface      $objectManager,
	                            CollectionFactory           $productCollectionFactory,
	                            Visibility                  $catalogProductVisibility,
	                            Stock                       $stockFilter,
	                            Configuration               $stockConfig,
	                            array                       $data = []) {
		$this->catalogLayer = $layerResolver->get();
		$this->postDataHelper = $postDataHelper;
		$this->categoryRepository = $categoryRepository;
		$this->urlHelper = $urlHelper;
		$this->brandFactory = $brandFactory;
		$this->helper = $helperData;
		$this->_eavConfig = $eavConfig;
		$this->objectManager = $objectManager;
		$this->productCollectionFactory = $productCollectionFactory;
		$this->catalogProductVisibility = $catalogProductVisibility;
		$this->stockFilter = $stockFilter;
		$this->stockConfig = $stockConfig;

		parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
	}

	public function getType() {
		$brandId = $this->getRequest()->getParam('id', 0);

		return $this->brandFactory->create()->load($brandId);
	}

	protected function _getProductCollection() {
		if (is_null($this->_productCollection)) {
			$brand = $this->getType()->getData('option_id');
			$collection = $this->initializeProductCollection($brand);

			if ($this->stockConfig->isShowOutOfStock() != 1) {
				$this->stockFilter->addInStockFilterToCollection($collection);
			}

			$this->_productCollection = $collection;
		}
		$page = $this->getRequest()->getParam('p', 1);

		return $this->_productCollection->setCurPage($page);
	}

	private function initializeProductCollection($brand) {
		$attributeCode = $this->helper->getAttributeCode();
		$collection = $this->productCollectionFactory->create()
			->addAttributeToFilter($attributeCode, $brand)
			->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds())
			->addStoreFilter()
			->addAttributeToSelect('*')
			->addMinimalPrice()
			->addFinalPrice()
			->addTaxPercents();

		return $collection;
	}
}
