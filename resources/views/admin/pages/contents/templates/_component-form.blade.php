<script type="x/templates" id="component-form-template">

    <div class="row row-mt">
        <div class="col-xs-12" v-if="section.editable_contents.gallery_img">
                <multi-images
                    :ref-path='[component.id, "gallery", index]'
                    :all-photos="component.gallery_images"
                    :photoable-id="component.id"
                    photoable-type="page_component"
                    default-order="null"
                    use='gallery'
                ></multi-images>
        </div>

        {!! Form::open([
            'method'                => "PATCH",
            'route'                 => ['admin::pages.sections.ajax.components.update','&#123;&#123;section.id&#125;&#125;','&#123;&#123;component.id&#125;&#125;'],
            'role'                  => 'form' ,
            'id'                    => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;',
            'v-on:submit.prevent'   => 'post',
            ]) !!}

            <div class="col-xs-4" v-if="section.editable_contents.thumbnail_img">

                <single-image
                    :ref-path='[component.id, "single-image", index]'
                    :current-image="component.thumbnail_image"
                    type="page_component"
                    :photoable-id="component.id"
                    photoable-type="page_component"
                    use="thumbnail"
                    class=""
                    default-order="null"
                ></single-image>

            </div>
            <div class="col-xs-8" v-bind:class="{s8: section.editable_contents.thumbnail_img, s12: !section.editable_contents.thumbnail_img  }">

                @foreach($languages as $language)
                    <div class="input-field" v-if="section.editable_contents.title">
                        {!! Form::label("title[".$language->iso6391."]", 'Título ('.$language->label.'):', ['class' => 'input-label active admin-label' ]) !!}
                        {!! Form::text("title[".$language->iso6391."]", null, [
                            'class'       => 'validate form-control input',
                            'placeholder' => "título (".$language->label.")",
                            // 'required'    => 'required',
                            'v-model'     => 'component.'.$language->iso6391.'_title',
                            'form'        => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;'
                        ]) !!}
                    </div>
                @endforeach

            </div>
            <div class="col-xs-12" >

                @foreach($languages as $language)
                    <div class="input-field" v-if="section.editable_contents.subtitle">
                        {!! Form::label("subtitle[".$language->iso6391."]", 'Subtítulo ('.$language->label.'):', ['class' => 'input-label active']) !!}
                        {!! Form::text("subtitle[".$language->iso6391."]", null, [
                            'class'       => 'validate form-control input',
                            'placeholder' => "subtítulo (".$language->label.")",
                            // 'required'    => 'required',
                            'v-model'     => 'component.'.$language->iso6391.'_subtitle',
                            'form'        => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;'
                        ]) !!}
                    </div>
                @endforeach

            </div>

            <div class="col-xs-12" v-if="section.editable_contents.excerpt">

                @foreach($languages as $language)
                    <div class="" v-if="section.editable_contents.excerpt">
                        {!! Form::label("excerpt[".$language->iso6391."]", 'Extracto ('.$language->label.'):', ['class' => 'input-label active']) !!}

                        <v-editor :content.sync='component.{{ $language->iso6391 }}_excerpt '></v-editor>
                        <input type="hidden" v-model="component.{{ $language->iso6391 }}_excerpt" name="excerpt[{{ $language->iso6391 }}]">
                    </div>
                @endforeach

            </div>

            <div class="col-xs-12 row-mt" v-if="section.editable_contents.content">

                @foreach($languages as $language)
                    <div class="" v-if="section.editable_contents.content">
                        {!! Form::label("content[".$language->iso6391."]", 'Contenido ('.$language->label.'):', ['class' => 'input-label active']) !!}

                        <v-editor :content.sync='component.{{ $language->iso6391 }}_content' class="row-mt"></v-editor>
                        <input type="hidden" v-model="component.{{ $language->iso6391 }}_content" name="content[{{ $language->iso6391 }}]">
                    </div>
                @endforeach

            </div>


            <div class="col-xs-12" v-if="section.editable_contents.iframe">

                @foreach($languages as $language)
                    <div class="input-field" v-if="section.editable_contents.iframe">
                        {!! Form::label("iframe[".$language->iso6391."]", 'iframe ('.$language->label.'):', ['class' => 'input-label active']) !!}
                        {!! Form::textarea("iframe[".$language->iso6391."]", null, [
                            'class'       => 'validate materialize-textarea',
                            'placeholder' => "iframe (".$language->label.")",
                            // 'required'    => 'required',
                            'v-model'     => 'component.'.$language->iso6391.'_iframe',
                            'form'        => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;'
                        ]) !!}
                    </div>
                @endforeach


            </div>

            <div class="" v-if="section.editable_contents.link" >

                @foreach($languages as $language)
                    <div class="input-field col-xs-8">
                        {!! Form::label("link_title[".$language->iso6391."]", 'Título de link ('.$language->label.'):', ['class' => 'input-label active']) !!}
                        {!! Form::text("link_title[".$language->iso6391."]", null, [
                            'class'       => 'validate',
                            'placeholder' => "Link (".$language->label.")",
                            // 'required'    => 'required',
                            'v-model'     => 'component.'.$language->iso6391.'_link_title',
                            'form'        => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;'
                        ]) !!}
                    </div>
                    <div class="col-xs-4">
                        <div class="pull-right">
                            <label for="{{ '&#123;&#123;"tblank_link_'.$language->iso6391.'"+component.id&#125;&#125;' }}">
                                Abrir en nueva ventana ({{$language->label}}) ?
                            </label>
                            <div class=" switch ">
                                No
                                <label>
                                    {!! Form::checkbox("link_tblank[".$language->iso6391."]", true , null, [
                                        'class'     => 'input__checkbox',
                                        'form'      => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;',
                                        'id'        => '&#123;&#123;"tblank_link_'.$language->iso6391.'"+component.id&#125;&#125;',
                                        'v-model'   => 'component.'.$language->iso6391.'_link_tblank',
                                    ]) !!}
                                    <span class="lever"></span>
                                </label>
                                Sí
                            </div>
                        </div>
                    </div>
                    <div class="input-field col-xs-12">
                        {!! Form::label("link_url[".$language->iso6391."]", 'Link ('.$language->label.'):', ['class' => 'input-label active']) !!}
                        {!! Form::url("link_url[".$language->iso6391."]", null, [
                            'class'       => 'validate',
                            'placeholder' => "Link (".$language->label.")",
                            // 'required'    => 'required',
                            'v-model'     => 'component.'.$language->iso6391.'_link_url',
                            'form'        => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;'
                        ]) !!}
                    </div>
                @endforeach

            </div>

            <div class="col-xs-12 row-mt">
                <div class=" pull-right">
                    <input type="hidden" name="index" :form='"update_component_"+component.id+"_form"' v-model="componentName">
                    {!! Form::submit("Guardar", [
                        'class' => 'btn btn-info button',
                        'form'  => '&#123;&#123;"update_component_"+component.id+"_form"&#125;&#125;'
                    ]) !!}
                </div>
                <br><br>
            </div>


            </div>
        {!! Form::close() !!}

    </div>
</script>
