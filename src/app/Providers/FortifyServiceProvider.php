<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
//use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;


class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);


        Fortify::registerView(function () {
        return view('auth.register');
        });
        Fortify::loginView(function () {
        return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
        $email = (string) $request->email;

        return Limit::perMinute(10)->by($email . $request->ip());
        });


        Fortify::authenticateUsing(function (Request $request) {

        if (Auth::attempt($request->only('email','password'))) {
            return Auth::user();
        }

        throw ValidationException::withMessages([
            'email' => 'ログイン情報が登録されていません',
        ]);
    });


    // TODO: 初回ログイン後プロフィール編集実装時に使用
    // Fortify::updateUserProfileInformationUsing(
        // UpdateUserProfileInformation::class
   // );

    }
}
