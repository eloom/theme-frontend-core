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

namespace Eloom\ThemeFrontendCore\Plugin\Brand;

use Eloom\ThemeFrontendCore\Helper\Brand as Helper;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\TreeFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Block\Html\Topmenu as MageTopmenu;

class Topmenu {

	/**
	 * @var Helper
	 */
	protected $helper;

	/**
	 * @var TreeFactory
	 */
	protected $treeFactory;

	/**
	 * @var RequestInterface
	 */
	protected $request;

	/**
	 * @var StoreManagerInterface
	 */
	private $storeManager;

	/**
	 * Topmenu constructor.
	 *
	 * @param Helper $helper
	 * @param TreeFactory $treeFactory
	 * @param RequestInterface $request
	 */
	public function __construct(TreeFactory           $treeFactory,
	                            RequestInterface      $request,
	                            Helper                $helper,
	                            StoreManagerInterface $storeManager) {
		$this->treeFactory = $treeFactory;
		$this->request = $request;
		$this->helper = $helper;
		$this->storeManager = $storeManager;
	}

	/**
	 * @param MageTopmenu $subject
	 * @param string $outermostClass
	 * @param string $childrenWrapClass
	 * @param int $limit
	 *
	 * @return array
	 */
	public function beforeGetHtml(MageTopmenu $subject,
	                                          $outermostClass = '',
	                                          $childrenWrapClass = '',
	                                          $limit = 0) {
		$storeId = $this->storeManager->getStore()->getId();
		if ($this->helper->isActive($storeId) && $this->helper->isTopMenuActive($storeId)) {
			$subject->getMenu()->addChild(
				new Node(
					$this->getBrandMenu(),
					'id',
					$this->treeFactory->create()
				)
			);

			return [$outermostClass, $childrenWrapClass, $limit];
		};
	}

	/**
	 * @return array
	 */
	private function getBrandMenu() {
		$storeId = $this->storeManager->getStore()->getId();

		return [
			'name' => __('Brands'),
			'id' => 'brand-node',
			'url' => $this->helper->getUrlRouter($storeId)
		];
	}
}
