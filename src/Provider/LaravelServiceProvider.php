<?php

namespace Andreacivita\Heimdal\Provider;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Andreacivita\Heimdal\Reporters\BugsnagReporter;
use Andreacivita\Heimdal\Reporters\RollbarReporter;
use Andreacivita\Heimdal\Reporters\SentryReporter;

class LaravelServiceProvider extends BaseProvider {

    public function register()
    {
        $this->loadConfig();
        $this->registerAssets();
        $this->bindReporters();
    }

    private function registerAssets()
    {
        $this->publishes([
            __DIR__.'/../config/andreacivita.heimdal.php' => config_path('andreacivita.heimdal.php')
        ]);
    }

    private function loadConfig()
    {
        if ($this->app['config']->get('andreacivita.heimdal') === null) {
            $this->app['config']->set('andreacivita.heimdal', require __DIR__.'/../config/andreacivita.heimdal.php');
        }
    }

    private function bindReporters()
    {
        $this->app->bind(BugsnagReporter::class, function ($app) {
            return function (array $config) {
                return new BugsnagReporter($config);
            };
        });

        $this->app->bind(SentryReporter::class, function ($app) {
            return function (array $config) {
                return new SentryReporter($config);
            };
        });

        $this->app->bind(RollbarReporter::class, function ($app) {
            return function (array $config) {
                return new RollbarReporter($config);
            };
        });
    }
}
