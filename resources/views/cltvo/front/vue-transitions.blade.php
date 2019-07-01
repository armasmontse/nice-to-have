@extends('layouts.test-client',  ['body_id' => 'main-vue'])

@section('content')
<transition-test></transition-test>
<script type="x/templates" id="transition-test-template">
	<div>

		<style>
			.cuadro {
				position: absolute;
				top: 0;
				width: 100%;
				height: 200px;
				background-color: orange;
			}
			.cuadro2 {
				background-color: blue;
			}
			button {
				position: absolute;
				bottom:  0;
			}
		</style>
		<div v-if="!is_visible" class="cuadro" transition="fade"></div>
		<div v-if="is_visible" class="cuadro cuadro2" transition="fade"></div>
		<button @click="is_visible = !is_visible">Esconde div</button>
	</div>
</script>
@endsection
