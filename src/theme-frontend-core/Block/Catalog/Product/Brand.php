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

namespace Eloom\ThemeFrontendCore\Block\Catalog\Product;

use Eloom\ThemeFrontendCore\Helper\Brand as Helper;
use Eloom\ThemeFrontendCore\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;

class Brand extends \Magento\Framework\View\Element\Template {

	public $helper;

	protected $brand;

	/**
	 * @var CollectionFactory
	 */

	protected $brandCollectionFactory;

	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $coreRegistry;

	public function __construct(Context           $context,
	                            Registry          $registry,
	                            CollectionFactory $brandCollectionFactory,
	                            Helper            $helper,
	                            array             $data = []) {
		$this->coreRegistry = $registry;
		$this->brandCollectionFactory = $brandCollectionFactory;
		$this->helper = $helper;

		parent::__construct($context, $data);
	}

	/**
	 * Retrieve current product model
	 *
	 * @return Product
	 */
	public function getProduct() {
		return $this->coreRegistry->registry('current_product');
	}

	public function getBrand() {
		if ($this->brand) {
			return $this->brand;
		}

		$brandCode = $this->helper->getAttributeCode();
		if (!$brandCode) {
			return;
		}
		$product = $this->getProduct();
		$brandId = $product->getData($brandCode);
		if (!$brandId) {
			return;
		}
		$labelAtribute = $product->getAttributeText($brandCode);

		$storeId = $this->_storeManager->getStore()->getStoreId();
		$brand = $this->brandCollectionFactory->create()
			->addFieldToFilter('stores', array(array('finset' => 0), array('finset' => $storeId)))
			->addFieldToFilter('option_id', $brandId)
			->addFieldToFilter('status', 1)
			->setPageSize(1);

		$this->brand = $brand->getFirstItem();
		if ($this->brand->getId()) {
			$this->brand->setData('label', $labelAtribute);

			return $this->brand;
		}
	}

	public function getUrlBrand($brand) {
		return $this->helper->getLink($brand);
	}

	public function getImage($brand) {
		return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $brand->getImage();
	}
}
