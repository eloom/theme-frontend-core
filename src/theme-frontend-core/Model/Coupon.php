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

use Eloom\ThemeFrontendCore\Api\CouponInterface;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\SalesRule\Model\CouponFactory;
use Eloom\Core\Enumeration\HttpStatus;
use Magento\Checkout\Helper\Data as CheckoutData;

class Coupon implements CouponInterface {

	/**
	 * @var Json
	 */
	private $serializer;

	/**
	 * Sales quote repository
	 *
	 * @var CartRepositoryInterface
	 */
	private $quoteRepository;

	/**
	 * Coupon factory
	 *
	 * @var CouponFactory
	 */
	private $couponFactory;

	private $objectManager;

	private $cart;

	/**
	 * @var CheckoutData
	 */
	protected $checkoutHelper;

	public function __construct(Json                    $serializer = null,
	                            CouponFactory           $couponFactory,
	                            CartRepositoryInterface $quoteRepository,
	                            Cart                    $cart,
	                            CheckoutData            $checkoutHelper) {
		$this->objectManager = ObjectManager::getInstance();
		$this->serializer = $serializer ?: $this->objectManager->get(Json::class);
		$this->couponFactory = $couponFactory;
		$this->quoteRepository = $quoteRepository;
		$this->cart = $cart;
		$this->checkoutHelper = $checkoutHelper;
	}

	/**
	 * @inheritDoc
	 */
	public function apply(bool $remove, $couponCode) {
		$response = ['code' => HttpStatus::OK()->getCode()];

		$couponCode = $remove == 1 ? '' : trim($couponCode);
		$quote = $this->cart->getQuote();
		$oldCouponCode = $quote->getCouponCode();
		$message = null;

		$codeLength = strlen($couponCode);
		if (!$codeLength && !strlen($oldCouponCode)) {
		}

		try {
			$isCodeLengthValid = $codeLength && $codeLength <= \Magento\Checkout\Helper\Cart::COUPON_CODE_MAX_LENGTH;

			$itemsCount = $quote->getItemsCount();
			if ($itemsCount) {
				$quote->getShippingAddress()->setCollectShippingRates(true);
				$quote->setCouponCode($isCodeLengthValid ? $couponCode : '')->collectTotals();
				$this->quoteRepository->save($quote);
			}

			if ($codeLength) {
				$escaper = $this->objectManager->get(Escaper::class);
				$coupon = $this->couponFactory->create();
				$coupon->load($couponCode, 'code');

				if (!$itemsCount) {
					if ($isCodeLengthValid && $coupon->getId()) {
						$quote->setCouponCode($couponCode)->save();
						$message = __('You used coupon code "%1".', $escaper->escapeHtml($couponCode));
					} else {
						$message = __('The coupon code "%1" is not valid.', $escaper->escapeHtml($couponCode));
					}
				} else {
					if ($isCodeLengthValid && $coupon->getId() && $couponCode == $quote->getCouponCode()) {
						$message = __('You used coupon code "%1".', $escaper->escapeHtml($couponCode));
					} else {
						$message = __('The coupon code "%1" is not valid.', $escaper->escapeHtml($couponCode));
					}
				}
			} else {
				$message = __('You canceled the coupon code.');
			}
		} catch (LocalizedException $e) {
			$message = $e->getMessage();
		} catch (\Exception $e) {
			$message = __('We cannot apply the coupon code.');
		}

		$addressTotals = null;
		if ($quote->isVirtual()) {
			$addressTotals = $quote->getBillingAddress()->getTotals();
		} else {
			$addressTotals = $quote->getShippingAddress()->getTotals();
		}

		$totals = [];
		foreach ($addressTotals as $item) {
			if ($item->getCode() == 'discount') {
				$totals[] = ['title' => $item->getTitle(), 'value' => $this->checkoutHelper->formatPrice($item->getValue())];

				break;
			}
		}

		$response['data'] = [
			'message' => $message,
			'couponCode' => $quote->getCouponCode(),
			'totals' => $totals];

		return $this->serializer->serialize($response);
	}

	public function getDiscount() {
		$response = ['code' => HttpStatus::OK()->getCode()];
		$quote = $this->cart->getQuote();

		$addressTotals = null;
		if ($quote->isVirtual()) {
			$addressTotals = $quote->getBillingAddress()->getTotals();
		} else {
			$addressTotals = $quote->getShippingAddress()->getTotals();
		}

		$totals = [];
		foreach ($addressTotals as $item) {
			if ($item->getCode() == 'discount') {
				$totals[] = ['title' => $item->getTitle(), 'value' => $this->checkoutHelper->formatPrice($item->getValue())];

				break;
			}
		}

		$response['data'] = [
			'couponCode' => $quote->getCouponCode(),
			'totals' => $totals];

		return $this->serializer->serialize($response);
	}
}