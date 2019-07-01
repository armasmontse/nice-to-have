<script type="x/templates" id="pagesections-checkbox-template">
	<div class="col-xs-10  col-xs-offset-1">

		<a href="#" data-toggle="modal" data-target="#pagesections-modal-create" class="modal-trigger select--modal-trigger link-as-button">
			<i class="fa fa-plus-circle"></i>
			Agregar una seccion
        </a>

		<div class="row row-mt">
			{!! Form::open([
				'method'                => 'patch',
				'route'                => ['admin::pages.sections.ajax.association',$page_edit->id,'&#123;&#123;section.id&#125;&#125;'],
				'role'                  => 'form' ,
				'id'                    => 'update_section_asociation-&#123;&#123;section.id&#125;&#125;_form',
				'class'                 => 'col-xs-4',
				'v-for'    				=> 'section in list'
			]) !!}

				{!! Form::checkbox('section[&#123;&#123;section.id&#125;&#125;]', '&#123;&#123;section.id&#125;&#125;', null, [
					'class'     	=> 'input__checkbox',
					'id'      		=> 'section_&#123;&#123;section.id&#125;&#125;',
					'form'      	=> 'update_section_asociation-&#123;&#123;section.id&#125;&#125;_form',
					'value'      	=> '&#123;&#123;section.id&#125;&#125;',
					':checked'		=> 'is_checked(section.id)',
					'v-model'    	=> 'selected_checkboxes',
					'v-on:change'   => 'makePost',
				]) !!}

				<label for="section_&#123;&#123;section.id&#125;&#125;" class="">
					&#123;&#123;section.index&#125;&#125;
				</label>

			{!!Form::close()!!}
		</div>
	</div>
</script>
