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

namespace Eloom\ThemeFrontendCore\Model;

use Eloom\ThemeFrontendCore\Api\Data\AddressInterface;
use Eloom\ThemeFrontendCore\Api\ShippingEstimateInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\CartFactory;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;

class ShippingEstimate implements ShippingEstimateInterface {
	
	private $serializer;

	private $objectManager;
	
	/**
	 * @var ProductRepositoryInterface
	 */
	private $productRepository;

	private $directoryHelper;

	private $pricingHelper;

	private $cart;
	
	public function __construct(Json $serializer = null,
	                            ProductRepositoryInterface $productRepository,
	                            DirectoryHelper $directoryHelper,
	                            PricingHelper $pricingHelper,
	                            CartFactory $cart) {
		
		$this->objectManager = ObjectManager::getInstance();
		$this->serializer = $serializer ?: $this->objectManager->get(Json::class);
		$this->productRepository = $productRepository;
		$this->directoryHelper = $directoryHelper;
		$this->pricingHelper = $pricingHelper;
		$this->cart = $cart;
	}
	
	public function estimateByAddress(AddressInterface $address) {
		$store = $this->objectManager->get(StoreManagerInterface::class)->getStore();
		$countryCode = $this->directoryHelper->getDefaultCountry($store->getId());
		
		$params = array(
			'product' => $address->getProductId(),
			'qty' => $address->getQty()
		);
		
		$options = [];
		if ($address->getOptions()) {
			$optionsExploded = explode(',', $address->getOptions());
			foreach ($optionsExploded as $value) {
				$optionExploded = explode('|', $value);
				$options[$optionExploded[0]] = $optionExploded[1];
			}
		}
		if (count($options)) {
			$params['super_attribute'] = $options;
		}
		$product = $this->initProduct($address->getProductId(), $store->getId());
		
		$cart = $this->cart->create();
		$cart->addProduct($product, $params);
		
		$quote = $cart->getQuote();
		if ($quote->getTotalsCollectedFlag() === false) {
			$quote->collectTotals();
		}
		$quote->setIsCheckoutCart(true);
		$quote->setCustomerIsGuest(1);
		$quote->setStore($store);
		
		$rates = $quote->getShippingAddress()
			->setCountryId($countryCode)
			->setPostcode($address->getPostCode())
			->setCollectShippingRates(true)
			->collectShippingRates()
			->getShippingRatesCollection();
		
		$carriers = [];
		$items = [];
		foreach ($rates as $rate) {
			$carriers[$rate->getCarrier()] = [
				'carrierCode' => $rate->getCarrier(),
				'carrierTitle' => $rate->getCarrierTitle()
			];
			
			$item = [
				'methodCode' => $rate->getMethod(),
				'methodTitle' => $rate->getMethodTitle(),
				'price' => $this->pricingHelper->currency($rate->getPrice()),
				'message' => $rate->getErrorMessage() ?? ''
			];
			
			$items[$rate->getCarrier()][$rate->getMethod()] = $item;
		}
		
		foreach ($items as $key => $value) {
			foreach ($value as $item) {
				$carriers[$key]['items'][] = $item;
			}
		}
		
		return $this->serializer->serialize(['data' => $carriers]);
	}
	
	/**
	 * Initialize product instance from request data
	 *
	 * @return \Magento\Catalog\Model\Product|null
	 */
	protected function initProduct($productId, $storeId) {
		$product = null;
		try {
			$product = $this->productRepository->getById($productId, false, $storeId);
		} catch (NoSuchEntityException $e) {
			
		}
		
		return $product;
	}
}