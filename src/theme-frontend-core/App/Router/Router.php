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

namespace Eloom\ThemeFrontendCore\App\Router;

use Eloom\ThemeFrontendCore\Helper\Brand as Helper;
use Eloom\ThemeFrontendCore\Model\BrandFactory;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface {

	protected $actionFactory;

	protected $brand;

	protected $helper;

	protected $response;

	public function __construct(ActionFactory     $actionFactory,
	                            ResponseInterface $response,
	                            BrandFactory      $brand,
	                            Helper              $helper) {
		$this->actionFactory = $actionFactory;
		$this->response = $response;
		$this->brand = $brand;
		$this->helper = $helper;
	}

	public function match(RequestInterface $request) {
		if ($this->helper->isActive()) {
			$identifier = trim($request->getPathInfo(), '/');
			$router = $this->helper->getRouter();
			$urlSuffix = $this->helper->getUrlSuffix();
			if ($length = strlen($urlSuffix)) {
				if (substr($identifier, -$length) == $urlSuffix) {
					$identifier = substr($identifier, 0, strlen($identifier) - $length);
				}
			}

			$routePath = explode('/', $identifier);
			$routeSize = sizeof($routePath);

			if ($identifier == $router) {
				$request->setModuleName('eloomtheme')
					->setControllerName('brand')
					->setActionName('list')
					->setPathInfo('/eloomtheme/brand/list');

				return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
			} elseif ($routeSize == 2 && $routePath[0] == $router) {
				$urlKey = $routePath[1];
				$model = $this->brand->create();
				$model->load($urlKey, 'urlkey');

				if (!empty($model->load($urlKey, 'urlkey'))) {
					$id = $model->load($urlKey, 'urlkey')->getData('entity_id');
					$request->setModuleName('eloomtheme')
						->setControllerName('brand')
						->setActionName('view')
						->setParam('id', $id)
						->setPathInfo('/eloomtheme/brand/view');

					return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
				}
			}
		}
	}
}