<?php

namespace robuust\fixtures\controllers;

use yii\console\controllers\MigrateController as BaseMigrateController;
use yii\helpers\Console;

/**
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2018, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 *
 * Migrate controller for fixtures.
 *
 * This class is essentially the same as its parent,
 * except for that it disables Craft's audit columns in the inserts.
 */
class MigrateController extends BaseMigrateController
{
    /**
     * {@inheritdoc}
     */
    protected function createMigrationHistoryTable()
    {
        $tableName = $this->db->schema->getRawTableName($this->migrationTable);
        $this->stdout("Creating migration history table \"$tableName\"...", Console::FG_YELLOW);
        $this->db->createCommand()->createTable($this->migrationTable, [
            'version' => 'varchar('.static::MAX_NAME_LENGTH.') NOT NULL PRIMARY KEY',
            'apply_time' => 'integer',
        ])->execute();
        $this->db->createCommand()->insert($this->migrationTable, [
            'version' => self::BASE_MIGRATION,
            'apply_time' => time(),
        ], false)->execute();
        $this->stdout("Done.\n", Console::FG_GREEN);
    }

    /**
     * {@inheritdoc}
     */
    protected function addMigrationHistory($version)
    {
        $command = $this->db->createCommand();
        $command->insert($this->migrationTable, [
            'version' => $version,
            'apply_time' => time(),
        ], false)->execute();
    }
}
