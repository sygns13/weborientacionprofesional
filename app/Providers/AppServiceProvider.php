<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('pdf', function($attribute, $value, $parameters) {
            $allowed_mimes = [
                'application/pdf', // pdf
            ];
            return in_array($value->getMimeType(), $allowed_mimes);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function rules()
    {
        return [
            'pdf_file' => 'pdf',
        ];
    }
}
