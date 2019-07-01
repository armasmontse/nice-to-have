<?php

namespace App\Http\Controllers\Admin\Discounts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Shop\Discounts\DiscountCode;
use App\Models\Shop\Discounts\DiscountCodeType;

use App\Http\Requests\Admin\Discounts\CreateDiscountCodeRequest;
use App\Http\Requests\Admin\Discounts\UpdateDiscountCodeRequest;

use Redirect;

class ManageDiscountCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'discount_codes' => DiscountCode::orderBy('initial_date', 'desc')->get()
        ];

        return view('admin.discount_codes.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'discount_codes_types'  => DiscountCodeType::get()->pluck('label', 'id'),
            'discount_code'         => new DiscountCode
        ];

        return view('admin.discount_codes.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDiscountCodeRequest $request)
    {
        $input = $request->all();

        // Quitar posibles espacios en blanco
        $input['code'] = trim($input['code']);

        while (true)
        {
            $discount_code = $input['code'];

            // Generar clave aleatoria
            for ($i = strlen($discount_code); $i < 15; $i++)
            {
                $discount_code = $discount_code . chr(rand(ord('a'), ord('z')));
            }

            // Buscar posible clave repetida
            if (DiscountCode::where(['code' => $discount_code])->count() == 0)
            {
                break;
            }
        }

        $discount_code = DiscountCode::create([
            'code'                  => $discount_code,
            'description'           => $input['description'],
            'initial_date'          => $input['initial_date'],
            'end_date'              => $input['end_date'],
            'value'                 => $input['type'] == 2 ? null : $input['value'],
            'unique'                => isset($input['unique']),
            'discount_code_type_id' => $input['type']
        ]);

        if (!$discount_code)
        {
            return Redirect::back()->withErrors(['El código de descuento no pudo ser creado']);
        }

        return Redirect::route('admin::discount_codes.edit', $discount_code->id)->with('status', 'El código de descuento fue creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountCode $discount_code)
    {
        $data = [
            'discount_code'         => $discount_code,
            'discount_codes_types'  => DiscountCodeType::get()->pluck('label', 'id')
        ];

        return view('admin.discount_codes.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscountCodeRequest $request, DiscountCode $discount_code)
    {
        $input = $request->all();

        $discount_code->initial_date            = $input['initial_date'];
        $discount_code->end_date                = $input['end_date'];

        if (!$discount_code->save())
        {
            return Redirect::back()->withErrors(['El código de descuento no pudo ser actualizado']);
        }

        return Redirect::back()->with('status', 'El código de descuento fue correctamente actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountCode $erasable_discount_code)
    {
        if (!$erasable_discount_code->delete())
        {
            return Redirect::back()->withErrors(['El código de descuento no pudo ser eliminado']);
        }

        return Redirect::route('admin::discount_codes.trash')->with('status', 'El código de descuento fue correctamente eliminado');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $data = [
            'discount_codes_disabled' => DiscountCode::onlyTrashed()->get()
        ];

        return view('admin.discount_codes.trash', $data);
    }

    /**
     * Recover a trashed resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function recovery(DiscountCode $discount_code_trashed)
    {
        if (!$discount_code_trashed->restore())
        {
            return Redirect::back()->withErrors(['El código de descuento no pudo ser recuperado']);
        }

        return Redirect::route('admin::discount_codes.index')->with('status', 'El código de descuento fue correctamente recuperado');
    }
}
