$('.carousel').carousel({
    interval: 5000 //changes the speed
});
$('#validate-form').validator();
function ChkHideShow(id) {
    $('#' + id).toggle(200);
}