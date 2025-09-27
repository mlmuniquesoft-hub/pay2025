(function($) {
    'use strict';

    $(window).on('load', function() {
        $('#prelaoder').fadeOut(1000);
    });

    /* ---------------------------------- dropdown manu ---------------------------- */
    var navLink = $('.dropdown-box');
    navLink.mouseenter(function() {
        $(this).find('ul').stop().slideDown().show();
    }).mouseleave(function() {
        $(this).find('ul').stop().slideUp().hide();
    });

    /* ----------------------------------- Mobile Button  ----------------------------- */

    $(".mobile-toggle").on('click', function() {
        $("#mobile-manu").removeClass('slideInRight').addClass('animated slideInLeft').show();
    });

    $(".close-mobile-manu").on('click', function(e) {
        e.preventDefault();
        $("#mobile-manu").removeClass('slideInLeft').addClass('animated slideInRight').hide();
    });

    /* ------------------------------------- tab function ---------------------------------- */
    var mapMarker = $('.map-maker'),
        countryGeter = $('.country-geter');
    countryGeter.hide();

    mapMarker.on('mouseenter', function() {
        $(this).find('.country-geter').stop().fadeIn(600);
    }).stop().on('mouseleave', function() {
        $(this).find('.country-geter').stop().fadeOut();
    });

    /* ----------------------------------- Countriess tab function ---------------------------------*/
    var tabNav = $('#tabs > li');
    tabNav.on('click', function() {
        var contentSelector = $(this).attr('data-tab');

        tabNav.removeClass('active');
        $(this).addClass('active');

        $('.tab-item').removeClass('active');
        $('.' + contentSelector).addClass('active');
    });

    /* ---------------------------------- Chart css -------------------------------- */
    $('.btcwdgt-footer').css({
        "display": "none"
    });

    /* ------------------------------------ bg img seter -------------------------------- */
    $('[data-bg-image]').each(function() {
        var img = $(this).data('bg-image');
        $(this).css({
            backgroundImage: 'url(' + img + ')',
        });
    });

    /* ---------------------- PlugIn Active ----------------------- */
    // Slider
    var presention = $('.presention-active'),
        priceTwo = $('.price-two-active'),
        banner = $('.banner-active'),
        clintLogo = $('.clint-logo-active'),
        blogSlider = $('.blog-slider-active');

    banner.owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        autoplay: false,
        autoplayTimeout: 10000,
        margin: 0,
        smartSpeed: 2000,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut'
    });
    priceTwo.owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        autoplay: true,
        smartSpeed: 1000,
        autoplaySpeed: 2000,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            },
            1300: {
                items: 6
            }
        }
    });


    // Presentation slider
    presention.owlCarousel({
        items: 1,
        loop: true,
        nav: false,
        dots: false,
        URLhashListener: true,
        startPosition: 'URLHash',
        autoplay: false,
        smartSpeed: 700,
    });

    var hashUrl = $('.hash-url > a');
    hashUrl.on('click', function() {
        hashUrl.removeClass('active');
        $(this).addClass('active');
    });

    // Clint-Logo
    clintLogo.owlCarousel({
        items: 5,
        loop: true,
        nav: false,
        dots: false,
        autoplay: true,
        smartSpeed: 1000,
        autoplaySpeed: 2000,
        responsive: {
            0: {
                items: 2
            },
            576: {
                items: 3,
                center: true,
            },
            768: {
                items: 3,
                center: true,
            },
            992: {
                items: 5,
                center: true,
            },
            1200: {
                items: 7,
                center: true,
            }
        }
    });

    // Blog slider
    blogSlider.owlCarousel({
        loop: true,
        autoplay: true,
        smartSpeed: 1000,
        autoplaySpeed: 2000,
        dots: false,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });


    /* ---------------------------------------- Counter Up ------------------------------------ */
    $('.counter').counterUp({
        delay: 20,
        time: 2500
    });

    /* --------------------------------------- Countdown ----------------------------------------- */
    $('[data-countdown]').each(function() {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span class="cdown day"> <p class="cdown-tex">Days</p><span class="time-count separator">%-D</span>  </span> <span class="cdown hour"> <p class="cdown-tex">Hours</p> <span class="time-count separator">%-H</span>  </span> <span class="cdown minutes"> <p class="cdown-tex">Minutes</p><span class="time-count separator">%M</span>  </span> <span class="cdown"> <p class="cdown-tex">Secounds</p><span class="time-count">%S</span> </span>'));
        });
    });

    /* -------------------------------------- VenoBox --------------------------------- */

    $('.venobox-video').venobox({
        autoplay: true,
        spinner: 'rotating-plane',
        spinColor: '#fab915'
    });

    /* -------------------------------------- Marquee --------------------------------- */
    $('.marquee').marquee({
        duration: 25000,
        gap: 0,
        duplicated: true,
        pauseOnHover: true,
        startVisible: true
    });

    /* ---------------------------------------------- player ----------------------------------- */
    $('.youtube-wrapper').on('click', function(event) {
        event.preventDefault();
        var fr = $(this).find('iframe');
        var fadr = $(this).find('iframe').attr('src');
        var fuadr = fadr + '?autoplay=1';

        $(this).addClass('reveal');
        fr.attr('src', fuadr);
    });

    plyr.setup();

    /* ---------------------------------------------- Pop up Chart ----------------------------------- */
    var chartPopup = $('.popup-chart');
    chartPopup.magnificPopup({
        type: 'inline',
        midClick: true,
        closeBtnInside: true
    });

    /* -------------------------------------- Widget Chart ---------------------------------------- */
    (function(b, i, t, C, O, I, N) {
        window.addEventListener('load', function() {
            if (b.getElementById(C)) return;
            I = b.createElement(i), N = b.getElementsByTagName(i)[0];
            I.src = t;
            I.id = C;
            N.parentNode.insertBefore(I, N);
        }, false)
    })(document, 'script', 'https://widgets.bitcoin.com/widget.js', 'btcwdgt');
}(jQuery));