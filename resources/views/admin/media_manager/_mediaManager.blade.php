<div id="media-manager_crud">
    <media-manager v-ref:media_manager></media-manager>
    <script type="x/templates" id="media-manager-template">
        <div id="media-manager" class="modal media-manager__manage-img fade undraggable-unselectable-cascading" tabindex="-1" role="dialog" aria-labelledby="labelDetails" aria-hidden="true">
            <div id="media-manager__drop-container" class="media-manager__drop-container" v-on:click.self="close">
                <div id="media-manager__droppable-area" class="media-manager__droppable-area">
                    <div class="media-manager__icon-photo-container">
                        <span class="fa fa-file-image-o media-manager__icon-photo"></span>
                        <span class="media-manager__icon-photo media-manager__icon-photo--text">Suelta la imagen para agregarla</span>
                    </div>
                </div>

                <div class="modal-dialog modal-lg media-manager__manage-img-dialog" role="document">
                    <div class="modal-content">

                        @include('admin.media_manager.partials._header')

                        <div class="modal-body media-manager__manage-img-body">
                            <div class="row media-manager__row">
                                <div class="col-xs-12">
                                        <div class="col-xs-2">
                                            <input type="search" placeholder="Buscar" name="" class="input input__search" v-model="search">
                                        </div>

                                        <div class="col-xs-3">
                                            <label for="sort">Ordernar por:</label>
                                            <select class="form-control" placeholder="Ordenar por" name="sort" id="" v-model="sort_by">
                                                <option :value="order.value" v-for="order in sort_types">@{{order.name.es}}</option>
                                            </select>
                                        </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-2">

                                    {!! Form::open([
                                        'method' => 'POST',
                                        'class' => 'input__file media-manager__file-container',
                                        'route'                => ['admin::photos.ajax.store'],
                                        'role'                  => 'form',
                                        'id'                    => 'create_photo_form',
                                        'v-on:submit.prevent'   => 'post'
                                        ]) !!}

                                        <label id="file_input-label" for="file_input">
                                            <span class="fa fa-camera media-manager__icon-camera " v-if="DnDEvents.bin === ''"></span>
                                            <span class="media-manager__icon-camera media-manager__icon-camera--add"  v-if="DnDEvents.bin === ''">Agregar</span>
                                            <span class="media-manager__icon-camera media-manager__icon-camera--change media-manager__icon-camera--change"  v-if="DnDEvents.bin !== ''">Cambiar</span>
                                            <img id="media-manager__dropped-img-container" class="media-manager__dropped-img-container" v-if="DnDEvents.bin !== ''">


                                            {!! Form::file('file_input', [
                                                'id'        =>   'media-manager__droppable-input',
                                                'class'     => 'hide-input hide-button media-manager__droppable-input',
                                                'required'  => 'required',
                                                'v-model'   => 'file_input',
                                                'v-on:change' => 'makePost',
                                                'form'      => 'create_photo_form',
                                            ]) !!}

                                        </label>

                                    {!! Form::close() !!}
                                </div>

                                <div class="media-manager__manage-img-scroll"
                                v-bind:class="{
                                        'col-xs-10': chosen_img.src === '',
                                        'col-xs-6': chosen_img.src !== ''
                                    }">
                                    @include('admin.media_manager.partials._images')
                                </div>

                                <div class="col-xs-4">
                                    @include('admin.media_manager.partials._updateForm')
                                </div>
                            </div>
                        </div>

                        @include('admin.media_manager.partials._footer')

                    </div>
                </div>
            </div>
        </div>
    </script>
</div>
