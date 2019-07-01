<div class="general-page">
	<div class="page-title__title-container">
		<h2 class="page-title__title">{!! $section->components[0]->title !!}</h2>
	</div>

	<div class="divisor"></div>

	<img class="home--different-mb" src="{{$section->components[0]->thumbnail_image->url}}">

	<div class="general-page__main-content">
		<div class="grid__container">
			<div class="wysiwyg general-page__col-1-1 grid__col-1-1--sm">
			<h3 class="page-title__title" style="text-align: left;">{!! $section->components[0]->subtitle !!}</h3>
				{!! $section->components[0]->content !!}
			</div>
		</div>
	</div>
</div>