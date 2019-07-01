<div class="media-manager__manage-img-details" v-bind:class="{
        'media-manager__manage-img-details--image-is-selected': chosen_img.src !== ''
    }"> 
    <div class="row"><span class="media-manager__manage-img-details-close" @click="closeSidebar">cerrar</span></div>
    <div class="row">
        <div class="col-xs-5">
            <img v-bind:src="chosen_img.src">
        </div>

        <div class="col-xs-7">
            <span class="media-manager__text">@{{chosen_img.es_title}}</span>
            <span class="media-manager__text media-manager__text--info" v-if="chosen_img.created_at">Creada en: @{{chosen_img.created_at}}</span>
            {{-- <span class="media-manager__text media-manager__text--info">650 kB</span>
            <span class="media-manager__text media-manager__text--info">400 x 683</span> --}}

            {!! Form::open([
                'method'    => 'delete',
                'class'     => '',
                'route'    => ['admin::photos.ajax.destroy','&#123;&#123;chosen_img.id&#125;&#125;'],
                'role'                  => 'form',
                'id'                    => 'delete_photo_form',
                'v-on:submit.prevent'   => 'post'
                ]) !!}

                    {!! Form::submit("Borrar permanentemente", ['class' => 'media-manager__link']) !!}

            {!! Form::close() !!}

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="divisor"></div>
        </div>
    </div>

    {!! Form::open([
        'method'    => 'patch',
        'class'     => 'row',
        'route'    => ['admin::photos.ajax.update','&#123;&#123;chosen_img.id&#125;&#125;'],
        'role'                  => 'form',
        'id'                    => 'update_photo_form',
        'v-on:submit.prevent'   => 'post'
        ]) !!}

        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-5">
                    <span class="text">Título</span>
                </div>

                @foreach ($languages as $language)
                    <div class="col-xs-7 media-manager__col-form ">
                        {!! Form::text('title['.$language->iso6391.']', '', [
                            'class' => 'form-control input-sm input',
                            // 'required' => 'required',
                            'form'  => 'update_photo_form',
                            'v-model' => 'chosen_img.'.$language->iso6391.'_title',
                            'placeholder'   => $language->name
                        ]) !!}
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-xs-5">
                    <span class="text">Texto alternativo</span>
                </div>

                @foreach ($languages as $language)
                    <div class="col-xs-7 media-manager__col-form ">
                        {!! Form::text('alt['.$language->iso6391.']', '', [
                            'class' => 'form-control input-sm input',
                            'form'  => 'update_photo_form',
                            'v-model' => 'chosen_img.'.$language->iso6391.'_alt',
                            'placeholder'   => $language->name
                        ]) !!}
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-xs-5">
                    <span class="text">Descripción</span>
                </div>

                @foreach ($languages as $language)
                    <div class="col-xs-7 media-manager__col-form ">
                        {!! Form::textarea('description['.$language->iso6391.']', '', [
                            'class' => 'form-control input',
                            // 'required' => 'required',
                            'form'  => 'update_photo_form',
                            'rows' => '2',
                            'v-model'    =>  'chosen_img.'.$language->iso6391.'_description',
                            'placeholder'   => $language->name
                        ]) !!}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-xs-7" style="float:right;">
            {!! Form::submit('guardar', [
                'class' => 'btn btn-primary input-sm input input__submit',
                'form'  => 'update_photo_form'
                ]) !!}
        </div>


    {!! Form::close() !!}

    <div class="row">
        <div class="col-xs-12">
            <div class="divisor"></div>
        </div>
    </div>
    <div class="row">
        @include('admin.media_manager.partials._select-image-form')
    </div>

</div>
