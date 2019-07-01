<div class="row seoBooster">
    <div class="col-xs-10">

        <div class="row seoBooster__ttl-container">
            <h1 class="text__p text__p--ttl">seo booster</h1>
            <div class="seo-divisor"></div>
        </div>

        <div class="row">
            <div class="col-xs-8">
                <div class="row form-group">
                    {!! Form::label('inputname', 'Meta title (español):', ['class' => 'col-xs-3 control-label text-right text__p pl0']) !!}
                    <div class="col-xs-7">
                        {!! Form::text('inputname', null, [
                            'class'            => 'form-control input-sm input',
                            'aria-describedby' => 'helpBlock',
                            'required'         => 'required'
                        ]) !!}
                        <span id="helpBlock" class="help-block text__p text__p--seo">
                            Nombre de página. Deje un espacio para usar el nombre del producto. Máximo 70 caracteres, 62 sobrantes.
                        </span>
                    </div>
                </div>

                <div class="row form-group ">
                    {!! Form::label('inputname', 'Meta title (inglés):', ['class' => 'col-xs-3 control-label text-right text__p']) !!}
                    <div class="col-xs-7">
                        {!! Form::text('inputname', null, [
                            'class'            => 'form-control input-sm input',
                            'aria-describedby' => 'helpBlock',
                            'required'         => 'required'
                        ]) !!}
                        <span id="helpBlock" class="help-block text__p text__p--seo">
                            Nombre de página. Deje un espacio para usar el nombre del producto. Máximo 70 caracteres, 62 sobrantes.
                        </span>
                    </div>
                </div>

                <div class="row form-group ">
                    {!! Form::label('inputname', 'Meta description (español):', ['class' => 'col-xs-3 control-label text-right text__p']) !!}
                    <div class="col-xs-7">
                        {!! Form::textarea('inputname', null, [
                            'class'            => 'form-control input-sm input',
                            'aria-describedby' => 'helpBlock',
                            'rows'     => '2',
                            'required'         => 'required'
                        ]) !!}
                        <span id="helpBlock" class="help-block text__p text__p--seo">
                            Una oración para la cabeza del HTML. Máximo 159 caracteres, 62 sobrantes.
                        </span>
                    </div>
                </div>

                <div class="row form-group ">
                    {!! Form::label('inputname', 'Meta description (español):', ['class' => 'col-xs-3 control-label text-right text__p']) !!}
                    <div class="col-xs-7">
                        {!! Form::textarea('inputname', null, [
                            'class'            => 'form-control input-sm input',
                            'aria-describedby' => 'helpBlock',
                            'rows'     => '2',
                            'required'         => 'required'
                        ]) !!}
                        <span id="helpBlock" class="help-block text__p text__p--seo">
                            Una oración para la cabeza del HTML. Máximo 159 caracteres, 62 sobrantes.
                        </span>
                    </div>
                </div>
            </div>{{-- col --}}

            @include('admin.modules.inputs.image', [
                'type' => 'seo',
                'class' => 'camera-white',
                'image_name' => 'image-stock-1.jpg',
                'text' => 'Cambiar',
            ])
        </div> {{-- row --}}

        <div class="row seoBooster__row-btn">
            <div class="col-xs-1 col-xs-offset-2">
                {!! Form::submit('salvar', ['class' => 'btn btn-primary button input-sm']) !!}
            </div>
        </div>

        @include('admin.modules.general._googleSearchResults') {{-- código fuente: snappy snippet --}}

    </div>{{-- col --}}
</div>{{-- row --}}
