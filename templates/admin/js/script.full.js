function ChkAllDelete() {
    $('.CheckBoxDelete').attr('checked', 'checked');
}
$(".keypress-number").keypress(function (e) {
    /* if the letter is not digit then display error and don't type anything */
    /* Number and dot only */
    if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57)) {
        /* display error message */
        return false;
    }
});
function ChkHideShow(id) {
    $('#' + id).toggle(200);
}
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
            if(this.id == "start_date" || this.id == "end_date"){
                dates.not(this).datepicker("option", option, date);
            }
        }
    });
});
$(function () {
    $(".ui-sortable").sortable({
        cursor: 'move',
        placeholder: "ui-state-highlight"
    });
    $("#sel-chkbox-all").change(function () {
        $(".selall-chkbox").prop('checked', $(this).prop("checked"));
    });
    $("#sel-chkbox-all1").change(function () {
        $(".selall-chkbox1").prop('checked', $(this).prop("checked"));
    });
    $("#sel-chkbox-all2").change(function () {
        $(".selall-chkbox2").prop('checked', $(this).prop("checked"));
    });
    $("#sel-chkbox-all3").change(function () {
        $(".selall-chkbox3").prop('checked', $(this).prop("checked"));
    });
    $("#sel-chkbox-all4").change(function () {
        $(".selall-chkbox4").prop('checked', $(this).prop("checked"));
    });
    $("#sel-chkbox-all5").change(function () {
        $(".selall-chkbox5").prop('checked', $(this).prop("checked"));
    });
});
$(function()
{
    $(document).on('click', '.btn-fields-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.addfields'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-fields-add')
            .removeClass('btn-fields-add').addClass('btn-fields-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-fields-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
});