/**
 * [menuTreeToggler description]
 * @param  {string} label    Selector for the toggler "button"
 * @param  {string} nested_ul
 */
export const menuTreeToggler = function(label, nested_ul, arrow) {
	let toplevel = $(label)
	toplevel.off('click');
	toplevel.click(function () {
		let $this = $(this);
	    $this.parent().children(nested_ul).toggle(300);
	    if (arrow) {
	    	$this.find(arrow).toggleClass('flip')
	    }

	});
};
