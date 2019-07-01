import Vue from 'vue'

//muestra de test para un componente de  Vue

describe('Hello.vue', () => {

	it('should render correct contents', () => {
		//creamos el template y el componente
		const comTemplate = '<h1 class="hello">Hello World!</h1>'
		const myComp = Vue.extend({template: comTemplate, data: function() {return{msg:'Hello, World!'}}, props:['propy']})  

		//creamos la instancia de Vue
		const vm = new Vue({
			template: 
			`<div >
				<h1 class="hello">Hello World!</h1>
				<my-comp :propy="propy"></my-comp>
			</div>`,
			data: {
				propy: true,
			},
			components: { myComp }
		}).$mount()

		//testeamos que el componente se imprima en el dom
		let hello = vm.$el.querySelector('.hello').textContent
		expect(hello).toEqual('Hello World!')

		//acceso al componente y a las propiedades del mismo   
		let my_comp = vm.$children[0]
		expect(my_comp.propy).toEqual(true)

		//se modifica una propiedad y esta responde reactivamente en el siguiente Tick
		vm.$data.propy = false
		Vue.nextTick(() => {
			expect(my_comp.propy).toEqual(false)
		})
	})
})
