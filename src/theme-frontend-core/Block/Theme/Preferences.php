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

namespace Eloom\ThemeFrontendCore\Block\Theme;

use Eloom\ThemeFrontendCore\Model\DefaultConfigProvider;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\JsonHexTag;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Preferences extends Template {
	
	/**
	 * @var DefaultConfigProvider
	 */
	protected $configProvider;
	
	/**
	 * @var SerializerInterface
	 */
	private $serializer;
	
	public function __construct(Context $context,
	                            DefaultConfigProvider $configProvider,
	                            SerializerInterface $serializerInterface = null,
	                            array $data = []) {
		$this->configProvider = $configProvider;
		$this->serializer = $serializerInterface ?: ObjectManager::getInstance()->get(JsonHexTag::class);
		
		parent::__construct($context, $data);
	}
	
	/**
	 * Retrieve configuration
	 *
	 * @return array
	 * @codeCoverageIgnore
	 */
	public function getConfig() {
		return $this->configProvider->getConfig();
	}
	
	/**
	 * Retrieve serialized config.
	 *
	 * @return bool|string
	 * @since 100.2.0
	 */
	public function getSerializedConfig() {
		return $this->serializer->serialize($this->getConfig());
	}
}