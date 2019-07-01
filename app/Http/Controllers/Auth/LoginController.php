<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ClientController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Helpers\Traits\Auth\RedirectPathTrait;

use Auth;
use Redirect;

use App\Models\Shop\BagUser;

class LoginController extends ClientController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, RedirectPathTrait {
        RedirectPathTrait::redirectPath insteadof AuthenticatesUsers;        
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        parent::__construct();
    }

    /**
     * Modify the operation after login
     * @param  request $request
     * @param  User $user
     * @return Redirect
     */
    public function authenticated($request , $user)
    {

        if( !$user->isActive() ){
            Auth::logout();
            return Redirect::back()->withErrors([
                'active' => "te enviamos un correo para activar tu cuenta"
            ]);
        }

        foreach ($this->cookie_bags as $bag_key) {
            $bag_user = BagUser::where(["user_id"=> null])->with("bag")->whereHas("bag",function($q) use ($bag_key) {
                return $q->ByKey($bag_key)->Actives();
            })->first();
            if ($bag_user) {
                $bag_user->user_id = $user->id;
                $bag_user->save();
            }

        }

        return redirect()->intended(   $this->redirectPath() );

    }

}
