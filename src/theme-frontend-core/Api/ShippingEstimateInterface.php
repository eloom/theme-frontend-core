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

namespace Eloom\ThemeFrontendCore\Api;

/**
 * Interface for ShippingEstimate.
 * @api
 * @since 100.0.2
 */
interface ShippingEstimateInterface {
	
	/**
	 *
	 * @param \Eloom\ThemeFrontendCore\Api\Data\AddressInterface $address
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function estimateByAddress(\Eloom\ThemeFrontendCore\Api\Data\AddressInterface $address);
}