<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TimezoneServiceProvider extends ServiceProvider
{
    public function register()
    {
        date_default_timezone_set('Africa/Addis_Ababa');
    }

    public function boot()
    {
        //
    }
}
