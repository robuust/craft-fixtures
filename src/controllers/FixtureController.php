<?php

namespace robuust\fixtures\controllers;

use yii\base\Event;
use yii\console\controllers\FixtureController as BaseFixtureController;
use craft\events\ElementEvent;
use craft\services\Elements;

/**
 * {@inheritdoc}
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2019, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
class FixtureController extends BaseFixtureController
{
    /**
     * Force hard deletes on Craft 3.1.
     */
    public function init()
    {
        parent::init();

        Event::on(Elements::class, Elements::EVENT_BEFORE_DELETE_ELEMENT, function (ElementEvent $event) {
            if (isset($event->hardDelete)) {
                $event->hardDelete = true;
            }
        });
    }
}
