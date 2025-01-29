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

namespace Eloom\ThemeFrontendCore\App;

use Eloom\ThemeFrontendCore\Error\Maintenance;
use Exception;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\Http;

class MaintenanceHandler {
	
	/**
	 * @var Maintenance
	 */
	private $maintenance;
	
	/**
	 * HttpPlugin constructor.
	 *
	 * @param Maintenance $maintenance
	 */
	public function __construct(Maintenance $maintenance) {
		$this->maintenance = $maintenance;
	}
	
	/**
	 * @param Http $subject
	 * @param callable $proceed
	 * @param Bootstrap $bootstrap
	 * @param Exception $exception
	 *
	 * @return bool
	 */
	public function aroundCatchException(Http      $subject,
	                                     callable  $proceed,
	                                     Bootstrap $bootstrap,
	                                     Exception $exception) {
		if (!$bootstrap->isDeveloperMode() && $bootstrap->getErrorCode() === Bootstrap::ERR_MAINTENANCE) {
			$this->maintenance->renderPage();
			
			return true;
		}
		
		return $proceed($bootstrap, $exception);
	}
}
