<script type="x/templates" id="multi-images-template">
  <div>

    <div class="row">
      <div class="col-xs-12">
        <h5 class="text-center">@{{title || 'Galeria'}}</h5>
      </div>
    </div>


      <div class="row row-mt" >
        <div class="col-xs-10 col-xs-offset-1" v-sortable="{onUpdate: onUpdate, onMove: onMove, group: label}">
          <div v-for="image in images" class='multiimages-image' style="width: 25%;float: left;">
            <single-image
              :ref-path="refPath"
              :index="$index"
              :parent-ref="ref"
              :type="type"
              :photoable-id="photoableId"
              :photoable-type="photoableType"
              :use="use"
              :class="class"
              :current-image="image"
              :default-order="defaultOrder"
              >
              <div slot="remove">
                <a class="button__as-link" v-on:click.stop="remove($index)">Remover</a>
              </div>
            </single-image>
          </div>
        </div>
      </div>


    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
        <div class="row row-mt">
          <div class="col-xs-2" v-on:click="addSingleImageComponent" style="cursor: pointer;">
            <span class="fa fa-plus fa-2x" style="display: block;"></span>
            <span class="">Agregar</span>
          </div>

          <div class="col-xs-10">
            {!! Form::open([
              'method' => 'PATCH',
              'route' => ['admin::photos.ajax.sort'],
              'role' => 'form' ,
              ':id' => " 'sort-multi-images_'+printable_ref+'_form' ",
              'class' => '',
              'style' => 'float:right;',
              'v-on:submit.prevent' => 'postOrders'
              ]) !!}

              {!! Form::submit('Guardar Orden', ['class' => 'btn btn-primary button', ':form'=> "'sort-multi-images_'+printable_ref+'_form'"]) !!}

                  <input type="hidden" :form="'sort-multi-images_'+printable_ref+'_form'" name="photos[]" :value="id" v-for="id in ordered_ids">

              {!! Form::hidden("class", null, [
                'required' => 'required',
                ':form' => " 'sort-multi-images_'+printable_ref+'_form' ",
                'v-model' => 'class'
                ]) !!}
              {!! Form::hidden("use", null, [
                'required' => 'required',
                ':form'  => " 'sort-multi-images_'+printable_ref+'_form' ",
                'v-model' =>  'use'
                ]) !!}
              {!! Form::hidden("photoable_type", null, [
                'required' => 'required',
                ':form' => " 'sort-multi-images_'+printable_ref+'_form' ",
                'v-model' =>  'photoableType'
                ]) !!}
              {!! Form::hidden("photoable_id", null, [
                'required' => 'required',
                ':form' => " 'sort-multi-images_'+printable_ref+'_form' ",
                'v-model' =>  'photoableId'
                ]) !!}
            {!! Form::close()!!}
          </div>
        </div>
      </div>
    </div>

  </div>
</script>
