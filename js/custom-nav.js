// Sticky Header
$(window).scroll(function() {

    if ($(window).scrollTop() > 100) {
        $('.main-h').addClass('sticky');
    } else {
        $('.main-h').removeClass('sticky');
    }
});

// Mobile Navigation
$('.mobile-toggle').click(function() {
    if ($('.main-h').hasClass('open-nav')) {
        $('.main-h').removeClass('open-nav');
    } else {
        $('.main-h').addClass('open-nav');
    }
});

$('.main-h li a').click(function() {
    if ($('.main-h').hasClass('open-nav')) {
        $('.navigation').removeClass('open-nav');
        $('.main-h').removeClass('open-nav');
    }
});

// navigation scroll lijepo radi materem
$('nav a').click(function(event) {
    var id = $(this).attr("href");
    var offset = 70;
    var target = $(id).offset().top - offset;
    $('html, body').animate({
        scrollTop: target
    }, 500);
    event.preventDefault();
});
