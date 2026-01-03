<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Hexadog\ThemesManager\Facades\ThemesManager;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect()->route('admin.login');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ThemesManager::set(config('Theme.select_admin_theme', 'admin/zenix'));
        
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('admin.auth.login');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('admin.auth.two-factor-challenge');
        });

        Fortify::registerView(function () {
            return view('admin.auth.register');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('admin.auth.reset-password', ['request' => $request]);
        });

        Fortify::confirmPasswordView(function () {
            return view('admin.auth.confirm-password');
        });

        Fortify::verifyEmailView(function () {
            return view('admin.auth.verify-email');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('admin.auth.forgot-password');
        });
    }
}
