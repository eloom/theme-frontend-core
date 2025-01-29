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

namespace Eloom\ThemeFrontendCore\Block\Installments;

use Eloom\ThemeFrontendCore\Helper\Data;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\Registry;

class Product extends Template implements BlockInterface {
	
	private $storeManager;
	
	private $helper;
	
	private $jsonEncoder;
	
	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $coreRegistry = null;
	
	public function __construct(Context $context,
	                            StoreManagerInterface $storeManager,
	                            EncoderInterface $jsonEncoder,
	                            Registry $registry,
	                            Data $helper,
	                            array $data = []) {
		$this->helper = $helper;
		$this->storeManager = $storeManager;
		$this->jsonEncoder = $jsonEncoder;
		$this->coreRegistry = $registry;
		
		parent::__construct($context, $data);
	}
	
	public function getProduct() {
		return $this->coreRegistry->registry('product');
	}
	
	/**
	 * @inheritdoc
	 */
	public function getInstallmentsSerializedConfig() {
		$storeId = $this->storeManager->getStore()->getId();
		
		$data = ['cc' => [
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
		
		return $this->jsonEncoder->encode($data);
	}
}