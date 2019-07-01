<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;

use App\Notifications\Auth\ActivationAccountNotification;

use App\User;
use App\Role;

use Redirect;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //Regreso a la vista de index la informacion de los usuarios
        $data = [
            "users" => User::with("roles")->SuperAdminFilter($this->user)->get()
        ];
        return view('admin.users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            "rolesList"     => $this->user->rolesListToSelect(),
            "user_edit"     => new User
        ];

        return view('admin.users.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
    // creamos al usuario
        $input["name"]     = User::createUniqueUsername( $input['first_name'],$input['last_name'] );
        $input["password"] = User::setRandomPassword();
        $input['active']   = false;

        $newUser = User::CltvoCreate($input);

        $newUser->roles()->sync($input['roles']);

    //enviamos correo de activacion
        // $this->sendRegisterMail($newUser);
        $newUser->notify( new ActivationAccountNotification);

        return Redirect::route( 'admin::users.edit', [$newUser->id] )->with('status', trans('manage_users.success.create')); //Enviar el mensaje con el idioma que corresponde
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user_editable)
    {
        $data = [
            "rolesList"      => $this->user->rolesListToSelect(),
            "user_edit"      => $user_editable
        ];

        //Regreso a la vista de index la informacion de los usuarios
        return view('admin.users.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user_editable)
    {
        $input = $request->all();

    //Actualizo Solo los campos visibles
        $user_editable->first_name =$input['first_name'];
        $user_editable->last_name  =$input['last_name'];
        $user_editable->email      =$input['email'];

        if (!$user_editable->save()) {
            return Redirect::back()->withErrors(["El usuario no pudo ser gurdado correctamente"]); //Enviar el mensaje con el idioma que corresponde
        }

        if( $user_editable->id == $this->user->id   ){
            if( !( empty( array_diff( $this->user->roleLists(), $input['roles']) ) && empty( array_diff($input['roles'], $this->user->roleLists())  ) ) ){
                return Redirect::back()->withErrors(["No pudes modificar tus propios roles"]); //Enviar el mensaje con el idioma que corresponde
            }
        }else{
            $user_editable->roles()->sync($input['roles']);
        }

        return Redirect::route( 'admin::users.edit', [$user_editable->id] )->with('status', "Usuario correctamente actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $erasable_user)
    {

        if (!$erasable_user->delete()) {
            return Redirect::back()->withErrors(["El usuario no pudo ser desactivdo"]); //Enviar el mensaje con el idioma que corresponde
        }

        return Redirect::route('admin::users.trash')->with('status', "El usuario fue correctamente desactivado");
    }

    public function trash()
    {
        $data = [
            "users_disabled" => User::with("roles")->onlyTrashed()->SuperAdminFilter($this->user)->get()
        ];
        return view('admin.users.trash',$data);
    }

    public function recovery(User $user_trashed)
    {

        if (!$user_trashed->restore()) {
            return Redirect::back()->withErrors(["El usuario no pudo ser reactivado"]); //Enviar el mensaje con el idioma que corresponde
        }

        return Redirect::route('admin::users.index')->with('status', "El usuario fue correctamente reactivado");
    }
}
