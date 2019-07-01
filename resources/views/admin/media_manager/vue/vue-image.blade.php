<div class="image__col--@{{type}} image__col camera-blue singleImage--@{{printable_ref}}_JS" :data-id="image.id"">
	<slot name="title"></slot>
	<slot name="description"></slot>
	<div class="image--@{{type}}">
		<div class="image--@{{type}}__aspect-ratio-container h-inherit w-inherit flex">
			<div class="image__inline-block-container" v-bind:class="{
				'h-100': !image.src,
				'w-100': !image.src
			}">
				<div  v-on:click="initAddMediaProcess(media_manager, $event)" style="cursor: pointer;">
					<slot name="data"></slot>
					<div  v-if="!image.src" class="image__placeholder image__placeholder--single">
						<div class="image__icon-container text-center">
							<span class="fa fa-camera fa-3x" style="display: block;"></span>
							<span class="">Agregar</span>
						</div>
					</div>
					<img  v-else class="image" v-bind:src="image.src" data-id="@{{image.id}}">
				</div>
				<div v-if="image.src">
					<slot name="permutation-arrows"></slot>
					<slot name="remove" v-if="!image.src"></slot>
				</div>
				<div v-if="image.src">
					{!! Form::open([
						'method'             => 'DELETE',
						'route'             => ['admin::photos.ajax.disassociate', '&#123;&#123;image.id&#125;&#125;'],
						'role'               => 'form' ,
						'id'                 => 'disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form',
						'v-on:submit.prevent'  => 'post',
						'data-index' => '&#123;&#123;index&#125;&#125;'
					]) !!}
					{!! Form::hidden("photo_id", null, [
						'required' => 'required',
						'form'     => 'disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form',
						'v-model' => 'image.id'
					]) !!}
					{!! Form::hidden("photoable_id", null, [
						'required' => 'required',
						'form'     => 'disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form',
						'v-model' => 'photoableId'
					]) !!}
					{!! Form::hidden("photoable_type", null, [
						'required' => 'required',
						'form'     => 'disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form',
						'v-model' => 'photoableType'
					]) !!}
					{!! Form::hidden("use", null, [
						'required' => 'required',
						'form'     => 'disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form',
						'v-model' => 'use'
					]) !!}
					{!! Form::hidden("class", null, [
						'required' => 'required',
						'form'     => 'disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form',
						'v-model' => 'class'
					]) !!}
					{!! Form::hidden("order", null, [
						'required' => 'required',
						'form'     => 'disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form',
						'v-model' => 'order'
					]) !!}
						<button form="disassociate_photos-&#123;&#123;printable_ref_indexed&#125;&#125;_form" class="button__as-link" type="submit">(Eliminar)</button>
					{{-- <span  class="text__p">(<a class="text__a--eliminar" v-on:click="removeImage(index)">Eliminar</a>)</span> --}}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	<div>
		<slot name="size"></slot>
	</div>
</div>
