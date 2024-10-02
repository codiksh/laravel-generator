<?php

namespace Tests;

use Codiksh\Generator\CodikshGeneratorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            CodikshGeneratorServiceProvider::class,
        ];
    }
}
