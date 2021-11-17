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

namespace Eloom\ThemeFrontend\Controller\Adminhtml;

use Eloom\ThemeFrontend\Model\BrandFactory;
use Eloom\ThemeFrontend\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ObjectManager;

abstract class Brand extends \Magento\Backend\App\Action {

	/**
	 * @var Js
	 */
	protected $jsHelper;

	/**
	 * @var ForwardFactory
	 */
	protected $resultForwardFactory;

	/**
	 * @var LayoutFactory
	 */
	protected $resultLayoutFactory;

	/**
	 * A factory that knows how to create a "page" result
	 * Requires an instance of controller action in order to impose page type,
	 * which is by convention is determined from the controller action class.
	 *
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	protected $brandFactory;

	protected $brandCollectionFactory;

	/**
	 * Registry object.
	 *
	 * @var Registry
	 */
	protected $coreRegistry;

	/**
	 * File Factory.
	 *
	 * @var FileFactory
	 */
	protected $fileFactory;

	protected $objectManager;

	public function __construct(Context           $context,
	                            BrandFactory      $brandFactory,
	                            CollectionFactory $brandCollectionFactory,
	                            Registry          $coreRegistry,
	                            FileFactory       $fileFactory,
	                            PageFactory       $resultPageFactory,
	                            LayoutFactory     $resultLayoutFactory,
	                            ForwardFactory    $resultForwardFactory,
	                            Js                $jsHelper) {
		parent::__construct($context);

		$this->objectManager = ObjectManager::getInstance();
		$this->coreRegistry = $coreRegistry;
		$this->fileFactory = $fileFactory;
		$this->jsHelper = $jsHelper;

		$this->resultPageFactory = $resultPageFactory;
		$this->resultLayoutFactory = $resultLayoutFactory;
		$this->resultForwardFactory = $resultForwardFactory;

		$this->brandFactory = $brandFactory;
		$this->brandCollectionFactory = $brandCollectionFactory;
	}

	protected function _isAllowed() {
		return $this->_authorization->isAllowed('Eloom_ThemeFrontend::brand');
	}
}
