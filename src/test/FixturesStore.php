<?php

namespace robuust\fixtures\test;

use yii\base\Event;
use craft\events\ElementEvent;
use craft\services\Elements;
use Codeception\Lib\Connector\Yii2\FixturesStore as BaseFixturesStore;

/**
 * Extend FixturesStore to disable global fixtures.
 */
class FixturesStore extends BaseFixturesStore
{
    /**
     * {@inheritdoc}
     */
    public function globalFixtures()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function unloadFixtures($fixtures = null)
    {
        Event::on(Elements::class, Elements::EVENT_BEFORE_DELETE_ELEMENT, function (ElementEvent $event) {
            if (isset($event->hardDelete)) {
                $event->hardDelete = true;
            }
        });

        parent::unloadFixtures($fixtures);
    }
}
