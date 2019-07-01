<div class="row">
	@include('admin.general._page-subtitle', ['title' => trans('manage_settings.event_create_images.title') ])

	<div class="col-xs-10 col-xs-offset-1">


		<div class="row contact__row" style="margin-bottom: 2rem;">
			@for ($i = 2; $i <= 5; $i++)

				<div class="col-xs-6 text-center">

					<label for="" class="input-label">Paso {{ $i }}:</label>
					<single-image
						v-ref:{{ $setting_create_event_images->key . '_thumbnail_'.$i }}
						:type="'product-photos'"
						:current-image="'{{ json_encode($setting_create_event_images->getFirstPhotoTo( [ 'use' => 'thumbnail', 'order' => $i ] ))   }}'"
						:photoable-id="'{{ $setting_create_event_images->key }}'"
						:photoable-type="'{{ $setting_create_event_images->getPhotoableCode() }}'"
						:use="'thumbnail'"
						:class="''"
						:default-order="'{{ $i }}'"
					></single-image>

				</div>

			@endfor
		</div>


	</div>
</div>
