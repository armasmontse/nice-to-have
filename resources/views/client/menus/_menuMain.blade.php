<style media="screen">
	.invisible { display: none;}
	.menuMain__link .coming-soon { display: none; }
	.menuMain__link:hover .empty-item { display: none; }
	.menuMain__link:hover .coming-soon { display: inline; }
</style>

<nav id="menuMain" class="menuMain">
	{{-- <span  id="menuMain__icon" class="menuMain__icon">Menu</span> --}}
	<div class="menuMain__link-container">

		@foreach ($menu_items as $menu_item)

			<a href="{{ $menu_item["link"] ? $menu_item["link"] : "#"  }}" class="menuMain__link {{ $menu_item["selected"] ? "selected" : "" }}">

				<span class="{{ empty($menu_item["link"]) ? "empty-item" : "" }}">{{ $menu_item["label"]  }}</span>

				@if (empty($menu_item["link"]))
					<span class="menuMain__link invisible coming-soon">Próximamente</span>
				@endif

			</a>

		@endforeach

	</div>
</nav>
