<?php namespace professionalweb\payment;

use Illuminate\Support\ServiceProvider;
use professionalweb\payment\contracts\PayService;
use professionalweb\payment\contracts\PaymentFacade;
use professionalweb\payment\interfaces\PaykeeperService;
use professionalweb\payment\drivers\paykeeper\PaykeeperDriver;

/**
 * Paykeeper payment provider
 * @package professionalweb\payment
 */
class PaykeeperProvider extends ServiceProvider
{

    public function boot(): void
    {
        app(PaymentFacade::class)->registerDriver(PaykeeperService::PAYMENT_PAYKEEPER, PaykeeperService::class, PaykeeperDriver::getOptions());
    }


    /**
     * Bind two classes
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PaykeeperService::class, function ($app) {
            return (new PaykeeperDriver(config('payment.paykeeper', [])));
        });
        $this->app->bind(PayService::class, function ($app) {
            return (new PaykeeperDriver(config('payment.paykeeper', [])));
        });
        $this->app->bind(PaykeeperDriver::class, function ($app) {
            return (new PaykeeperDriver(config('payment.paykeeper', [])));
        });
        $this->app->bind('\professionalweb\payment\Paykeeper', function ($app) {
            return (new PaykeeperDriver(config('payment.paykeeper', [])));
        });
    }
}