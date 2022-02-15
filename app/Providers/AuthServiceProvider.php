<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\CamionPolicy;
use App\Policies\ChauffeurPolicy;
use Illuminate\Auth\Access\Gate as AccessGate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
            App\Models\User::class => UserPolicy::class,
            App\Models\Camion::class => CamionPolicy::class,
            App\Models\Chauffeur::class => ChauffeurPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Verifier si l'utilisateur peut acceder au dashboard ou non... En fonction du type
        Gate::define('acceder-dashboard', function(User $user) {
            $typeUtilisateurs = $user->getTypeUtilisateurs();

            if ($user->type !== null AND in_array($user->type, $typeUtilisateurs)) return true;
            else return false;
        });
    }
}
