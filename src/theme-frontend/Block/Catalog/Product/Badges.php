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

namespace Eloom\ThemeFrontend\Block\Catalog\Product;

use Eloom\ThemeFrontend\Helper\Data;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class List Item Block Badges
 *
 * @api
 * @since 101.0.1
 */
class Badges extends Template {
	
	private $helper;
	
	private $jsonEncoder;
	
	private $storeManager;
	
	/**
	 * @var ProductInterface
	 */
	private $product;
	
	public function __construct(Context $context,
	                            EncoderInterface $jsonEncoder,
	                            StoreManagerInterface $storeManager,
	                            Data $helper,
	                            array $data = []) {
		$this->jsonEncoder = $jsonEncoder;
		$this->helper = $helper;
		$this->storeManager = $storeManager;
		
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
	public function getDateJsonConfig() {
		return $this->jsonEncoder->encode([
			'createdAt' => $this->product->getCreatedAt(),
			'newsFromDate' => $this->product->getNewsFromDate(),
			'newsToDate' => $this->product->getNewsToDate(),
			'text' => [
				'new' => __('New Product'),
				'recently' => __('Recently Product'),
			]
		]);
	}
	
	public function getInstallmentsJsonConfig() {
		$storeId = $this->storeManager->getStore()->getId();
		$installments = [
			'cc' => [
				'active' => $this->helper->isInstallmentsCcActive($storeId),
				'text' => __($this->helper->getInstallmentsCcText($storeId)),
				'minInstallment' => $this->helper->getInstallmentsCcMinInstallment($storeId),
				'installmensWithoutInterest' => $this->helper->getInstallmentsCcInstallmentsWithoutInterest($storeId)
			],
			'voucher' => [
				'active' => $this->helper->isInstallmentsVoucherActive($storeId),
				'text' => __($this->helper->getInstallmentsVoucherText($storeId)),
				'discount' => __($this->helper->getInstallmentsVoucherDiscount($storeId))
			]];
		
		return $this->jsonEncoder->encode($installments);
	}
}