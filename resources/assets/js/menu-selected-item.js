export var menuSelectedItem = function(selector) {
    var link = $(selector);
    link.on('click', function() {
        link.removeClass('selected');
        $(this).addClass('selected');
        console.log(link);
    });
};
