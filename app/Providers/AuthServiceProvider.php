<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Insulin;
use App\Models\Product;
use App\Models\ProductLog;
use App\Policies\InsulinPolicy;
use App\Policies\ProductLogPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Insulin::class    => InsulinPolicy::class,
        Product::class    => ProductPolicy::class,
        ProductLog::class => ProductLogPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
