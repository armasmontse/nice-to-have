@extends('layouts.test-client',  ['body_id' => 'main-vue'])

@section('content')
<style type="text/css">
	body {
		padding: 25px;
		padding-bottom: 75px;
	}
	.goto, br {
		font-size: 40px;
		margin-bottom: 60px;
	}
	.mb {
		font-size: 20px;
		margin-bottom: 40px;
	}
	a {
		display: block;
	}

	h1,h2,h3,h4,h5,h6,p,a{
		margin-bottom: 10px;
	}
</style>
{{-- <h1 class="goto">Para los inputs, ir <a href="{{url('/cltvo/inputs-test')}}">aquí</a> </h1>
<div class="mb"> (Los margin-bottoms pertenecen al ejemplo)</div> --}}

<div class="padding w50">

	<div class="mb"> (Los titulos y demás elementos son invariantes respecto de las tags)</div>
	<h1 class="title-sans">h1 %title-sans</h1>
	<h2 class="title-sans">h2 %title-sans</h2>
	<h3 class="title-sans">h3 %title-sans</h3>
	<h4 class="title-sans">h4 %title-sans</h4>
	<h5 class="title-sans">h5 %title-sans</h5>
	<h6 class="title-sans">h6 %title-sans</h6>
	<br>


	<h1 class="title-sans--sm">%title-sans--sm</h1>
	<h3 class="title-sans--secondary">%title-sans--secondary</h3>
	<br>
	<h3 class="title-serif">%title-serif</h3>
	<h3 class="title-serif--lg">%title-serif--lg QQQ</h3>
	<h3 class="title-serif--xl">%title-serif--xl</h3>
	<br>
	<p class="paragraph">p %paragraph</p>
	<p class="paragraph--lg">p %paragraph--lg</p>
	<p class="paragraph--price">p %paragraph--price</p>
	<br>
	<div class="mb"> (Los links tienen display block, sólo para este ejemplo)</div>
	<a href="#" class="link">%link</a>
	<a href="#" class="link-menu">%link-menu</a>
	<a href="#" class="link-underline">%link-underline</a>

	<div class="divisor mb">Divisor abajo: .divisor</div>
	<br>
</div>
@endsection
