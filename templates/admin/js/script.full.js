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
$(function () {
    $(".ui-sortable").sortable({
        cursor: 'move',
        placeholder: "ui-state-highlight"
    });
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
    return baseUrl.replace('admin','');
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
        plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table contextmenu directionality emoticons paste textcolor glyphicons b_button jumbotron row_cols boots_panels boot_alert form_insert",
        toolbar1: "insertfile undo redo | styleselect fontselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage",
        toolbar2: "forecolor backcolor emoticons | glyphicons b_button jumbotron row_cols boots_panels boot_alert form_insert",
        style_formats: [
            { title: 'Text', items: [
                {title: 'Muted text', inline: 'span', classes: 'text-muted'},
                {title: 'Primary text', inline: 'span', classes: 'text-primary'},
                {title: 'Success text', inline: 'span', classes: 'text-success'},
                {title: 'Info text', inline: 'span', classes: 'text-info'},
                {title: 'Warning text', inline: 'span', classes: 'text-warning'},
                {title: 'Danger text', inline: 'span', classes: 'text-danger'},
                {title: 'Badges', inline: 'span', classes: 'badge'}
            ] },
            { title: 'Label', items: [
                {title: 'Default Label', inline: 'span', classes: 'label label-default'},
                {title: 'Primary Label', inline: 'span', classes: 'label label-primary'},
                {title: 'Success Label', inline: 'span', classes: 'label label-success'},
                {title: 'Info Label', inline: 'span', classes: 'label label-info'},
                {title: 'Warning Label', inline: 'span', classes: 'label label-warning'},
                {title: 'Danger Label', inline: 'span', classes: 'label label-danger'}
            ] },
            { title: 'Headers', items: [
                { title: 'h1', block: 'h1' },
                { title: 'h2', block: 'h2' },
                { title: 'h3', block: 'h3' },
                { title: 'h4', block: 'h4' },
                { title: 'h5', block: 'h5' },
                { title: 'h6', block: 'h6' }
            ] },
            { title: 'Blocks', items: [
                { title: 'p', block: 'p' },
                { title: 'div', block: 'div' },
                { title: 'pre', block: 'pre' }
            ] },
            { title: 'Containers', items: [
                { title: 'section', block: 'section', wrapper: true, merge_siblings: false },
                { title: 'article', block: 'article', wrapper: true, merge_siblings: false },
                { title: 'blockquote', block: 'blockquote', wrapper: true },
                { title: 'hgroup', block: 'hgroup', wrapper: true },
                { title: 'aside', block: 'aside', wrapper: true },
                { title: 'figure', block: 'figure', wrapper: true }
            ] }
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
$('#popover').popover();