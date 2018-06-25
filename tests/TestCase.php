<?php

namespace Railroad\Response\Tests;

use Faker\Generator;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Railroad\Response\Providers\ResponseServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * @var Generator
     */
    protected $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->faker = $this->app->make(Generator::class);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app->register(ResponseServiceProvider::class);
    }
}