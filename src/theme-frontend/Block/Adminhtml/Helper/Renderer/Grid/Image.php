<?php
/**
* 
* Temas para Magento 2
* 
* @category     elOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontend\Block\Adminhtml\Helper\Renderer\Grid;

use Eloom\ThemeFrontend\Model\BrandFactory;
use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Cms\Model\BlockFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\DataObject;

class Image extends AbstractRenderer {

	/**
	 *
	 * @var StoreManagerInterface
	 */
	protected $storeManager;

	/**
	 *
	 * @var BrandFactory
	 */
	protected $brandFactory;

	/**
	 * [__construct description].
	 *
	 * @param Context $context
	 * @param StoreManagerInterface $storeManager
	 * @param BlockFactory $blockFactory
	 * @param array $data
	 */
	public function __construct(Context               $context,
	                            StoreManagerInterface $storeManager,
	                            BrandFactory          $brandFactory,
	                            array                 $data = []) {
		parent::__construct($context, $data);
		$this->storeManager = $storeManager;
		$this->brandFactory = $brandFactory;
	}

	/**
	 * Render action.
	 *
	 * @param DataObject $row
	 *
	 * @return string
	 */
	public function render(DataObject $row) {
		$storeViewId = $this->getRequest()->getParam('store');
		$brand = $this->brandFactory->create()->setStoreViewId($storeViewId)->load($row->getId());
		$srcImage = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $brand->getImage();

		return '<image width="150" height="50" src ="' . $srcImage . '" alt="' . $brand->getImage() . '" >';
	}
}
