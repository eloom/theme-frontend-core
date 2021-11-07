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

namespace Eloom\ThemeFrontend\Api;

/**
 * Interface for Coupon.
 * @api
 * @since 100.0.2
 */
interface CouponInterface {

	/**
	 *
	 * @param boolean $remove
	 * @param string $couponCode
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function apply(bool $remove, $couponCode);

	/**
	 *
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getDiscount();
}