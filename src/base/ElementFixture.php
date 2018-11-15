<?php

namespace robuust\fixtures\base;

use Craft;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\test\ActiveFixture;
use craft\base\Element;

/**
 * Fixture for Element Model.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2018, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
abstract class ElementFixture extends ActiveFixture
{
    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        if (!($this->getElement() instanceof Element)) {
            throw new InvalidConfigException('"modelClass" must be an Element');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getModel($name)
    {
        if (!isset($this->data[$name])) {
            return null;
        }
        if (array_key_exists($name, $this->_models)) {
            return $this->_models[$name];
        }

        return $this->_models[$name] = $this->getElement($this->data[$name]);
    }

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
        foreach ($this->getData() as $data) {
            $element = $this->getElement($data);

            if ($element) {
                $this->deleteElement($element);
            }
        }

        $this->data = [];
    }

    /**
     * See if an element's handle is a primary key.
     *
     * @param string $key
     *
     * @return bool
     */
    abstract protected function isPrimaryKey(string $key): bool;

    /**
     * Get element model.
     *
     * @param array|null $data The data to get the element by
     *
     * @return Element
     */
    public function getElement(array $data = null)
    {
        $modelClass = $this->modelClass;

        if (is_null($data)) {
            return new $modelClass();
        }

        $query = $modelClass::find();

        foreach ($data as $key => $value) {
            if ($this->isPrimaryKey($key)) {
                $query = $query->$key(addcslashes($value, ','));
            }
        }

        return $query->one();
    }

    /**
     * Save element.
     *
     * @param Element $element
     *
     * @return bool
     */
    protected function saveElement(Element $element): bool
    {
        return Craft::$app->getElements()->saveElement($element);
    }

    /**
     * Delete element.
     *
     * @param Element $element
     */
    protected function deleteElement(Element $element): void
    {
        Craft::$app->getElements()->deleteElement($element);
    }
}
