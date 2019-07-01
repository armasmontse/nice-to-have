@extends('layouts.admin')

@section('title')
    Administrador de las secciones de las páginas
@endsection

@section('h1')
    Administrador de las secciones de las páginas
@endsection

@section('content')

	<pagesections :list="store.pagesections.data" :store.sync="store"></pagesections>
	<script type="x/templates" id="pagesections-template">
		<div class="row">

			<div class="col-xs-10 col-xs-offset-1">
				<a href="#" data-toggle="modal" data-target="#pagesections-modal-create" class="modal-trigger select--modal-trigger link-as-button">
					<i class="fa fa-plus-circle"></i>
					Agregar una seccion
		        </a>
		    </div>

			<div class="col-xs-12">
			    <hr>
			</div>

			<div class="col-xs-10 col-xs-offset-1">
			    <div class="row">
			        @include('admin.pages.sections.index._table')
			    </div>
			</div>

		</div>
	</script>

@endsection

@section('modals')
	@include('admin.pages.sections._modal-create')
	@include('admin.pages.sections._modal-edit')
@endsection

@section('vue_store')
	<script>
		mainVueStore.pagesections = {
			data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
			routes: {
			   get: '{{route('admin::pages.sections.ajax.index')}}'
			}
		};
	</script>
@endsection
