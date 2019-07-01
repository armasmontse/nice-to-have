<div class="shop__event-header shop__flex-subcontainer" >
	<div class="shop__col--flex shop__col--h-500  shop__col shop__col--xs grid__pad-for-2">
		<a href="{{$link}}" class="shop__bg-img shop__col--h-500" style="background-image: url({{ $image_url  }})">
			<div class="shop__ttl--featured-container">

				<h3 class="shop__ttl shop__ttl--featured">{{  $image_label   }}</h3>
			</div>
		</a>
	</div>
	<div class="shop__col--static shop__col--h-500 shop__col shop__col--xs grid__pad-for-2 flex">
		@include('client.shop.partials.grid-info-box',[
			"link" 			=> $link,
			"title" 		=> $title,
			"subtitle" 		=> $subtitle,
			"description"	=> $description,
		])
	</div>
</div>
