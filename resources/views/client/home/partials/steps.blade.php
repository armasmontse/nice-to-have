<section class="grid__container home__container--steps {{isset($container__class) ? $container__class : ''}}">
	<div class="grid__col-1-1--md">
		<h2 class="home__ttl--steps home__ttl--steps--small">{{$title}}</h2>
		<div class="divisor home__divisor--steps"></div>
		<h3 class="home__ttl--steps--number home__ttl--steps--number--small">{{$number}}</h3>
		<div class="wysiwyg home__p--steps">
			{!!$content!!}
		</div>
	</div>
</section>
