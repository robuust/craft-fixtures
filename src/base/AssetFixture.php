<?php

namespace robuust\fixtures\base;

use Craft;
use craft\elements\Asset;

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
     * {@inheritdoc}
     */
    public function load(): void
    {
        $this->data = [];
        foreach ($this->getData() as $alias => $data) {
            $element = $this->getElement();

            foreach ($data as $handle => $value) {
                $element->$handle = $value;
            }

            try {
                $result = Craft::$app->getElements()->saveElement($element);
            } catch (\PHPUnit\Framework\Exception $e) {
                break; // do nothing while testing
            }

            if (!$result) {
                throw new ErrorException(join(' ', $element->getErrorSummary(true)));
            }

            $this->data[$alias] = array_merge($data, ['id' => $element->id]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function unload(): void
    {
        foreach ($this->getData() as $data) {
            $element = $this->getElement($data);

            if ($element) {
                try {
                    Craft::$app->getElements()->deleteElement($element);
                } catch (\PHPUnit\Framework\Exception $e) {
                    break; // do nothing while testing
                }
            }
        }

        $this->data = [];
    }

    /**
     * {@inheritdoc}
     */
    protected function isPrimaryKey(string $key): bool
    {
        return $key == 'volumeId' || $key == 'folderId' || $key == 'filename' || $key == 'title';
    }

    /**
     * Get asset model.
     *
     * @param array $data
     *
     * @return Asset
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
}
