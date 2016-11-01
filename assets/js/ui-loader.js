$(".keypress-number").keypress(function (e) {
    /* Number and dot only */
    if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57)) {
        return false;
    }
});
$(function () {
    var dates = $('.form-datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        numberOfMonths: 1,
        changeMonth: true,
        changeYear: true,
        onSelect: function (selectedDate) {
            var option = this.id == "start_date" ? "minDate" : "maxDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings
                            );
            dates.not(this).datepicker("option", option, date);
        }
    });
});