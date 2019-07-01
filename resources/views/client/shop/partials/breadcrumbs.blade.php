<div class="breadcrumbs">
	@foreach ($link_parts as $link_part)
		<a href="{{ $link_part["link"] }}" class="breadcrumbs__link" >
			{{$link_part["label"]}}
		</a>

		@if (!$loop->last)
			<span class="breadcrumbs__delimiter" >/</span>
		@endif
	@endforeach
</div>
