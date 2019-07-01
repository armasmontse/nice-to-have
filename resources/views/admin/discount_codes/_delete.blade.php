{!! Form::open([
    'method'    => 'DELETE',
    'route'     => ['admin::discount_codes.destroy', $discount_code->id],
    'role'      => 'form',
]) !!}

    <div class="btn-group ">
        <button type="submit" class="icon">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
    </div>

{!!Form::close()!!}