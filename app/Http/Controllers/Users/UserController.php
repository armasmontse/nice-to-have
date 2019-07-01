<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Http\Requests\Users\UpdateEmailRequest;
use App\Http\Requests\Users\UpdatePasswordRequest;

use App\Notifications\Users\UpdatePasswordNotification;
use App\Notifications\Users\UpdateMailNotification;

use App\User;

use App\Models\Users\Card;

use Redirect;

use Response;

class UserController extends ClientController
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show');
    }


    public function updateEmail(UpdateEmailRequest $request, User $user)
    {
        $input = $request->all();

        $clone = clone $user;

        $user->email = $input["email"];

        if (!$user->save()) {
            return Redirect::back()->withErrors([trans('user.errors.email_update')]);
        }

        $clone->notify( new UpdateMailNotification);
		$user->notify( new UpdateMailNotification);

        return Redirect::route('user::home',$user->name)->with('status', trans('user.success.email_update'));
    }


    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        $input = $request->all();

        $user->password = bcrypt( $input["password"] ) ;

        if (!$user->save()) {
            return Redirect::back()->withErrors([trans('user.errors.password_update')]);
        }

        $user->notify( new UpdatePasswordNotification);

        return Redirect::route('user::home',$user->name)->with('status', trans('user.success.password_update'));
    }



    public function deleteCard(User $user,Card $card)
    {
        if (!$card->delete()) {
            return Redirect::back()->withErrors([trans('user.errors.card_delete')]);
        }

        return Redirect::route('user::home', $user->name)->with('status', trans('user.success.card_delete'));
    }

}
