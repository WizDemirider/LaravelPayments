<?php

namespace Ankitgupta\Payments;

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
        $this->app->make('Ankitgupta\Payments\PaymentsController');
        // $this->loadViewsFrom(__DIR__.'/views', 'pay');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'./routes.php';
    }
}
