<?php
/**
* 
* Temas para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2021 Ã©lOOm (https://www.eloom.com.br)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontend\Api;

/**
 * Interface for Measure.
 * @api
 * @since 100.0.2
 */
interface MeasureInterface {
	
	/**
	 *
	 * @param string $productId
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getContent($productId);
}