{!! Form::open([
    'method'                => 'DELETE',
    'route'                 => ['admin::categories.ajax.destroy','&#123;&#123;category.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'delete_category-&#123;&#123;category.id&#125;&#125;_form',
    'class'                 => '',
    'data-index'                 => '&#123;&#123;$index&#125;&#125;',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="btn-group ">
        <button type="submit" class="icon" form ="delete_category-&#123;&#123; category.id &#125;&#125;_form">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
    </div>

{!!Form::close()!!}
