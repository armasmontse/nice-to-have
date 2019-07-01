<!DOCTYPE html>
<html lang="es">
	@include('admin.general.head')

	<body id="admin-vue">
		@include('admin.general._alerts')
		@include('admin.general._menu')

		<div class="admin">
			<div class="sidebar">
				@include('admin.general._sidebar')
			</div>
			<div class="admin__content">

				<div class="admin__content--row">
					<div class="col-xs-12">
						<h1 class="page-header content__header-title">@yield('h1')</h1>
					</div>
					@yield('content')
				</div>

				<div class="clearfix"></div>
				<div class="admin__footer">
					@include('admin.general._footer')
				</div>

			</div>
		</div>
		@yield('modals')
		@include('admin.general.scripts')
	</body>
	@yield('vue_templates')
</html>
