<?php

namespace Qihucms\Payment;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Pay::class, function () {
            return new Pay();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'payment');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'payment');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/payment'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/payment'),
        ], 'lang');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/payment'),
        ], 'public');
    }
}
