<?php

namespace App\Http\Requests\Users\Wishlist;

use App\Http\Requests\Request;

use App\User;

class AddToWishlistRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $input = $this->all();

        $rules = [
            "favorite_id"      => "required|exists:products,id|published:product|not_related_with:".$this->user->id,
        ];

        return $rules;
    }

    public function messages()
    {
        return [

            'favorite_id.required'          =>  'Es necesario que selecciones un producto',
            'favorite_id.exists'            =>  'Hay un error con el producto que seleccionaste',
            'favorite_id.published'         =>  'El producto seleccionado no está publicado.',
            'favorite_id.is_related_with'   =>  'Ya haz agregado este producto a tus favoritos.',

        ];
    }
}
