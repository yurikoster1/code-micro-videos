<?php

namespace App\Providers;

use App\Filters\CastsFilter;
use App\Filters\PhoneFilter;
use Illuminate\Support\ServiceProvider;
use Waavi\Sanitizer\Laravel\Factory as Sanitizer;

class SanitizerServiceProvider extends ServiceProvider
{
    private $sanitizers = [
        'casts' => CastsFilter::class,
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->afterResolving(Sanitizer::class, function($s, $app) {
            foreach($this->sanitizers as $key => $value)
                $s->extend($key, $value);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
