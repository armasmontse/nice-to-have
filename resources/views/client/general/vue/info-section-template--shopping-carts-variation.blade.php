<script type="x/templates" id="info-section-template">
	<div class="info-section">
		<div class="info-section__container grid__container">
			<div class="grid__col-1-1--sm info-section__col-1-1">
				<h3 class="info-section__ttl-italic"><a href="#">@{{section.title}} (@{{section.total_items}})</a></h3>
				<div class="info-section__link-container">
					<a href="{{url('/shop')}}" class="info-section__link">continua con tu compra. ver carrito</a>
				</div>
				<p class="info-section__p">@{{{section.content}}}</p>
			</div>
		</div>
		<div class="divisor"></div>
	</div>
</script>
