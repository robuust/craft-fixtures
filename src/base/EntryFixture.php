<?php

namespace robuust\fixtures\base;

use Craft;
use craft\elements\Entry;

/**
 * Fixture for Entry Model
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2018, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
abstract class EntryFixture extends ElementFixture
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = Entry::class;

    /**
     * @var array
     */
    protected $sectionIds = [];

    /**
     * @var array
     */
    protected $typeIds = [];

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        /** @var \craft\services\Section */
        $sectionService = Craft::$app->getSections();

        // Get all section and type id's
        $sections = $sectionService->getAllSections();
        foreach ($sections as $section) {
            $this->sectionIds[$section->handle] = $section->id;

            $this->typeIds[$section->handle] = [];
            $types = $sectionService->getEntryTypesBySectionId($section->id);
            foreach ($types as $type) {
                $this->typeIds[$section->handle][$type->handle] = $type->id;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function isPrimaryKey(string $key): bool
    {
        return $key == 'sectionId' || $key == 'typeId' || $key == 'title';
    }
}
