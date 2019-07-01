import debounce from 'lodash.debounce';

export const filterMenuFixer = selector => {
	let sidebar =  $('.shop__sidebar_JS');
	if ( sidebar.length === 0 ) {
		// console.error(`se necesita la presencia del selector ".shop__sidebar_JS"`); 
		return 0;
	}
	let menu = $(selector);

	//valore hardocodeados, podrían causar problemas, pero simplifican la relación con el dom, volver dinámicos si se encuentran problemas
	let menuTop_height = 30;
	let menuMain_height = 34;
	let gutter = 25;


	let w = $(window);
	let w_height = w.height();
	
	let sidebar_data = {};
	let getSidebarData = () =>  {
		sidebar_data =  {
			left: sidebar.offset().left,
			height: sidebar.height(),
			width: sidebar.width()-11,
			offset_bottom: sidebar.offset().top + sidebar.height() 
		}
	}
	
	//
	let initial_position = menu.offset().top;
	let menu_height = menu.height();

	//Menu State
	let is_fixed = false;
	let	menu_is_bigger_than_sidebar = false;

	/*Calculations*/
	
	//Usamos setInterval para evaluar los datos del sidebar cada 500ms. 
	//Por dos razones :
	//1. Carga Ajax: porque los productos se cargan por ajax y no podemos saber ni cuando sucederá ni el tamaño que tendrá el sidebar después de eso (por flexbox, el sidebar crece tanto como la sección de productos)
	//2. Cuando se filtran los productos, tampoco podemos conocer el tamaño resultante,
	//
	//La razón úlitma es en realidad porque ambos eventos suceden dentro de Vue, pero estamos manejando esto con jQuery
	setInterval(function() {
		if (sidebar_data.height  >  menu.height()) {
			menu_is_bigger_than_sidebar = false;
		} 
		getSidebarData()
	} , 500);


	let positionMenu = () => {
		let menu = $(selector);
		let menu_defaults = {
				position: 'relative',
				top: 'initial',
				left: 'initial',
				width: 'auto',
				paddingRight: 0,
				height: 'auto'
			}
		let w_scrollTop = w.scrollTop();
		let w_pos_with_menus = w_scrollTop + menuTop_height+ menuMain_height
		let menu_offset_bottom = menu.height() + w_scrollTop +  menuTop_height + menuMain_height
		let at_end_of_sidebar = menu_offset_bottom > sidebar_data.offset_bottom
		
		/*Precaso*/
		if (sidebar_data.height  >  menu.height() + 300) {
			//OJO     IMPORTANTE 
			//valor hardcodeado para no tener que hacer demasiados queries para sumar el rsto de los elementos del sidebar  y sus márgenes a la altura del menu.
			//SIRVE PARA evitar problemas cuando el menu llega al final del sidebar, pero el contenedor ce productos es demasiado pequeño y entonces se corre el caso¨correspondiente a "at_end_of_sidebar && !menu_is_bigger_than_sidebar"
			menu_is_bigger_than_sidebar = false;
		} else  {
			menu.css(menu_defaults)
			is_fixed = false;
			menu_is_bigger_than_sidebar  = true;
			return
		}


		/*======Casos====*/

		//cuando el menu está hasta arriba
		if (w_pos_with_menus < initial_position && is_fixed === true) {
			// console.log('menu hasta arriba');
			menu.css(menu_defaults)
			is_fixed = false;
			return	
		}
		
		//cuando está fijo o cuando el div colapsaria si el menu llega hasta abajo y no hay suficientes productos
		if (
			w_pos_with_menus > initial_position && 
			is_fixed === false &&
			!(at_end_of_sidebar && !menu_is_bigger_than_sidebar )
		) {
			let css = {
				position: 'fixed',
				top: menuTop_height+ menuMain_height + 1,//para que no se corte el texto
				left: sidebar_data.left,
				
				//gutter, para dar espacio a la barra de scroll
				width: sidebar_data.width + gutter,
				paddingRight: gutter,
				height: menu.height() >= w_height - (menuTop_height+ menuMain_height) 
					? w_height - (menuTop_height+ menuMain_height) 
					: 'auto',//definimos height de esta manager para hacer posible el overflowY: auto
				overflowY: 'auto',
			}
			// console.log("menu", css);
			menu.css(css)
			is_fixed = true;
			return
		} 

		//cuando llega al final del sidebar
		if (at_end_of_sidebar && !menu_is_bigger_than_sidebar) { 
			// console.log('final del sidebar');

			menu.css({
				position: 'absolute',
				top: 'initial',
				left: 'initial',
				bottom: 0,
				width: sidebar_data.width + gutter,
				paddingRight: gutter,
				height: 'auto',
				overflowY: 'auto',
			})
			is_fixed = false;
			return
		}

	}

	/*handlers*/
	//Resize (actualiza variables y recalcula la sitaución del menu)
	w.on('resize click keyup', debounce(() => {
			is_fixed = false;
			w_height = w.height();
			menu_height = menu.height();
			getSidebarData()
			positionMenu()
		}, 250))
	//Scroll
	w.on('scroll', positionMenu)
}