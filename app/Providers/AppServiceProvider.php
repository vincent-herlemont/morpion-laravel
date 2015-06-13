<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Game\Morpion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

      $this->app->singleton('Morpion', function ($app) {
        return new Morpion();
      });
      if ($this->app->environment() == 'local') {
        $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
      }
    }
}
