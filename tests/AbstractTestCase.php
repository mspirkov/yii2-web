<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests;

use PHPUnit\Framework\TestCase;
use yii\web\Application;
use yii\web\IdentityInterface;

abstract class AbstractTestCase extends TestCase
{
    /** @var Application<IdentityInterface> */
    protected Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var array<string, mixed> $config */
        $config = require __DIR__ . '/config.php';

        $this->application = new Application($config);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        restore_error_handler();
        restore_exception_handler();
    }
}
