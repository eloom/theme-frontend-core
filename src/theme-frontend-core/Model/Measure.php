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

namespace Eloom\ThemeFrontendCore\Model;

use Eloom\ThemeFrontendCore\Api\MeasureInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;

class Measure implements MeasureInterface {
	
	private $serializer;
	
	/**
	 * @var ProductFactory
	 */
	protected $productFactory;
	
	/**
	 * @var BlockRepositoryInterface
	 */
	private $blockRepository;
	
	public function __construct(Json $serializer = null,
	                            BlockRepositoryInterface $blockRepository,
	                            ProductFactory $productFactory) {
		$this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
		$this->blockRepository = $blockRepository;
		$this->productFactory = $productFactory;
	}
	
	/**
	 * @inheritDoc
	 */
	public function getContent($productId) {
		$data = null;
		try {
			$product = $this->productFactory->create()->load($productId);
			if (!$product || !$product->getMeasures()) {
				return '';
			}
			$block = $this->blockRepository->getById($product->getMeasures());
			$data = ['title' => $block->getTitle(), 'content' => $block->getContent()];
		} catch (NoSuchEntityException $e) {
		
		}
		
		return $this->serializer->serialize(['data' => $data]);
	}
}