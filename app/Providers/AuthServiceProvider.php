<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enums\UserGate;
use App\Models\Annee;
use App\Models\User;
use App\Policies\AnneePolicy;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
       // Annee::class => AnneePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        foreach (UserGate::cases() as $gate) {
            Gate::define($gate->name, function (User $user) use ($gate) {
                return $user->hasAnyRole($gate->roles());
            });
        }
    }
}
