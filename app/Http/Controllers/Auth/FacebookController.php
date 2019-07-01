<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Http\Helpers\Traits\Auth\RedirectPathTrait;

use Socialite;
use Exception;
use Redirect;

use Auth;

use App\User;
use App\Models\Shop\BagUser;


class FacebookController extends ClientController
{
    use RedirectPathTrait;
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
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->scopes([
            'email',
            'public_profile',
        ])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        try {
            $facebook_user = Socialite::driver('facebook')
            ->fields([
                'name',
                'first_name',
                'last_name',
                'email',
                'verified',
                "id"
            ])->user();
        } catch (Exception $e) {
            return Redirect::route("client::pages.index")->withErrors(["Servicio temporalmente no disponible"]);
        }

        if (!filter_var( $facebook_user->getEmail() , FILTER_VALIDATE_EMAIL)) {
            return Socialite::driver('facebook')->reRequest()->redirect();
        }

        $local_users = User::withTrashed()
			->where(["email" => $facebook_user->getEmail()])
			->orWhere(["facebook_id" => $facebook_user->getId()])
			->get();

        switch ($local_users->count()) {
            case 0:

                $data = [
                    "name"          => User::createUniqueUsername( $facebook_user->getName() , "" ),
                    "active"        => true,
                    'email'         => $facebook_user->getEmail(),
                    'first_name'    => isset($facebook_user->user["first_name"]) ? $facebook_user->user["first_name"] : "",
                    'last_name'     => isset($facebook_user->user["last_name"]) ? $facebook_user->user["last_name"] : "",
                    'password'      => User::setRandomPassword(),
                    'facebook_id'   => $facebook_user->getId(),
                ];

                $local_user = User::CltvoCreate($data);

                break;
            case 1:

                $local_user = $local_users->first();

                if ($local_user->facebook_id != $facebook_user->getId()) {
                    $local_user->facebook_id = $facebook_user->getId();
                    $local_user->save();
                }

                break;
            default:
                $local_user = $local_users->where("facebook_id" , $facebook_user->getId())->first();
                break;
        }


        if ($local_user) {
            foreach ($this->cookie_bags as $bag_key) {
                $bag_user = BagUser::where(["user_id"=> null])->with("bag")->whereHas("bag",function($q) use ($bag_key) {
                    return $q->ByKey($bag_key)->Actives();
                })->first();
                if ($bag_user) {
                    $bag_user->user_id = $local_user->id;
                    $bag_user->save();
                }
            }
        }

		if ($local_user->trashed()) {
			return Redirect::back()->withErrors([
                'active' => "La cuenta a sido desactivada"
            ]);;
		}
		if( !$local_user->isActive() ){
			return Redirect::back()->withErrors([
				'active' => "te enviamos un correo para activar tu cuenta"
			]);
		}

        Auth::login($local_user);
        return Redirect::to($this->redirectPath());
    }

}
