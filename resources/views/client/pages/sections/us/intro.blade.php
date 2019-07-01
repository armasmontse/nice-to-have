{{-- Botón ScrollUp --}}
@include('client.general.scroll-up-icon')

{{-- Lema/CTA --}}
<section class="home__intro" style="background-image: url({{ isset($section->components[0]->thumbnail_image->url) ? $section->components[0]->thumbnail_image->url : '' }})">
	<div class="grid__container home__container--cta">
		<div class="grid__col-1-1--sm home__col-1-1--cta">
			<div class="home__box home__box--cta">
				<h3 class="home__ttl home__ttl--cta home__ttl--less">
				{!! $section->components[0]->content !!}
				</h3>
			</div>
		</div>
	</div>
</section>
