<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\Request;

use App\Models\Shop\Bag;

class ShowPresentsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $present_bag = $this->route()->parameters()['present_bag'];

        if (!$this->user || $this->user != $present_bag->bagUser->user) {
            $rules['token'] = 'required|is_bag_friend_email:'.$present_bag->key;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'token.required'            =>  'Ingresa un correo eletrónico para poder ver una bolsa de regalos.',
            'token.is_bag_friend_email' =>  'Whoops! Lo sentimos, los regalos de esta bolsa son para otra persona.',
        ];
    }

    public function response(array $errors)
    {
        // Optionally, send a custom response on authorize failure
        // (default is to just redirect to initial page with errors)
        //
        // Can return a response, a view, a redirect, or whatever else

        if ($this->ajax() || $this->wantsJson()) {
            return response('Unauthorized.', 401);
        }

        $present_bag = $this->route()->parameters()['present_bag'];

        return $this->redirector->to(route('client::presents.index', ['present_bag' => $present_bag->key]))
             ->withInput($this->except($this->dontFlash))
             ->withErrors($errors, $this->errorBag);
    }
}
