<?php

namespace robuust\fixtures;

use yii\console\controllers\FixtureController;
use robuust\fixtures\controllers\MigrateController;

/**
 * Fixtures Plugin.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2018, Robuust
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
}
