@foreach ($menu_items as $name => $menu_item)
	<ul class="nav sidebar__nav">		
		<label class="tree-toggler sidebar__nav-label {{ $menu_item["current"] ? "active" : "" }}">
			{{ $name }}  @if ($menu_item["current"] ) <span class="sr-only">(current)</span> @endif
		</label>
		<ul class="sidebar__nav--nested-ul tree">
			@foreach ($menu_item["sub_menu"] as $route_name => $route_label )
				<li>
					<a href="{{route($route_group_prefix.$route_name)}}">{{$route_label}}</a>
				</li>
			@endforeach
		</ul>
	</ul>
@endforeach