<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Controllers\ClientController;

use App\User;
use App\Models\Users\BankAccount;

use App\Http\Requests\Users\BankAccounts\CreateBankAccountRequest;

use Response;
use Redirect;

class BankAccountController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBankAccountRequest $request,User $user)
    {
        $input = $request->all();
        $new_bankaccount = BankAccount::create([
            "user_id"       => $user->id,
            "bank"          => $input["bank"],
            "branch"        => $input["branch"],
            "name"          => $input["name"],
            "account_number" => $input["account_number"],
            "CLABE"         => $input["CLABE"],
        ]);

        if (!$new_bankaccount) {
            return Redirect::back()->withErrors(['La cuenta bancaria no pudo ser guardada']);
        }

        return Redirect::back()->with('status', 'Cuenta bancaria correctamente guardada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, BankAccount $bank_account)
    {

		if ($user->bank_accounts->count() <= 1) {
			return Redirect::back()->withErrors([trans('user.errors.bank_account_unique')]);
		}

        if (!$bank_account->delete()) {
            return Redirect::back()->withErrors([trans('user.errors.bank_account_delete')]);
        }

        return Redirect::route('user::home',$user->name)->with('status', trans('user.success.bank_account_delete'));
    }
}
