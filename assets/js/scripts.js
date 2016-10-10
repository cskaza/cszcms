$('.carousel').carousel({
    interval: 5000 //changes the speed
});
function ChkHideShow(id) {
    $('#' + id).toggle(200);
}