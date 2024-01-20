<?php

namespace IGD\Trustpilot\Tests;

use IGD\Trustpilot\Providers\TrustpilotServiceProvider;
use IGD\Trustpilot\Trustpilot;
use Illuminate\Foundation\AliasLoader;
use Orchestra\Testbench\TestCase;


abstract class TestBase extends TestCase
{

    /**
     * Load service providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [TrustpilotServiceProvider::class];
    }


    /**
     * Prepare the environment and configuration.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app) {
        // Credentials used for testing purposers are saved into ".secrets" directory.
        $config = json_decode(file_get_contents(__DIR__ . '/.secrets/config.json'), true);
        $app['config']->set('trustpilot', $config);

        $loader = AliasLoader::getInstance();
        $loader->alias('Trustpilot', \IGD\Trustpilot\Facades\Trustpilot::class);
    }

    /**
     * Get instance.
     *
     * @return Trustpilot
     */
    protected function getInstance() : Trustpilot {
        return $this->app->make('trustpilot');
    }

}
