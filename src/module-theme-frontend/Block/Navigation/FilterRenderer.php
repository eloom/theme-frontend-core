<?php
/**
* 
* Temas para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2021 Ã©lOOm (https://www.eloom.com.br)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontend\Block\Navigation;

use Magento\Catalog\Model\Layer\Filter\FilterInterface;
use Magento\CatalogSearch\Model\Layer\Filter\Price;

class FilterRenderer extends \Magento\LayeredNavigation\Block\Navigation\FilterRenderer {

	public function render(FilterInterface $filter) {
		$this->assign('filterItems', $filter->getItems());
		$this->assign('filter', $filter);
		$html = $this->_toHtml();
		$this->assign('filterItems', []);
		
		return $html;
	}

	public function getPriceRange($filter) {
		$filterPrice = array('min' => 0, 'max' => 0);
		if ($filter instanceof Price) {
			$price = $filter->getResource()->loadPrices(10000000000);
			$filterPrice['min'] = reset($price);
			$filterPrice['max'] = end($price);
		}
		
		return $filterPrice;
	}

	public function getFilterUrl($filter) {
		return $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true, '_query' => ['price' => '']]);
	}
}
