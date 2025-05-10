<?php

namespace App\Providers;

use App\Models\Staff;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        $staff = Staff::firstOrCreate([
//            'first_name' => 'Dan',
//            'last_name' => 'Scott',
//            'email' => 'dan@test.com'
//        ], ['email']);
//
//        dd($staff);

        Vite::prefetch(concurrency: 3);
    }
}
