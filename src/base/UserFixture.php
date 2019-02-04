<?php

namespace robuust\fixtures\base;

use craft\elements\User;

/**
 * Fixture for User Model.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2019, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
abstract class UserFixture extends ElementFixture
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = User::class;

    /**
     * {@inheritdoc}
     */
    protected function isPrimaryKey(string $key): bool
    {
        return $key == 'username';
    }
}
