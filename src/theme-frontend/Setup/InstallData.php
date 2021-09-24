<?php
/**
* 
* Temas para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Theme
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\ThemeFrontend\Setup;

use Magento\Catalog\Model\Product\Attribute\Frontend\Image as ImageFrontendModel;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface {

	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory) {
		$this->eavSetupFactory = $eavSetupFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

		if (!$eavSetup->getAttributeId(\Magento\Catalog\Model\Product::ENTITY, 'hover_image')) {
			$eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'hover_image', [
				'type' => 'varchar',
				'label' => 'Hover Image',
				'input' => 'media_image',
				'frontend' => ImageFrontendModel::class,
				'required' => false,
				'sort_order' => 5,
				'global' => ScopedAttributeInterface::SCOPE_STORE,
				'used_in_product_listing' => true,
				'group' => 'Images'
			]);

			$entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
			$attributeSetIds = $eavSetup->getAllAttributeSetIds($entityTypeId);
			foreach ($attributeSetIds as $attributeSetId) {
				$groupId = $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, "image-management");
				$eavSetup->addAttributeToGroup(
					$entityTypeId,
					$attributeSetId,
					$groupId,
					'hover_image'
				);
			}

			$setup->endSetup();
		}
		
		if (!$eavSetup->getAttributeId(\Magento\Catalog\Model\Product::ENTITY, 'measures')) {
			$eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'measures', [
				'type' => 'varchar',
				'label' => 'Measurement Guide',
				'input' => 'select',
				'frontend' => '',
				'source' => \Eloom\ThemeFrontend\Model\Entity\Attribute\Source\Measure::class,
				'required' => false,
				'global' => ScopedAttributeInterface::SCOPE_STORE,
				'group' => 'Measures',
				'apply_to' => 'simple,bundle,grouped,configurable',
				'sort_order' => 1
			]);
			
			$setup->endSetup();
		}
	}
}
