<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('clienti.form','App\Http\Composers\ClientiFormComposer');
        view()->composer('clienti.index','App\Http\Composers\ClientiIndexComposer');
        view()->composer('fatture.create','App\Http\Composers\FattureFormComposer');
        view()->composer('fatture.form','App\Http\Composers\FattureFormComposer');
        view()->composer('fatture.index','App\Http\Composers\FattureIndexComposer');
        view()->composer('societa._ricerca_societa','App\Http\Composers\SocietaIndexComposer');
        view()->composer('clienti-fatturazioni.form','App\Http\Composers\SocietaFormComposer');
    }
}
