function ChkAllDelete() {
    $('.CheckBoxDelete').attr('checked', 'checked');
}
$(".keypress-number").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
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
$(function () {
    $(".ui-sortable").sortable({
        cursor: 'move',
        placeholder: "ui-state-highlight"
    });
    /*$( ".ui-sortable" ).disableSelection();*/
    $("#sel-chkbox-all").change(function () {
        $(".selall-chkbox").prop('checked', $(this).prop("checked"));
    });
});
function getPathLvl1(file_path){
    var baseUrl;
    var curPath = location.pathname;
    var pathLvl1 = curPath.replace(file_path, '');
    var n = pathLvl1.search('/');
    if (n >= 0) {
        var pathArray = pathLvl1.split( '/' );
        baseUrl = location.protocol + '//' + location.host + '/' + pathArray[1];
    } else {
        baseUrl = location.protocol + '//' + location.host;
    }
    return baseUrl;
}
$(function () {
    var baseUrl = getPathLvl1('templates/admin/js/script.js');
    tinymce.init({
        selector: '.body-tinymce',
        height: '500px',
        content_css: [
            baseUrl + '/assets/css/bootstrap.min.css',
            baseUrl + '/templates/admin/css/dashboard.css',
            baseUrl + '/templates/admin/css/styles.css',
            baseUrl + '/assets/font-awesome/css/font-awesome.min.css'
        ],
        convert_urls : false,
        extended_valid_elements : "*[*]",
        valid_elements: "*[*]",
        plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table contextmenu directionality emoticons paste textcolor glyphicons b_button jumbotron row_cols boots_panels",
        toolbar1: "insertfile undo redo | styleselect fontselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage",
        toolbar2: "forecolor backcolor emoticons | glyphicons b_button jumbotron row_cols boots_panels",
        style_formats: [
            {title: 'Muted text', inline: 'span', classes: 'text-muted'},
            {title: 'Primary text', inline: 'span', classes: 'text-primary'},
            {title: 'Success text', inline: 'span', classes: 'text-success'},
            {title: 'Info text', inline: 'span', classes: 'text-info'},
            {title: 'Warning text', inline: 'span', classes: 'text-warning'},
            {title: 'Danger text', inline: 'span', classes: 'text-danger'},
            {title: 'H1 header', block: 'h1'},
            {title: 'H2 header', block: 'h2'},
            {title: 'H3 header', block: 'h3'},
            {title: 'H4 header', block: 'h4'},
            {title: 'H5 header', block: 'h5'},
            {title: 'H5 header', block: 'h6'}
        ]
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

