$(document).ready(function() {
    // Show/Hide navigation
    $('a.shownav').on('click', function() {
        $('nav.headernav').slideDown();
        $(this).next('a.hidenav').fadeIn();
        $(this).hide();
    });

    $('a.hidenav').on('click', function() {
        $('nav.headernav').fadeOut();
        $(this).prev('a.shownav').fadeIn();
        $(this).hide();
    });

    // Collapse navigation on mobile after clicking a menu item
    var setscreen_width = $(window).width();
    if (setscreen_width < 1100) {
        $('nav ul li').on('click', function() {
            $('nav.headernav').fadeOut('slow');
            $('a.hidenav').hide();
            $('a.shownav').fadeIn();
        });
    }

    // Sticky header on scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 100) {
            $('header').addClass('fixed');
        } else {
            $('header').removeClass('fixed');
        }
    });

    // Initialize Owl Carousel
    $('.owl-carousel').owlCarousel({
        autoplay: true,
        autoplayTimeout: 4000,
        slideTransition: 'ease',
        autoplayHoverPause: true,
        loop: true,
        margin: 55,
        nav: false,
        dots: false,
        responsive: {
            0: { items: 1 },
            440: { items: 2 },
            690: { items: 3 },
            1240: { items: 4 }
        }
    });

    // Initialize Datepicker
    $("#datepicker").datepicker({
        minDate: 0,
        maxDate: "+1M +10D",
        dateFormat: 'DD, d MM, yy'
    });
});
