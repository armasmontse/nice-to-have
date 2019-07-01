<style type="text/css">
	span {text-decoration: underline;}
</style>
<div v-for="category in categories">
	<h1 v-text="category.name"></h1>
	<span @click.self="toggleSelectionOnAllSubcategories(category.name, category.subcategories)">Todos</span>
	<div class="input__checkbox-container" v-for="subcategory in category.subcategories">
		<input class="input__checkbox" type="checkbox" :id="subcategory" :value="subcategory" v-model="cats[category.name]">
		<label class="input__checkbox-label" v-text="subcategory"></label>
	</div>
</div>
{{-- Ranges --}}
<div>
	<label>Desde <input type="number" name="" v-model="price_range.from"></label>
	<label>Hasta <input type="number" name="" v-model="price_range.to"></label>
	<small class="warning" v-if="price_range.from > price_range.to">El monto ingresado en "Desde" debe ser menor al monto en "Hasta"</small>
</div>
<div>Todas: @{{selected_cats}}</div>
<pre>
@{{ $data | json}}

</pre>
<script src="//cdn.jsdelivr.net/ramda/0.22.1/ramda.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.min.js"></script>
<script type="text/javascript">
	var categories = [{
		id:'A',
		name: 'CatA',
		subcategories: [1,2,3,4,5,6,7]
	},
	{
		id:'B',
		name: 'CatB',
		subcategories: [8,9,10,11]
	},
	{
		id:'C',
		name: 'CatC',
		subcategories: [11,12,13,14,15]
	}];
Vue.config.debug = true;
	var category_filters = new Vue({
		el: 'body',
		data: {
			cats: {},
			price_range: {
				from: 0,
				to: 0
			}
		},
		ready: function() {
			R.forEach(category => this.$set('cats.'+category.name, []), categories);//es necesario meter a las categorias en otro objeto, porque  si no, el llamado dinamico en el template se rompe
			this.$set('categories', categories)
		},
		computed: {
			selected_cats() {
				return R.compose(R.flatten, R.values)(this.cats)
			},
		},
		methods: {
			toggleSelectionOnAllSubcategories(category, all_subcategories) {
				if(R.equals(this.cats[category], all_subcategories)) {
					this.cats[category] = [];
				} else {
					this.cats[category] = all_subcategories
				}
			}
		}
	});
</script>
