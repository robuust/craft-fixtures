<?php

namespace robuust\fixtures\base;

use Craft;
use craft\elements\Category;

/**
 * Fixture for Category Model.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2018, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
abstract class CategoryFixture extends ElementFixture
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = Category::class;

    /**
     * @var array
     */
    protected $groupIds = [];

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        /** @var \craft\services\Categories */
        $categoriesService = Craft::$app->getCategories();

        // Get all group id's
        $groups = $categoriesService->getAllGroups();
        foreach ($groups as $group) {
            $this->groupIds[$group->handle] = $group->id;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function isPrimaryKey(string $key): bool
    {
        return $key == 'groupId' || $key == 'title';
    }
}
