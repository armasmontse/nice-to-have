
<input type="text" name="" v-model="search" @keydown="selector">
@{{ $data | json}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.min.js"></script>
<script type="text/javascript">
	var search = new Vue({
		el: 'body',
		data: {
			search: '',
			index: -1,
			searchable_array: ['a', 'b', 'c']
		},
		ready: function() {
			console.log('corre vuer');
		},
		methods: {
			selector(e) {
				let key = e.keyCode;
				if([38,40].indexOf(key) > -1) {//up and down keys
				let direction  = {'38': 1, '40': -1}[key+''];
				if(this.index + direction > -1 && this.index + direction < this.searchable_array.length) {
					this.index += direction
				}
				console.log(this.index);

				}
			}
		}
	});
</script>
