<?php

namespace robuust\fixtures;

use yii\base\Event;
use yii\console\controllers\FixtureController;
use craft\events\ElementEvent;
use craft\services\Elements;
use robuust\fixtures\controllers\MigrateController;

/**
 * Fixtures Plugin.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2019, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * Register fixtures aliases.
     *
     * @var array
     */
    public $aliases = [
        '@fixtures' => '@root/fixtures',
    ];

    /**
     * Register fixtures controllers.
     *
     * @var array
     */
    public $controllerMap = [
        'fixture' => [
            'class' => FixtureController::class,
            'namespace' => 'fixtures',
            'globalFixtures' => [],
        ],
        'migrate' => [
            'class' => MigrateController::class,
            'migrationNamespaces' => ['fixtures\migrations'],
            'migrationTable' => '{{%fixture_migrations}}',
            'migrationPath' => null,
        ],
    ];

    /**
     * Register fixtures controller namespace.
     *
     * @var string
     */
    public $controllerNamespace = 'robuust\fixtures\controllers';

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
