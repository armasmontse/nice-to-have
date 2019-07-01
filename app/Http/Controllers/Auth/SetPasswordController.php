<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Http\Requests\Auth\SetPasswordRequest;
use App\Http\Helpers\Traits\Auth\RedirectPathTrait;

use App\User;

use Auth;

class SetPasswordController extends ClientController
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user_email)
    {
        return view("auth.passwords.set", ["encode_email"=> cltvoMailEncode($user_email->email)] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SetPasswordRequest $request, User $user_email)
    {
        $input = $request->all();

        $user_email->password = bcrypt( $input["password"] ) ;
        $user_email->active = true;

        if (!$user_email->save()) {
            return Redirect::back()->withErrors(['Tu cuenta no pudo ser activada']);
        }

        Auth::login($user_email);
        return redirect( $this->redirectPath() );
    }

}
