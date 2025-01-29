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

class Address implements AddressInterface {
	
	protected $qty;
	
	protected $postCode;
	
	protected $productId;
	
	/**
	 * @var Options
	 */
	protected $options;
	
	/**
	 * @return mixed
	 */
	public function getQty() {
		return $this->qty;
	}
	
	public function setQty($qty) {
		$this->qty = $qty;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPostCode() {
		return $this->postCode;
	}
	
	public function setPostCode($postCode) {
		$this->postCode = $postCode;
		return $this;
	}
	
	public function getProductId() {
		return $this->productId;
	}
	
	public function setProductId($productId) {
		$this->productId = $productId;
		return $this;
	}
	
	
	public function getOptions() {
		return $this->options;
	}
	
	public function setOptions($options) {
		$this->options = $options;
		
		return $this;
	}
}