<?php

namespace robuust\fixtures\base;

use Craft;
use craft\base\Element;
use craft\elements\Asset;
use craft\records\VolumeFolder;

/**
 * Fixture for Asset Model.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2019, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
abstract class AssetFixture extends ElementFixture
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = Asset::class;

    /**
     * @var array
     */
    protected $volumeIds = [];

    /**
     * @var array
     */
    protected $folderIds = [];

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        /** @var \craft\services\Volumes */
        $volumeService = Craft::$app->getVolumes();

        // Get all volume and folder id's
        $volumes = $volumeService->getAllVolumes();
        foreach ($volumes as $volume) {
            $this->volumeIds[$volume->handle] = $volume->id;
            $this->folderIds[$volume->handle] = VolumeFolder::findOne([
                'parentId' => null,
                'name' => $volume->name,
                'volumeId' => $volume->id,
            ])->id;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function isPrimaryKey(string $key): bool
    {
        return $key == 'volumeId' || $key == 'folderId' || $key == 'filename' || $key == 'title';
    }

    /**
     * {@inheritdoc}
     */
    public function getElement(array $data = null): ?Asset
    {
        $element = parent::getElement($data);

        if (is_null($data)) {
            $element->avoidFilenameConflicts = true;
            $element->setScenario(Asset::SCENARIO_REPLACE);
        }

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    protected function saveElement(Element $element): bool
    {
        try {
            return parent::saveElement($element);
        } catch (\PHPUnit\Framework\Exception $e) {
            break; // do nothing while testing
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function deleteElement(Element $element): void
    {
        try {
            parent::deleteElement($element);
        } catch (\PHPUnit\Framework\Exception $e) {
            break; // do nothing while testing
        }
    }
}
