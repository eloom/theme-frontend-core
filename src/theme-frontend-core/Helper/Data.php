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

namespace Eloom\ThemeFrontendCore\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

	const XML_PATH_INSTALLMENTS_CC_ACTIVE = 'eloom_themefrontend/installments/cc_active';
	const XML_PATH_INSTALLMENTS_CC_TEXT = 'eloom_themefrontend/installments/cc_text';
	const XML_PATH_INSTALLMENTS_CC_MIN_INSTALLMENT = 'eloom_themefrontend/installments/cc_min_installment';
	const XML_PATH_INSTALLMENTS_CC_INSTALLMENS_WITHOUT_INTEREST = 'eloom_themefrontend/installments/cc_installmens_without_interest';

	const XML_PATH_INSTALLMENTS_VOUCHER_ACTIVE = 'eloom_themefrontend/installments/voucher_active';
	const XML_PATH_INSTALLMENTS_VOUCHER_TEXT = 'eloom_themefrontend/installments/voucher_text';
	const XML_PATH_INSTALLMENTS_VOUCHER_DISCOUNT = 'eloom_themefrontend/installments/voucher_discount';

	const XML_PATH_COOKIE_NOTICE_ACTIVE = 'eloom_themefrontend/cookie_notice/active';
	const XML_PATH_COOKIE_NOTICE_TEXT = 'eloom_themefrontend/cookie_notice/text';
	const XML_PATH_COOKIE_NOTICE_URL = 'eloom_themefrontend/cookie_notice/url';

	const XML_PATH_AUTO_RELATED_ACTIVE = 'eloom_themefrontend/auto_related/active';
	const XML_PATH_AUTO_RELATED_LIMIT = 'eloom_themefrontend/auto_related/limit';
	const XML_PATH_AUTO_RELATED_CACHE_LIFETIME = 'eloom_themefrontend/auto_related/cache_lifetime';

	private $storeManager;

	public function __construct(Context               $context,
	                            ScopeConfigInterface  $scopeConfig,
	                            StoreManagerInterface $storeManager) {
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;

		parent::__construct($context);
	}

	public function isInstallmentsCcActive($storeId = null): bool {
		return (boolean)$this->scopeConfig->getValue(self::XML_PATH_INSTALLMENTS_CC_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getInstallmentsCcText($storeId = null): string {
		return $this->scopeConfig->getValue(self::XML_PATH_INSTALLMENTS_CC_TEXT, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getInstallmentsCcMinInstallment($storeId = null): float {
		return floatval($this->scopeConfig->getValue(self::XML_PATH_INSTALLMENTS_CC_MIN_INSTALLMENT, ScopeInterface::SCOPE_STORE, $storeId));
	}

	public function getInstallmentsCcInstallmentsWithoutInterest($storeId = null): int {
		return intval($this->scopeConfig->getValue(self::XML_PATH_INSTALLMENTS_CC_INSTALLMENS_WITHOUT_INTEREST, ScopeInterface::SCOPE_STORE, $storeId));
	}

	public function isInstallmentsVoucherActive($storeId = null): bool {
		return (boolean)$this->scopeConfig->getValue(self::XML_PATH_INSTALLMENTS_VOUCHER_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getInstallmentsVoucherText($storeId = null): string {
		return $this->scopeConfig->getValue(self::XML_PATH_INSTALLMENTS_VOUCHER_TEXT, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getInstallmentsVoucherDiscount($storeId = null): float {
		return floatval($this->scopeConfig->getValue(self::XML_PATH_INSTALLMENTS_VOUCHER_DISCOUNT, ScopeInterface::SCOPE_STORE, $storeId));
	}

	public function isCookieNoticeActive($storeId = null): bool {
		return (boolean)$this->scopeConfig->getValue(self::XML_PATH_COOKIE_NOTICE_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function isCookieNoticeText($storeId = null): string {
		return $this->scopeConfig->getValue(self::XML_PATH_COOKIE_NOTICE_TEXT, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function isCookieNoticeUrl($storeId = null): string {
		return $this->scopeConfig->getValue(self::XML_PATH_COOKIE_NOTICE_URL, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function isRelatedProductsActive($storeId = null): bool {
		return (boolean)$this->scopeConfig->getValue(self::XML_PATH_AUTO_RELATED_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getRelatedProductsLimit($storeId = null): int {
		return intval($this->scopeConfig->getValue(self::XML_PATH_AUTO_RELATED_LIMIT, ScopeInterface::SCOPE_STORE, $storeId));
	}

	public function getRelatedProductsCacheLifetime($storeId = null): int {
		return intval($this->scopeConfig->getValue(self::XML_PATH_AUTO_RELATED_CACHE_LIFETIME, ScopeInterface::SCOPE_STORE, $storeId));
	}
}