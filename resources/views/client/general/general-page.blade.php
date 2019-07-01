<div class="general-page">
	@include('client.general.page-title', ['title' => $title])
	<div class="general-page__main-content">
		<div class="grid__container">
			<div class="wysiwyg general-page__col-1-1 grid__col-1-1--sm">
				{!!$content!!}
			</div>
		</div>
	</div>
</div>		
