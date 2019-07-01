<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\ClientController;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Helpers\Traits\Auth\RedirectPathTrait;

use App\Models\Shop\BagUser;

use Auth;

class RegisterController extends ClientController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers,RedirectPathTrait {
        RedirectPathTrait::redirectPath insteadof RegistersUsers;
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
        $this->middleware('guest');
        parent::__construct();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => 'required|max:255|unique:users',
            'first_name' => 'required|max:255|no_scripts',
            'last_name' => 'required|max:255|no_scripts',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $data["name"] = User::createUniqueUsername( $data['first_name'],$data['last_name'] );
        $data["active"] = true;

        $user = User::CltvoCreate($data);

        if ($user) {


            foreach ($this->cookie_bags as $bag_key) {
                $bag_user = BagUser::where(["user_id"=> null])->with("bag")->whereHas("bag",function($q) use ($bag_key) {
                    return $q->ByKey($bag_key)->Actives();
                })->first();
                if ($bag_user) {
                    $bag_user->user_id = $user->id;
                    $bag_user->save();
                }

            }
        }

        return $user;
    }

}
