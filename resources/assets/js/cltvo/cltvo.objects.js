var cltvo = {};

/**
 * Returns true if value is contained in array
 *
 * @type {string}
 */
cltvo.array = {
	has: function(value, array) {
		if (array.indexOf(value) > -1) {
			return true;
		}
		return false;
	},

	runFuncs: function(fn, func_array) {
		func_array.map(function(fn) {
			fn();
		});
	}
};

cltvo.math = {
	hypothenuse: function(x, y) {
	    return Math.sqrt(Math.pow((x), 2)+Math.pow((y),2));
	},

	norm: function(x2, x1, y2, y1) {
	    return Math.sqrt(Math.pow((x2 - x1), 2)+Math.pow((y2 - y1),2));
	}
};

cltvo.physics = {
	speedToSecs: function() {

	}
};

cltvo.svg = {
	lineLength: function(el){
	    var x1 = el.attr('x1');
	    var x2 = el.attr('x2');
	    var y1 = el.attr('y1');
	    var y2 = el.attr('y2'),
	    x = x2 - x1,
	    y = y2 - y1;
	    return cltvo.math.hypothenuse(x, y);
	},

	 /**
	 *
	 * Used to get the length of a line
	 *
	 * @param el is the line element ex $('.line')
	 * @return the length of the line in px
	 */
	polylineLength: function(elem) {
		var points = elem[0].animatedPoints,
			len = 0,
			i,
			points_arr;

		if (! points[0]) {//if the browser does not provide an SVGPoints object with the coordenates. e.g. Safari
			points_arr = elem[0].attributes.points.value.trim().replace(/\s/g, ',');
			points_arr = points_arr.split(',');
			var pushPoints = function(arr) {
				var j,
					k = 0;
				for (j = 0; j < arr.length; j+=2) {
					points[k] = {};
					points[k].x = arr[j];
					points[k].y = arr[j+1];
					k += 1;
					points.length = k;
				}
			}(points_arr);
		}

		for (i = 1; i < points.length; i += 1 ) {
			len += cltvo.math.norm(points[i].x, points[i-1].x, points[i].y, points[i-1].y);
		}

		return len;
	},

	rectLength:function(elem){
        var w = elem.attr('width');
        var h = elem.attr('height');

        return (w*2)+(h*2);
    }

};

cltvo.prepender = function($) {
	return {
		default_sibling: '',
		/**
		 * Prepends an element above the main text content of the row.
		 * @param  {[string]} elem    element id
		 * @param  {string} sibiling the maincontent
		 */
		_prepend: function(elem, sibling) {
			 sibling = sibling || this.default_sibling;
			 elem = $(elem);
			elem.prependTo(sibling);
			console.log(sibling);
		},

		prepend: function(elem, sibling) {
			if ($(window).width() <= 1020) {
				this._prepend(elem, sibling);
			}
		},

		prependElems: function(elemsArr, sibling) {
			var i;
			if ($(window).width() <= 1020) {
				for (i = 0; i < elemsArr.length; i++) {
					this._prepend(elemsArr[i]);
				}
			}
		}
	};
}(jQuery);

cltvo.positions = function($){
	return {
		calcYInDiv: function(container, left_pos) {
			var w_width = jQuery(window).width(),
				container_width = jQuery(container).width(),
				margs = w_width - container_width,
				neg_offset = margs/2;
			return {
				left: left_pos - neg_offset,
				container_width: container_width
			};
		},
	}
}(jQuery);

cltvo.leerMas = function($) {
	return {
		ancla_positioner: $('.leer-mas__positioner_JS'),
		ancla: $('.leer-mas_JS'),
		container: $('.leer-mas__container_JS'),

		init: function() {
			this.initialHeight();
			this.toggle();
		},

		initialHeight: function() {
			var	ancla,
				self = this,
				position,
				id,
				container;

			return this.ancla.each( function() {
				ancla = $(this);
				ancla_positioner = $(this).closest('.leer-mas__positioner_JS');
				position = self.anclaPosition(ancla_positioner);
				container = ancla.closest('.leer-mas__container_JS');
				container.height(position + 17 + 17);
				console.log(ancla_positioner);
				return ancla;
			});
		},

		anclaPosition: function(positioner) {
			return positioner.position().top;
		},

		toggle: function() {
			var	ancla,
				self = this,
				position,
				id,
				container,
				container_height,
				initial_height;

			this.ancla.on('click', function(e) {
				e.stopPropagation();
				ancla_positioner = $(this).closest('.leer-mas__positioner_JS');
				container = $(this).closest('.leer-mas__container_JS');
				position = self.anclaPosition(ancla_positioner);
				if ( ! container.hasClass('isOpen') ) {
					container.height('auto');
					container.addClass('isOpen');
					$(this).find('.leer-mas__text_JS').html('leer menos');
					$(this).find('.noticias__flecha-link').addClass('flip');
					return;
				} else {
					container.height(position + 37);
					container.removeClass('isOpen');
					$(this).find('.leer-mas__text_JS').html('Leer Mas');
					$(this).find('.noticias__flecha-link').removeClass('flip');
					return;
				}
			});
		}

	};
}(jQuery);

cltvo.debounce = function (func, wait, immediate) {
	var timeout;
	return function() {
		console.log(callNow);
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

cltvo.isMobile = function() {
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		return true;
	}
	return false;
};

