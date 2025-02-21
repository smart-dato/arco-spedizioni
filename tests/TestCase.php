<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SmartDato\ArcoSpedizioni\ArcoSpedizioniServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ArcoSpedizioniServiceProvider::class,
        ];
    }
}
