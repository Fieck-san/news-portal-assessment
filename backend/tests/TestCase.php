<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $this->forceTestingEnvironment();

        $app = require Application::inferBasePath().'/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    private function forceTestingEnvironment(): void
    {
        $values = [
            'APP_ENV' => 'testing',
            'APP_KEY' => 'base64:55dt34bqdlkB8wBPFokOcNLVjUgfnOhHuPUzFXOVc4s=',
            'CACHE_STORE' => 'array',
            'DB_CONNECTION' => 'sqlite',
            'DB_DATABASE' => ':memory:',
            'QUEUE_CONNECTION' => 'sync',
            'SESSION_DRIVER' => 'array',
        ];

        foreach ($values as $key => $value) {
            putenv($key.'='.$value);
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}
