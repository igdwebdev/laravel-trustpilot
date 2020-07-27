<?php
namespace IGD\Trustpilot\Providers;

use Illuminate\Support\ServiceProvider;

class TrustpilotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('trustpilot.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'trustpilot');

        // Register the classes to use with the facade
        $this->app->bind('trustpilot', 'IGD\Trustpilot\Trustpilot');
    }
}
