@extends('layouts.client', ['body_id'	=> 	'events-vue'])

@section('content')
<style>
	.comp1, .comp2 , .comp3 {
		height: 70px;
		font-size: 20px;
		background-color: lightblue
	}

	.comp2 {
		background-color: orange;
	}

	.comp3 {
		background-color: pink;
	}

</style>
	<h1>Crear</h1>
	<button @click="createComponent('comp1')">Comp 1</button>
	<button @click="createComponent('comp2')">Comp 2</button>
	<button @click="createComponent('comp3')">Comp 3</button>

	<div class="grid__container">
		<div class="grid__col-1-2">

			<h1>Editar</h1>
			<div v-for="component in components">
				<button @click="shiftComponent(-1, $index)">Subir</button>
				<button @click="shiftComponent(1, $index)">Bajar</button>
				<h1>@{{component.type}}</h1>
				<input type="text" v-model="components[$index].content">
			</div>
		</div>

		<div class="grid__col-1-2" id="events__col-preview">
			<div v-for="component in components" track-by="$index">
				<div>
					<component :is="component.type" :content="component.content" v-ref:nested></component>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('vue_templates')
	<script type="x/templates" id="comp1-template">
		<h1 :style="position" class="comp1">@{{type}}, @{{content}}</h1>
	</script>
	<script type="x/templates" id="comp2-template">
		<h1 class="comp2">@{{type}}, @{{content}}</h1>
	</script>

	<script type="x/templates" id="comp3-template">
		<h1 class="comp3">@{{type}}, @{{content}}</h1>
	</script>

@endsection
