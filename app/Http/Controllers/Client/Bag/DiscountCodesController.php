<?php

namespace App\Http\Controllers\Client\Bag;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\Client\Discounts\ValidateDiscountCodeRequest;

use App\Http\Controllers\ClientController;

use App\Models\Shop\Discounts\DiscountCode;

use Response;

class DiscountCodesController extends ClientController
{
    public function validateDiscountCode(ValidateDiscountCodeRequest $request)
    {
        $input = $request->all();
        $discount_code = DiscountCode::where('code', $input['discount_code'])->first();
        $discount_code->value = is_null($discount_code->value) ? 0 : $discount_code->value;

        return Response::json([
            'data'      => $discount_code->load('discountCodeType'),
            'message'   => ['Código de descuento válido'],
            'success'   => true
        ]);
    }


}
