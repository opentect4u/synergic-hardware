<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('common.header', function ($view) {
            $user = Auth::user();
            $lastLogin = null;

            if ($user) {
                $lastLogin = DB::table('td_audit_trail')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->user_name)
                            ->orWhere('user_name', $user->user_name);
                    })
                    ->orderByDesc('login_dt')
                    ->value('login_dt');
            }

            $view->with('lastLogin', $lastLogin);
        });
    }
}
