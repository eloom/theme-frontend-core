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

namespace Eloom\ThemeFrontendCore\Block\Theme;

use Eloom\ThemeFrontendCore\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;

class CookieNotice extends Template implements BlockInterface {
	
	private $storeManager;
	
	private $helper;
	
	public function __construct(Context $context,
	                            StoreManagerInterface $storeManager,
	                            Data $helper,
	                            array $data = []) {
		$this->helper = $helper;
		$this->storeManager = $storeManager;
		
		parent::__construct($context, $data);
	}
	
	/**
	 * @inheritdoc
	 */
	public function getJsLayout() {
		$storeId = $this->storeManager->getStore()->getId();
		
		$this->jsLayout['components']['cookie-notice'] = [
			'active' => $this->helper->isCookieNoticeActive($storeId),
			'text' => __($this->helper->isCookieNoticeText($storeId)),
			'url' => $this->helper->isCookieNoticeUrl($storeId)
		];
		$this->jsLayout['components']['cookie-notice']['component'] = 'Eloom_ThemeFrontendCore/js/cookie-notice/cookie';
		
		return parent::getJsLayout();
	}
}