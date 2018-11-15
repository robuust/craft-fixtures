<?php

namespace robuust\fixtures\base;

use yii\base\ErrorException;
use craft\elements\GlobalSet;

/**
 * Fixture for GlobalSet Model.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2018, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
abstract class GlobalSetFixture extends ElementFixture
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = GlobalSet::class;

    /**
     * {@inheritdoc}
     */
    public function load(): void
    {
        $this->data = [];
        foreach ($this->getData() as $alias => $data) {
            // Pass in $data so we get an existing element
            $element = $this->getElement($data);

            foreach ($data as $handle => $value) {
                $element->$handle = $value;
            }

            if (!$this->saveElement($element)) {
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
        // Do not unload globals
    }

    /**
     * {@inheritdoc}
     */
    protected function isPrimaryKey(string $key): bool
    {
        return $key == 'handle';
    }
}
