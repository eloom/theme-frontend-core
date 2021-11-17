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

namespace Eloom\ThemeFrontend\Block\Adminhtml\Config\Fieldset\Brand;

use Magento\Backend\Block\Template;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

class Hint extends Template implements RendererInterface {
	/**
	 * @var string
	 * @deprecated 100.1.0
	 */
	protected $_template = 'Eloom_ThemeFrontend::config/fieldset/brand/hint.phtml';
	
	/**
	 * @param AbstractElement $element
	 * @return string
	 */
	public function render(AbstractElement $element) {
		$html = '';
		
		if ($element->getComment()) {
			$html .= sprintf('<tr id="row_%s">', $element->getHtmlId());
			$html .= '<td colspan="1"><p class="note"><span>';
			$html .= sprintf(
				'<a href="%s" target="_blank">' . __('Documentation') . '</a>',
				$element->getComment()
			);
			$html .= '</span></p></td></tr>';
		}
		
		return $html;
	}
}
