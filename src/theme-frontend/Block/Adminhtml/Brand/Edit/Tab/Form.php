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

namespace Eloom\ThemeFrontend\Block\Adminhtml\Brand\Edit\Tab;

use Eloom\ThemeFrontend\Model\Status;
use Magento\Framework\DataObjectFactory;
use Magento\Catalog\Model\Category\Attribute\Source\Page;
use Eloom\ThemeFrontend\Model\Brand;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Eloom\ThemeFrontend\Helper\Data;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Store\Model\System\Store;
use Magento\Cms\Model\Wysiwyg\Config;
use Eloom\ThemeFrontend\Model\System\Config\Brand as SystemBrand;

class Form extends Generic implements TabInterface {

	/**
	 * @var DataObjectFactory
	 */
	protected $objectFactory;

	/**
	 * @var SystemBrand
	 */
	protected $systemBrand;

	/**
	 * @var Brand
	 */
	protected $brand;

	/**
	 * @var Data
	 */
	protected $helper;

	/**
	 * @var Store
	 */
	protected $systemStore;

	/**
	 * @var Config
	 */
	protected $wysiwygConfig;

	public function __construct(Context           $context,
	                            Registry          $registry,
	                            FormFactory       $formFactory,
	                            DataObjectFactory $objectFactory,
	                            Store             $systemStore,
	                            Config            $wysiwygConfig,
	                            Brand             $brand,
	                            SystemBrand       $systemBrand,
	                            Data              $helper,
	                            array             $data = []) {
		$this->objectFactory = $objectFactory;
		$this->brand = $brand;
		$this->systemBrand = $systemBrand;
		$this->helper = $helper;
		$this->systemStore = $systemStore;
		$this->wysiwygConfig = $wysiwygConfig;

		parent::__construct($context, $registry, $formFactory, $data);
	}

	/**
	 * prepare layout.
	 *
	 * @return $this
	 */
	protected function _prepareLayout() {
		$this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());

		return $this;
	}

	/**
	 * Prepare form.
	 *
	 * @return $this
	 */
	protected function _prepareForm() {
		$model = $this->_coreRegistry->registry('brand');

		/** @var \Magento\Framework\Data\Form $form */
		$form = $this->_formFactory->create();

		$form->setHtmlIdPrefix('eloom_');

		$fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Brand Information')]);

		if ($model->getId()) {
			$fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
		}

		$fieldset->addField('title', 'text',
			[
				'label' => __('Title'),
				'title' => __('Title'),
				'name' => 'title',
				'required' => true,
			]
		);

		$fieldset->addField('urlkey', 'text',
			[
				'label' => __('URL key'),
				'title' => __('URL key'),
				'name' => 'urlkey',
				'required' => true,
				'class' => 'validate-xml-identifier',
			]
		);

		$brandOptions = $this->systemBrand->toOptionArray();
		if (array_filter($brandOptions)) {
			$fieldset->addField('option_id', 'select',
				[
					'label' => __('Brand'),
					'title' => __('Brand'),
					'name' => 'option_id',
					'options' => $this->systemBrand->toOptionArray(),
				]
			);
		}

		$fieldset->addField('image', 'image',
			[
				'label' => __('Logo'),
				'title' => __('Logo'),
				'name' => 'image',
				'required' => true,
			]
		);

		$fieldset->addField('description', 'editor', [
			'name' => 'description',
			'label' => __('Description'),
			'title' => __('Description'),
			'config' => $this->wysiwygConfig->getConfig([
				'add_variables' => false,
				'add_widgets' => true,
				'add_directives' => true
			])
		]);

		if (!$this->_storeManager->isSingleStoreMode()) {
			$field = $fieldset->addField(
				'stores',
				'multiselect',
				[
					'name' => 'stores[]',
					'label' => __('Store View'),
					'title' => __('Store View'),
					'required' => true,
					'values' => $this->systemStore->getStoreValuesForForm(false, true)
				]
			);
			$renderer = $this->getLayout()->createBlock(
				'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
			);
			$field->setRenderer($renderer);
		} else {
			$fieldset->addField(
				'stores',
				'hidden',
				['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
			);
			$model->setStoreId($this->_storeManager->getStore(true)->getId());
		}

		$fieldset->addField('position', 'text',
			[
				'label' => __('Position'),
				'title' => __('Position'),
				'name' => 'position',
				'required' => true
			]
		);

		$fieldset->addField('status', 'select',
			[
				'label' => __('Status'),
				'title' => __('Status'),
				'name' => 'status',
				'options' => Status::getAvailableStatuses(),
			]
		);

		$form->addValues($model->getData());
		$this->setForm($form);

		return parent::_prepareForm();
	}

	/**
	 * @return mixed
	 */
	public function getBrand() {
		return $this->_coreRegistry->registry('brand');
	}

	/**
	 * @return \Magento\Framework\Phrase
	 */
	public function getPageTitle() {
		return $this->getBrand()->getId()
			? __("Edit Brand '%1'", $this->escapeHtml($this->getBrand()->getTitle())) : __('New Brand');
	}

	/**
	 * Prepare label for tab.
	 *
	 * @return string
	 */
	public function getTabLabel() {
		return __('General Information');
	}

	/**
	 * Prepare title for tab.
	 *
	 * @return string
	 */
	public function getTabTitle() {
		return $this->getTabLabel();
	}

	/**
	 * {@inheritdoc}
	 */
	public function canShowTab() {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isHidden() {
		return false;
	}
}
