<script type="x/templates" id="pagesections-sort-template">
	<div class="col-xs-10  col-xs-offset-1 row-mt">

        <table class="table">
            <!-- <thead class="">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead> -->

            <tbody class="collection" v-sortable="{onUpdate: onUpdate, onMove: onMove, handle: '.handle', group: label}">
                <tr  v-for="section in sortable_list" class="text-center">
                    <td>
                        <span class="btn-floating waves-effect waves-light" @click="move(-1, $index, sortable_list)">
                            <i class="fa fa-arrow-circle-up fa-2x" aria-hidden="true"></i>
                        </span>
                        <span class="btn-floating waves-effect waves-light" @click="move(1, $index, sortable_list)">
                            <i class="fa fa-arrow-circle-down fa-2x" aria-hidden="true"></i>
                        </span>
                    </td>
                    <td>
                        @{{{ section.index }}}
                    </td>
                </tr>
            </tbody>
        </table>


    </div>
    <div class="col-xs-10 col-xs-offset-1 row-mt">
		{!! Form::open([
		    'method'                => "PATCH",
		    'route'                 => ['admin::pages.sections.ajax.sort',$page_edit],
		    'role'                  => 'form' ,
		    'id'                    => 'sort_page_sections_form',
		    'class'                 => 'pageslists--sort-form',
			'v-on:submit.prevent'   => 'post'
		    ]) !!}
		    <input
		        type="hidden"
		        v-for="id in sorted_ids"
		        :form="sort_page_sections_form"
		        name="sections[]"
		        :value="id">
		    <div class="pull-right pageslists--save-button row-mt">
		        {!! Form::submit("Guardar orden", [
		            'class' => 'btn btn-info button',
		            'form'  => 'sort_page_sections_form'
		        ]) !!}
		    </div>
		{!! Form::close() !!}
    </div>
</script>
