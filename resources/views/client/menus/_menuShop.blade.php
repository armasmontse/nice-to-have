<nav id="menuShop" class="menuShop">
	<div class="grid__row">
		<div class="grid__container menuShop__container">
			<div id="menuShop__link-container" class="menuShop__link-container">
				{{-- @foreach ($genders as $gender)
					<a href="{{ $gender->shopFilterUrl()  }}"  class="menuShop__link submenu__link_JS">{{ $gender->translation()->name  }}
					</a>
				@endforeach

				@foreach ($sections as $section)
					<a href="{{ $section->shopFilterUrl()  }}"  class="menuShop__link submenu__link_JS">
						{{ $section->translation()->name  }}
					</a>
				@endforeach --}}

				@foreach ($gender_and_section_links as $link)
					<a href="{{  $link["url"]   }}"  class=" {{  $link["class"]   }} menuShop__link submenu__link_JS">
						{{ $link["label"]  }}
					</a>
				@endforeach

				<a href="#"  class="menuShop__link submenu__link_JS">
					Category
						{!! file_get_contents('images/icon-arrow-down.svg')!!}
				</a>
			</div>
		</div>
	</div>
</nav>
