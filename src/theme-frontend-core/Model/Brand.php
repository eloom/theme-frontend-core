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

namespace Eloom\ThemeFrontendCore\Model;

use Eloom\ThemeFrontendCore\Helper\Brand as Helper;
use Eloom\ThemeFrontendCore\Model\ResourceModel\Brand\Collection;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class Brand extends AbstractModel {
	/**
	 * @var Visibility
	 */
	protected $catalogProductVisibility;

	/**
	 * @var CollectionFactory
	 */
	protected $productCollectionFactory;

	/**
	 * @var Helper
	 */
	protected $helper;

	/**
	 * @var CollectionFactory
	 */

	protected $brandCollectionFactory;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	protected function _construct() {
		$this->_init('Eloom\ThemeFrontendCore\Model\ResourceModel\Brand');
	}

	public function __construct(Context                                                          $context,
	                            Registry                                                         $registry,
	                            ScopeConfigInterface                                             $scopeConfig,
	                            Visibility                                                       $catalogProductVisibility,
	                            CollectionFactory                                                $productCollectionFactory,
	                            \Eloom\ThemeFrontendCore\Model\ResourceModel\Brand\CollectionFactory $brandCollectionFactory,
	                            \Eloom\ThemeFrontendCore\Model\ResourceModel\Brand                   $resource,
	                            Collection                                                       $resourceCollection,
	                            Helper                                                             $helper) {
		parent::__construct($context, $registry, $resource, $resourceCollection);

		$this->productCollectionFactory = $productCollectionFactory;
		$this->catalogProductVisibility = $catalogProductVisibility;
		$this->helper = $helper;
		$this->brandCollectionFactory = $brandCollectionFactory;
	}

	/**
	 * Retrieve post related products
	 * @param int $storeId
	 * @return CollectionFactory
	 */
	public function getRelatedProducts($storeId = null) {
		if (!$this->hasData('related_products')) {
			$collection = $this->productCollectionFactory->create();

			if (!is_null($storeId)) {
				$collection->addStoreFilter($storeId);
			} elseif ($storeIds = $this->getStoreId()) {
				$collection->addStoreFilter($storeIds[0]);
			}

			$attributeCode = $this->helper->getAttribute($storeId);
			if ($attributeCode) {
				$collection->addAttributeToFilter($attributeCode, $this->getOptionId());
			}
			$this->setData('related_products', $collection);
		}

		return $this->getData('related_products');
	}

	public function getProductsPosition() {
		if (!$this->getId()) {
			return [];
		}
		$array = $this->getData('products_position');
		if ($array === null) {
			$array = $this->getResource()->getProductsPosition($this);
			$this->setData('products_position', $array);
		}

		return $array;
	}

	public function getProductCollection() {
		$collection = $this->productCollectionFactory->create()->addAttributeToSelect('*')
			->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());
		$attributeCode = $this->helper->getAttributeCode();
		if ($attributeCode) {
			$collection->addAttributeToFilter($attributeCode, $this->getOptionId());
		}

		return $collection;
	}
}
