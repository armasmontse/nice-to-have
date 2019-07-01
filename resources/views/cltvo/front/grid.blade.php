@extends('layouts.test-client')

@section('content')
<style>

	.h1000 {
		height: 1000px;
	}

	/*Grid Debug*/
	.debug .grid__row {
		position: relative;
		background-color: #0047b3;
		min-height: 200px; }

	.debug .grid__container, .debug .grid__container--full-width {
		background-color: #876A3B;
		min-height: 100px;
		margin-bottom: 20px; }

	.debug .grid__col-1-1 {background-color: #ffc0cb; min-height: 100px}
	.debug .grid__col-1-2:nth-of-type(even), 
	.debug .grid__col-1-3:nth-of-type(even), 
	.debug .grid__col-1-4:nth-of-type(even) {
		background-color: #66b3ff;
		min-height: 100px; }
	.debug .grid__col-1-2:nth-of-type(odd), 
	.debug .grid__col-1-3:nth-of-type(odd),
	.debug .grid__col-1-4:nth-of-type(odd) {
		background-color: #9999ff;
		min-height: 100px; }
	.debug .grid__col-1-2--contain-fixed, .debug .grid__col-1-3--contain-fixed {
		background-color: #0B1119; }

	.debug .grid__box {
		position: relative;
		background-color: #99ffcc;
		min-height: 50px; }
	.debug .grid__box--fixed {
		background-color: #0B1119; }

	.debug .grid__fixedElem {
		background-color: #0B1119;
		height: 200px; }

	#grid__fixedElem_JS {
		height: 200px;
		background-color: rgba(135, 106, 59, 0.5);
		position: fixed;
		top: 120px; }
		@media only screen and (max-width: 768px) {
		#grid__fixedElem_JS {
		position: relative;
		top: 0; } }
</style>

<section class="debug">
	<div class="grid__row">
        <div class="grid__container">
			<div class="grid__col-1-1">
				<div class="grid__box"></div>
			</div>
        </div>

		<div class="grid__container">
			<div class="grid__col-1-1 grid__col-1-1--sm">
				<div class="grid__box"></div>
			</div>
		</div>

		<div class="grid__container">
			<div class="grid__col-1-1 grid__col-1-1--md">
				<div class="grid__box"></div>
			</div>
		</div>

        <div class="grid__container">
			<div class="grid__col-1-2">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-2">
				<div class="grid__box"></div>
			</div>
        </div>

        <div class="grid__container">
			<div class="grid__col-1-2 grid__col-1-2--sm">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-2 grid__col-1-2--lg">
				<div class="grid__box"></div>
			</div>
        </div>

        <div class="grid__container">
            <div class="grid__col-1-3">
				<div class="grid__box"></div>
			</div>

            <div class="grid__col-1-3">
				<div class="grid__box"></div>
			</div>

            <div class="grid__col-1-3">
				<div class="grid__box"></div>
			</div>
        </div>

        <div class="grid__container">
            <div class="grid__col-1-3 grid__col-1-3--sm">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-3 grid__col-1-3--lg">
				<div class="grid__box"></div>
			</div>

            <div class="grid__col-1-3 grid__col-1-3--md">
				<div class="grid__box"></div>
			</div>
        </div>

		<div class="grid__container h1000">
			<div class="grid__col-1-2">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-2 grid__col-1-2--contain-fixed">
				<div class="grid__box grid__box--fixed">
					<div id="grid__fixedElem_JS"></div>
				</div>
			</div>
		</div>
	</div>
	{{-- container__full-width --}}
	<div class="grid__row">
		<div class="grid__container--full-width">
			<div class="grid__col-1-1">
				<div class="grid__box"></div>
			</div>
		</div>

		<div class="grid__container--full-width">
			<div class="grid__col-1-1 grid__col-1-1--center">
				<div class="grid__box"></div>
			</div>
		</div>

		<div class="grid__container--full-width">
			<div class="grid__col-1-2">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-2">
				<div class="grid__box"></div>
			</div>
		</div>

		<div class="grid__container--full-width">
			<div class="grid__col-1-2 grid__col-1-2--sm">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-2 grid__col-1-2--lg">
				<div class="grid__box"></div>
			</div>
		</div>

		<div class="grid__container--full-width">
			<div class="grid__col-1-3">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-3">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-3">
				<div class="grid__box"></div>
			</div>
		</div>

		<div class="grid__container--full-width">
			<div class="grid__col-1-3 grid__col-1-3--sm">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-3 grid__col-1-3--lg">
				<div class="grid__box"></div>
			</div>

			<div class="grid__col-1-3 grid__col-1-3--md">
				<div class="grid__box"></div>
			</div>
		</div>
{{-- 1/4 --}}
		<div class="grid__container--full-width">
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
			<div class="grid__col-1-4"><div class="grid__box"></div></div>
		</div>
	</div>
</section>
@endsection
