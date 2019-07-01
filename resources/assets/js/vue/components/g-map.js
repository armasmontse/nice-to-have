import R from 'ramda';
import Vue from 'vue';

export const gMap = Vue.extend({
	template: '<div style="position: relative">'+
					'<style>.map {min-height: 320px;min-width: 320px;}</style>'+
					'<label for="map_lock">Editar mapa '+
						'<input id="map_lock_{{formId}}" type="checkbox" v-model="mapIsUnlocked" style="position:relative; top:0; left:0; opacity:1">'+
					'</label>'+
					'<div id="map_{{formId}}" class="map"></div>'+
					'<input type="hidden" name="latitude" :form="form_id" v-model="lat">'+
					'<input type="hidden" name="longitude" :form="form_id" v-model="lng"></div>',

	props: ['isReady', 
			'address', 
			'formId', 
			'mapIsUnlocked', 
			'id', 
			'editIndex', 
			'latLng'],

	data() {
		return {
			map: {},
			lat: '',
			lng: '',
			marker: {},
		}
	},
	ready() {
		if (this.isReady) { this.initMap() }
	},
	
	computed: {
		form_id() {
			return R.replace('{{item_on_edit.id}}', this.id, this.formId)
		}
	},

	methods: {
		/**
		 * Creates the marker on the map version of the submission form.
		 * @param  {Object} map 
		 * @return {}     
		 */
		submissionMapMarker: function(map) {
		    var vm = this
		    var marker;

		    this.marker = new google.maps.Marker({
		         map: map,
		         position: map.center,
		         draggable:false
		    });
		    
		    //create marker and add listener
		    //add listener technique  on vue, from
		    //http://forum.vuejs.org/topic/31/attaching-vue-js-to-infowindow-content-google-maps-api/3
		    marker = this.marker;            
		    this.marker.addListener('dragend', function(event) {
		      vm.$data.lat = marker.internalPosition.lat();
		      vm.$data.lng = marker.internalPosition.lng();
		    });
		},

		initMap() {
		    this.map = new google.maps.Map(document.getElementById('map_'+ this.formId), {
		      center: {lat: 19.24, lng: -99.10},
		      zoom: 6
		    });
		},

		setPositionOnClick: function() {
		    var vm = this;
		    this.map.addListener("click", function(event) {
		        var lat = event.latLng.lat();
		        var lng = event.latLng.lng();
		        vm.lat = lat;
		        vm.lng = lng;
		        vm.marker.setPosition({lat:lat, lng:lng});
		        vm.addressFromLatLng();
		        // populate yor box/field with lat, lng
		    });
		},

		locateAddress: function()  {
		    var geocoder = new google.maps.Geocoder();
		    var vm = this;
		   
			if (this.address === "-1") { return; }
			
		    geocoder.geocode({ address: this.address }, function(results, status) {
		        if (status === google.maps.GeocoderStatus.OK) {
		            vm.map.setCenter(results[0].geometry.location);
		            vm.marker.setPosition(vm.map.center);

		            if (vm.map.zoom < 15) { vm.map.setZoom(15);}
		            
		            vm.address = results[0].formatted_address;
		            vm.lat = vm.map.center.lat();
		            vm.lng = vm.map.center.lng();
		            return [vm.lat, vm.lng] ;
		        } else {
			        console.log('Hmm, had trouble finding that address');
		        }

		    });

		}, 
	},

	watch: {
		mapIsUnlocked() {
			if (!this.mapIsUnlocked) {
				this.marker.set('draggable', false);
			} else {
				google.maps.event.trigger(this.map, 'resize')
				this.marker.set('draggable', true);
				this.locateAddress();
			}
		},

		isReady() {
			if (this.isReady) { this.initMap() }
		},

		map() {
			this.submissionMapMarker(this.map);
		},

		address() {
			if (!this.mapIsUnlocked) { return; }
			google.maps.event.trigger(this.map, 'resize')
			this.locateAddress();
		},

		latLng() {
			if (this.mapIsUnlocked || 
				this.latLng.lat === undefined ||
				this.latLng.lng === undefined) { return; }
			this.locateAddress();
		},		

		editIndex() {
			google.maps.event.trigger(this.map, 'resize')
		}
	}
});