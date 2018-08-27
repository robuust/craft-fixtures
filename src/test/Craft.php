<?php

namespace robuust\fixtures\test;

use Codeception\Lib\Framework;
use Codeception\Module\Yii2;
use Codeception\TestInterface;

/**
 * Codeception Craft module.
 *
 * @SuppressWarnings(PHPMD)
 * phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
 */
class Craft extends Yii2
{
    /**
     * {@inheritdoc}
     */
    public function _before(TestInterface $test)
    {
        $this->recreateClient();
        $this->client->startApp();

        // load fixtures before db transaction
        if ($test instanceof \Codeception\Test\Cest) {
            $this->loadFixtures($test->getTestClass());
        } else {
            $this->loadFixtures($test);
        }

        $this->startTransactions();
    }

    /**
     * {@inheritdoc}
     */
    private function loadFixtures($test)
    {
        $this->debugSection('Fixtures', 'Loading fixtures');
        if (empty($this->loadedFixtures)
            && method_exists($test, $this->_getConfig('fixturesMethod'))
        ) {
            $this->haveFixtures(call_user_func([$test, $this->_getConfig('fixturesMethod')]));
        }
        $this->debugSection('Fixtures', 'Done');
    }

    /**
     * {@inheritdoc}
     */
    public function _after(TestInterface $test)
    {
        $_SESSION = [];
        $_FILES = [];
        $_GET = [];
        $_POST = [];
        $_COOKIE = [];
        $_REQUEST = [];

        $this->rollbackTransactions();

        if ($this->config['cleanup']) {
            foreach ($this->loadedFixtures as $fixture) {
                $fixture->unloadFixtures();
            }
            $this->loadedFixtures = [];
        }

        if ($this->client !== null && $this->client->getApplication()->has('session', true)) {
            $this->client->getApplication()->session->close();
        }

        $this->client->resetApplication();
        Framework::_after($test);
    }

    /**
     * {@inheritdoc}
     */
    public function haveFixtures($fixtures)
    {
        if (empty($fixtures)) {
            return;
        }
        $fixturesStore = new FixturesStore($fixtures);
        $fixturesStore->unloadFixtures();
        $fixturesStore->loadFixtures();
        $this->loadedFixtures[] = $fixturesStore;
    }
}
