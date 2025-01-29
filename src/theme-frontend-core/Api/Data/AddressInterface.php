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

namespace Eloom\ThemeFrontendCore\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface AddressInterface extends ExtensibleDataInterface {
	
	/**
	 * Get postcode
	 *
	 * @return string
	 */
	public function getPostCode();
	
	/**
	 * Set postcode
	 *
	 * @param string $postCode
	 * @return $this
	 */
	public function setPostCode($postCode);
	
	/**
	 * Get product Id
	 *
	 * @return string
	 */
	public function getProductId();
	
	/**
	 * Set product Id
	 *
	 * @param string $productId
	 * @return $this
	 */
	public function setProductId($productId);
	
	
	/**
	 * Get product quantity
	 *
	 * @return string
	 */
	public function getQty();
	
	/**
	 * Set product quantity
	 *
	 * @param string $qty
	 * @return $this
	 */
	public function setQty($qty);
	
	/**
	 * Get product options
	 *
	 * @return string
	 */
	public function getOptions();
	
	/**
	 * Set product options
	 *
	 * @param string $options
	 * @return $this
	 */
	public function setOptions($options);
}