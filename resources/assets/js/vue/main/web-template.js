import R from 'ramda';
import {templatesSortableList} from '../components/templates-sortable-list';
import {vueSlider} from '../helpers';
import {objsById, orderAscending, idsByParentIds, mapIndexed, headOr, toArray} from '../../functions/pure';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';

const findTemplate = (template_id, templates)=> R.compose (
	headOr({}),
	R.filter(t => t.id === template_id)
)(templates)


export const webTemplate = {
	mixins: [shoppingBagDataAndComputedProps],
	components: {templatesSortableList},

	data: {
		create_section_modal_is_open: false,

		palettes: [],

		selected_template: {},

		selected_palette_id: -1,

		selected_section: {},

		store: {

			section_type_names: {
				[1]: 'Texto',
				[2]: 'Imagen',
				[3]: 'Video',
				[4]: 'Mapa',
			},
		}
	},

	computed: {
		selected_palette() {
			return headOr(
				{},
				this.palettes.filter(p =>
					p.id === this.selected_palette_id)
			)
		}
	},

	ready() {
		//selector de headers
		var currentTemplateHeader = this.store.personal_event.event_template.event_template_header_id;
		var initialSlide = currentTemplateHeader != null ? currentTemplateHeader - 1 : 1;

		vueSlider('#userEvent__template-selector', '.userEvent__slider', {
			spaceBetween: 32,
			centeredSlides: true,
			slidesPerView: 2,
			slideToClickedSlide: true,
			autoplay: 0,
			loop: false,
			freeMode: false,
			initialSlide: initialSlide,
		});

		//setup de las paletas de color
		this.palettes = R.map(palette => ({
			id: palette.id,
			colors: R.fromPairs(
				mapIndexed((color, i) =>
					color === 'FFFFFF'
						? [`c${i}`, {backgroundColor:`#${color}`, border:'solid 1px rgb(167, 167, 167)'}]
						: [`c${i}`, {backgroundColor:`#${color}`}],
					palette.colors)
				)
		}), this.store.palettes)

		//scrollTo Hash
		$('a[href*=\\#]').on('click', function(e){
			var href = $(this).attr('href');
			var hash = href.substr(href.indexOf("#"));
			if ($(hash).length != 0) {
				e.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top - 85
				});
			} else {
				$('html,body').animate({
					scrollTop: $(window.location.hash).offset().top - 85
				});
			}

		});

		//Time Input
		$("#time_input_JS").on('change', function() {
			var before = this.defaultValue;
			var after = this.value;
			var partsBefore = before.split(':');
			var partsAfter = after.split(':');
			this.defaultValue = after;
		});

		let template = R.pathOr({}, ['store', 'personal_event','event_template'], this)
		let template_id = template.event_template_header_id;
		this.selectTemplate(findTemplate(template_id, this.store.template_headers));
		this.selected_palette_id = template.color_palette_id
		this.selectedSectionMethod(-1);
	},

	methods: {//IO
		closeModal(name) { this[`${name}_is_open`] = false;	},

		openModal(name) { this[`${name}_is_open`] = true;	},

		hexColorWithoutHash(background_color) {
			let bgc = typeof background_color === 'string' ? background_color : ''
			return background_color.replace('#', '')
		},

		selectTemplate(template) {
			//si no hay template seleccionado, pasamos el template,
			//si hay template seleccionado sobreeescribimos sólo lo
			//que viene del template_headers del store,
			//pero conservamos cosas como el background-color y
			//otras propiedades que pudimos haber añadido
				this.selected_template = R.mergeAll([
					{ 	//defaults
						timer: R.pathOr(0, ['store', 'personal_event', 'event_template', 'timer'], this),
						background_color: R.pathOr('', ['store', 'personal_event', 'event_template', 'background_color'], this),
						image_background_color: R.pathOr('', ['store', 'personal_event', 'event_template', 'image_background_color'], this),
						html: R.pathOr('', ['store', 'personal_event', 'description'], this)
					},
					R.dissoc('id', template),//defaults del template
					this.selected_template || {},//lo que ya tenemos del header
					{event_template_header_id: template.id},// su id
					{//la imagen, la ponemos aquí abajo por si ha cambiado
						thumbnail_image: {
							url: R.pathOr('', ['store', 'personal_event', 'thumbnail_image', 'url'], this)
						}
					}
				])

				if (this.selected_section.event_template_header_id !== undefined) {//si la sección que se edita actualmente es la del template, entonces resicronizar objetos de selected_section y selected_template
					this.selectedSectionMethod(-1);//por convención pasamos -1 para seleccionar el template
				}
				return  this.selected_template;
		},

		onPaletteChange(form, palette_id) {
			this.selectPalette(palette_id);
			this.$nextTick(() => {
				if (this.selected_template.event_template_header_id !== undefined) {
					this.post(document.getElementById(form));
				}
			})
		},

		selectPalette(palette_id) {
			this.selected_palette_id = palette_id
		},

		selectColor(section, color) {section.background_color = color;},

		onUpdatedesignSuccess(body, input) {
			let template = R.path(['data', 'event_template'], body);
			let template_id = template.event_template_header_id;
			this.selectTemplate(findTemplate(template_id, this.store.template_headers));
			this.selectPalette(template.color_palette_id)
		},

		onUpdatedesignError(body, input) {
			this.onUpdatedesignSuccess(body, input);
		},

		onUpdatesectionSuccess(body) {
			this.onUpdate(body);

		},

		onUpdatetemplateSuccess(body) {
			this.reSelectSection();
		},

		onAddsectionSuccess(body) {
			this.store.personal_event.event_template.event_template_sections.push(body.data);
			this.selectedSectionMethod(body.data.id);
			this.create_section_modal_is_open = false;
		},

		onAddedFile(form_to_be_appended_selector, event) {

			let file = event.target;
			let input_clone = file.cloneNode(true);
			file.setAttribute('form', 'addimage_form')
			let form = document.getElementById(form_to_be_appended_selector);
			let input_container = document.getElementById('addimage_form-main-input');
			input_container.innerHTML='';
			input_container.appendChild(file);
			this.post(form);

			//puesto que movimos el input de lugar, ahora pasamos una copia a donde deberia estar
			let parents = toArray(document.querySelectorAll('.userEvent__template-edit-img')) //aquellos nodos que pueden tener un input tipo file para las imagenes
			parents.forEach(parent => {
				let child = parent.querySelectorAll('.userEvent__template-edit-img-file')
				if (child.length === 0) {
					parent.appendChild(input_clone);
				}
			})
		},

		onAddimageSuccess(body) {
			this.onUpdate(body);
		},

		onUpdate(body) {
			this.store.personal_event = body.data;
			this.reSelectSection();
		},

		reSelectSection() {
			// Hack para que se refresque la sección, tenemos que voler a reseleccionarla,
			// porque reemplazamos todo el personal event,
			// por lo que el objeto que pertenecía a selected_section ya no existe
			let template_id = this.selected_section.event_template_header_id;
			let section_id = this.selected_section.id;
			if (template_id) {
				this.selectTemplate(findTemplate(template_id, this.store.template_headers));
				return;
			}
			this.selected_section = {};
			this.selectedSectionMethod(section_id);
		},

		setBackgroundColor(section, color) {
			section.background_color = color;
		},

		setImageBackgroundColor(section, color) {
			section.image_background_color = color;
		},

		selectedSectionMethod(section_id, selected_by_click) {
			let section;
			if (section_id === -1 ) {
				section = this.selected_template;
				if (selected_by_click && this.selected_template.event_template_header_id === undefined) {
					this.alertError(['Es necesario que primero selecciones un diseño y una paleta de color, y que los guardes.'])
				}
			} else {
				section = headOr({},
					R.filter(
						section => section.id === section_id,
						R.pathOr([], ['store', 'personal_event', 'event_template', 'event_template_sections'], this)
					)
				)
			}
			this.selected_section = section;
		}
	},

	events: {
		selectedSection(section_id, selected_by_click) {
			this.selectedSectionMethod(section_id, selected_by_click)
		},

		onDeletedSection() {
			let section_id = this.selected_section;
			this.selectedSectionMethod(section_id);
		}
	}
};
