<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
        Payment::class => PaymentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-users', function($user){   
            return $user->hasRole('admin');     //to pass the gate, u need to have a role of admin. and we call he function in the user model.
        });

        Gate::define('seller-users', function($user){   
            return $user->hasRole('seller');     //to pass the gate, u need to have a role of seller. and we call he function in the user model.
        });

        Gate::define('buyer-users', function($user){   
            return $user->hasRole('buyer');     //to pass the gate, u need to have a role of buyer. and we call he function in the user model.
        });

        Gate::define('buyer-admin-users', function($user){   
            return $user->hasAnyRoles(['admin','buyer']);     //to pass the gate, u need to have a role of admin or a buyer. and we call he function in the user model.
        });

    }
}
