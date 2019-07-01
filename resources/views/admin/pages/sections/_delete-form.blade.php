{!! Form::open([
    'method'                => 'DELETE',
    'route'                 => ['admin::pages.sections.ajax.destroy','&#123;&#123;section.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'delete_section-&#123;&#123;section.id&#125;&#125;_form',
    'class'                 => '',
    'data-index'            => '&#123;&#123;$index&#125;&#125;',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <button type="submit" class="btn-delete btn-floating waves-effect waves-light deep-orange accent-2" form ="delete_section-&#123;&#123; section.id &#125;&#125;_form">
        <i class="fa fa-trash fa-lg text-center" aria-hidden="true"></i>
    </button>

{!!Form::close()!!}