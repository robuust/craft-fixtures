<?php

namespace robuust\fixtures\base;

use Craft;
use craft\elements\Tag;

/**
 * Fixture for Tag Model.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2018, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
abstract class TagFixture extends ElementFixture
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = Tag::class;

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
        $tagsService = Craft::$app->getTags();

        // Get all group id's
        $groups = $tagsService->getAllTagGroups();
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
