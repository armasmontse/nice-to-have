{!! Form::open([
    'method'                => 'DELETE',
    'route'                 => ['admin::subtypes.ajax.destroy','&#123;&#123;subtype.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'delete_subtype-&#123;&#123;subtype.id&#125;&#125;_form',
    'class'                 => '',
    'data-index'            => '&#123;&#123;$index&#125;&#125;',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="btn-group ">
        <button type="submit" class="icon" form ="delete_subtype-&#123;&#123; subtype.id &#125;&#125;_form" data-index="$index">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
    </div>

{!!Form::close()!!}
