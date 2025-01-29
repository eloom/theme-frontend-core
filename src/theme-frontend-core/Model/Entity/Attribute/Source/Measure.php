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

namespace Eloom\ThemeFrontendCore\Model\Entity\Attribute\Source;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Measure extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource {
	
	/**
	 * @var BlockRepositoryInterface
	 */
	private $blockRepository;
	
	/**
	 * @var SearchCriteriaBuilder
	 */
	private $searchCriteriaBuilder;
	
	public function __construct(BlockRepositoryInterface $blockRepository,
	                            SearchCriteriaBuilder $searchCriteriaBuilder) {
		$this->blockRepository = $blockRepository;
		$this->searchCriteriaBuilder = $searchCriteriaBuilder;
	}
	
	/**
	 * Retrieve all options array
	 *
	 * @return array
	 */
	public function getAllOptions() {
		if ($this->_options === null) {
			$searchCriteria = $this->searchCriteriaBuilder->create();
			$items = $this->blockRepository->getList($searchCriteria)->getItems();
			
			$this->_options = [['value' => '', 'label' => __('--Please Select--')]];
			foreach ($items as $item) {
				$this->_options[] = ['value' => $item->getId(), 'label' => $item->getTitle()];
			}
		}
		
		return $this->_options;
	}
	
	/**
	 * Retrieve option array
	 *
	 * @return array
	 */
	public function getOptionArray() {
		$_options = [];
		foreach ($this->getAllOptions() as $option) {
			$_options[$option['value']] = $option['label'];
		}
		return $_options;
	}
	
	/**
	 * Get a text for option value
	 *
	 * @param string|int $value
	 * @return string|false
	 */
	public function getOptionText($value) {
		$options = $this->getAllOptions();
		foreach ($options as $option) {
			if ($option['value'] == $value) {
				return $option['label'];
			}
		}
		
		return false;
	}
}