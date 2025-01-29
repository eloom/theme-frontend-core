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

class Status {

	const DISABLED = 0;

	const ENABLED = 1;

	/**
	 * get available statuses.
	 *
	 * @return []
	 */
	public static function getAvailableStatuses() {
		return [
			self::ENABLED => __('Enabled')
			, self::DISABLED => __('Disabled'),
		];
	}

	public static function getOptionArray() {
		return self::getAvailableStatuses();
	}
}
