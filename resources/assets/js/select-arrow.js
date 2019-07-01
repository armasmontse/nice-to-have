export var selectArrow = function(selector) {
	var arrow = $('.select__arrow_JS');
	var showDropdown = function (element) {
	    var event;
	    event = document.createEvent('MouseEvents');
	    event.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
	    element.dispatchEvent(event);
	    console.log('  element.dispatchEvent(event)',   element.dispatchEvent(event));
	    console.log('element.dispatchEvent', element.dispatchEvent);
	};


	arrow.on('click', function() {
	    try {
	        showDropdown($(this).siblings('select')[0]);
	    } catch(e) {

	    }
	    return false;
	});
};
