<?php

namespace robuust\fixtures\test;

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
}
