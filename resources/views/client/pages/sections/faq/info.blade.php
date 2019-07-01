<div class="general-page-info-section faq_section_JS">
	<div class="general-page-info-section__container grid__container">
		<div class="grid__col-1-1--sm">
			<h3 class="general-page-info-section__ttl faq_btn_JS">{!! $section->label !!}
				<span class="general-page-info-section__caret faq_caret_JS">
					{!! file_get_contents('images/flecha-faq.svg') !!}
				</span>
			</h3>
		</div>
	</div>

	<div class="divisor"></div>

	<div class="faq_children-container_JS" style="display:none">

		@foreach ($section->components as $component)
			<div class="general-page-info-section">
				<div class="general-page-info-section__container grid__container">
					<div class="grid__col-1-1--sm">
						<h3 class="general-page-info-section__ttl general-page-info-section__ttl--big">{!! $component->title !!}</h3>
						<div class="general-page-info-section__p general-page-info-section__p--small">
							{!! $component->content !!}
						</div>
					</div>
				</div>
			</div>
		@endforeach

	</div>
</div>
