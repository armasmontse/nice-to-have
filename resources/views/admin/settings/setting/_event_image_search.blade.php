<div class="row">
	@include('admin.general._page-subtitle', ['title' => trans('manage_settings.event_search_image.title') ])

	<div class="col-xs-10 col-xs-offset-1">

		<div class="row contact__row" style="margin-bottom: 2rem;">

			<single-image
				v-ref:{{ $setting_event_image_search->key . '_thumbnail' }}
				:type="'product-photos'"
				:current-image="'{{ json_encode($setting_event_image_search->getFirstPhotoTo( [ 'use' => 'thumbnail'] ))   }}'"
				:photoable-id="'{{ $setting_event_image_search->key }}'"
				:photoable-type="'{{ $setting_event_image_search->getPhotoableCode() }}'"
				:use="'thumbnail'"
				:class="''"
				:default-order="''"
			></single-image>

		</div>

	</div>

</div>
