<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ClientController;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Auth;

use App\Http\Helpers\Traits\Auth\RedirectPathTrait;

class ResetPasswordController extends ClientController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords,RedirectPathTrait {
        RedirectPathTrait::redirectPath insteadof ResetsPasswords;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        parent::__construct();
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
            "active"    => 1,
        ])->save();

        $this->guard()->login($user);
    }

}
