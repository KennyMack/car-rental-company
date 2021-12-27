<?php

namespace App\Providers;

use App\FormFields\DateTimeFormField;
use App\FormFields\NumericFormField;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\PaymentObserver;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Voyager::addFormField(NumericFormField::class);
        Voyager::addFormField(DateTimeFormField::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
