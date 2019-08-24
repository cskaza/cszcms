$('.carousel').carousel({interval:5000});
function ChkHideShow(id) {
    $('#' + id).toggle(200);
}
(function ($) {
    $.toggleShowPassword = function (options) {
        var settings = $.extend({
            field: "#password",
            control: "#toggle_show_password"
        }, options);

        var control = $(settings.control);
        var field = $(settings.field);

        control.bind('click', function () {
            if (control.is(':checked')) {
                field.attr('type', 'text');
            } else {
                field.attr('type', 'password');
            }
        });
    };
}(jQuery));