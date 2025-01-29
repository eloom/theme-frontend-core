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

namespace Eloom\ThemeFrontendCore\Model\System\Config\Brand;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

class Attribute implements ArrayInterface {

	/**
	 * @var CollectionFactory
	 */
	protected $collectionFactory;

	public function __construct(CollectionFactory $collectionFactory) {
		$this->collectionFactory = $collectionFactory;
	}

	public function toOptionArray() {
		$options = ['' => __('Choose brand attribute')];
		$collection = $this->collectionFactory->create()
			->addFieldToFilter('frontend_input', ['select', 'multiselect'])
			->addVisibleFilter();
		$collection->setOrder('frontend_label', 'ASC');
		foreach ($collection as $item) {
			$options[$item->getAttributeCode()] = $item->getFrontendLabel();
		}

		return $options;
	}

}
