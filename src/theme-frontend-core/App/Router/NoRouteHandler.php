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

namespace Eloom\ThemeFrontendCore\App\Router;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Router\NoRouteHandlerInterface;

class NoRouteHandler implements NoRouteHandlerInterface {
	
	public function process(RequestInterface $request) {
		$requestValue = ltrim($request->getPathInfo(), '/');
		$request->setParam('q', $requestValue);
		$request->setModuleName('catalogsearch')->setControllerName('result')->setActionName('index');
		
		return true;
	}
}