<?php

namespace robuust\fixtures\base;

use Craft;
use craft\commerce\elements\Product;

/**
 * Fixture for Product model.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2019, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
class ProductFixture extends ElementFixture
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = Product::class;

    /**
     * @var array
     */
    protected $productTypeIds = [];

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        /** @var \craft\commerce\Plugin */
        $commerce = Craft::$app->getPlugins()->getPlugin('commerce');
        /** @var \craft\commerce\services\ProductTypes */
        $productTypesService = $commerce->getProductTypes();

        // Get all product type id's
        $productTypes = $productTypesService->getAllProductTypes();
        foreach ($productTypes as $productType) {
            $this->productTypeIds[$productType->handle] = $productType->id;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function isPrimaryKey(string $key): bool
    {
        return $key == 'typeId' || $key == 'title';
    }
}
