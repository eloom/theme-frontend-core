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

namespace Eloom\ThemeFrontendCore\Model\Product\ProductList\Related;

use Eloom\ThemeFrontendCore\Helper\Data as Helper;
use Magento\Catalog\Model\Product\Visibility;
use Magento\CatalogInventory\Helper\Stock;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;

class Collection extends AbstractModel {

	/**
	 * @var Helper
	 */
	protected $helper;

	/**
	 * @var Registry
	 */
	protected $registry;

	/**
	 * @var Stock
	 */
	protected $stockHelper;

	/**
	 * @var Visibility
	 */
	protected $productVisibility;


	public function __construct(Registry   $registry,
	                            Helper     $helper,
	                            Stock      $stockHelper,
	                            Visibility $productVisibility) {
		$this->registry = $registry;
		$this->helper = $helper;
		$this->stockHelper = $stockHelper;
		$this->productVisibility = $productVisibility;
	}

	public function getRelatedProducts($limit = false) {
		$objectManager = ObjectManager::getInstance();
		$products = $this->getData('products');

		if (!$products) {
			$product = $this->registry->registry('product');
			if ($category = $this->registry->registry('category')) {
			} elseif ($product) {
				$ids = $product->getCategoryIds();
				if (!empty($ids)) {
					$category = $objectManager->get('Magento\Catalog\Model\Category')->load($ids[0]);
				}
			}

			if ($category) {
				if ($limit === false) {
					$limit = $this->helper->getRelatedProductsLimit();
				}

				$products = $objectManager->get('Magento\Catalog\Model\ResourceModel\Product\Collection')
					->setVisibility($this->productVisibility->getVisibleInSiteIds())
					->addAttributeToFilter('status', 1)
					//->addAttributeToFilter('qty', array('gt' => 0))
					->addCategoryFilter($category)
					->addAttributeToSelect('*')
					->setPageSize($limit);

				if ($product) {
					$products->addAttributeToFilter('entity_id', array(
						'neq' => $this->registry->registry('product')->getId()));
				}

				$products->getSelect()->order(new \Zend_Db_Expr('RAND()'));

				$this->setData('related_products', $products);
			}
		}

		return $products;
	}
}