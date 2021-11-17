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

namespace Eloom\ThemeFrontend\Block\Adminhtml\Brand;

use Eloom\ThemeFrontend\Model\ResourceModel\Brand\CollectionFactory;
use Eloom\ThemeFrontend\Model\Status;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;

class Grid extends Extended {

	/**
	 *
	 * @var CollectionFactory
	 */
	protected $brandCollectionFactory;


	/**
	 * construct.
	 *
	 * @param Context $context
	 * @param Data $backendHelper
	 * @param CollectionFactory $brandCollectionFactory
	 * @param array $data
	 */
	public function __construct(Context           $context,
	                            Data              $backendHelper,
	                            CollectionFactory $brandCollectionFactory,
	                            array             $data = []) {
		$this->brandCollectionFactory = $brandCollectionFactory;

		parent::__construct($context, $backendHelper, $data);
	}

	protected function _construct() {
		parent::_construct();
		$this->setId('brandGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}

	protected function _prepareCollection() {
		$store = $this->getRequest()->getParam('store');
		$collection = $this->brandCollectionFactory->create();
		if ($store) {
			$collection->addFieldToFilter('stores', array(array('finset' => 0), array('finset' => $store)));
		}
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	/**
	 * @return $this
	 */
	protected function _prepareColumns() {
		$this->addColumn(
			'title',
			[
				'header' => __('Title'),
				'type' => 'text',
				'index' => 'title',
				'header_css_class' => 'col-name',
				'column_css_class' => 'col-name',
			]
		);

		$this->addColumn(
			'urlkey',
			[
				'header' => __('URL key'),
				'type' => 'text',
				'index' => 'urlkey',
				'header_css_class' => 'col-name',
				'column_css_class' => 'col-name',
			]
		);

		$this->addColumn(
			'image',
			[
				'header' => __('Image'),
				'width' => '50px',
				'filter' => false,
				'renderer' => 'Eloom\ThemeFrontend\Block\Adminhtml\Helper\Renderer\Grid\Image',
			]
		);

		$this->addColumn(
			'position',
			[
				'header' => __('Position'),
				'type' => 'text',
				'index' => 'position',
				'header_css_class' => 'col-order',
				'column_css_class' => 'col-order',
			]
		);

		$this->addColumn(
			'status',
			[
				'header' => __('Status'),
				'index' => 'status',
				'type' => 'options',
				'options' => Status::getAvailableStatuses(),
			]
		);

		$this->addColumn(
			'edit',
			[
				'header' => __('Edit'),
				'type' => 'action',
				'getter' => 'getId',
				'actions' => [
					[
						'caption' => __('Edit'),
						'url' => ['base' => '*/*/edit'],
						'field' => 'entity_id',
					],
				],
				'filter' => false,
				'sortable' => false,
				'index' => 'stores',
				'header_css_class' => 'col-action',
				'column_css_class' => 'col-action',
			]
		);
		$this->addExportType('*/*/exportCsv', __('CSV'));
		$this->addExportType('*/*/exportXml', __('XML'));
		$this->addExportType('*/*/exportExcel', __('Excel'));

		return parent::_prepareColumns();
	}

	/**
	 * @return $this
	 */
	protected function _prepareMassaction() {
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('brand');

		$this->getMassactionBlock()->addItem(
			'delete',
			[
				'label' => __('Delete'),
				'url' => $this->getUrl('eloomtheme/*/massDelete'),
				'confirm' => __('Are you sure?'),
			]
		);

		$statuses = Status::getAvailableStatuses();

		array_unshift($statuses, ['label' => '', 'value' => '']);
		$this->getMassactionBlock()->addItem(
			'status',
			[
				'label' => __('Change status'),
				'url' => $this->getUrl('eloomtheme/*/massStatus', ['_current' => true]),
				'additional' => [
					'visibility' => [
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => __('Status'),
						'values' => $statuses,
					],
				],
			]
		);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGridUrl() {
		return $this->getUrl('*/*/grid', ['_current' => true]);
	}

	/**
	 * get row url
	 * @param object $row
	 * @return string
	 */
	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', ['entity_id' => $row->getId()]);
	}
}
