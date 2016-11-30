jQuery(document).ready(function() {
    jQuery(document).foundation();
    jQuery('.slick').slick({
        infinite: true,
        dots: true,
        arrows: false,
        touchMove: false,
        swipeToSlide: false
    });
    jQuery('.portfolio-slider').slick({
        lazyLoad: 'ondemand',
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.portfolio-nav'
    });
    jQuery('.portfolio-nav').slick({
        lazyLoad: 'ondemand',
        slidesToShow: 6,
        slidesToScroll: 1,
        asNavFor: '.portfolio-slider',
        dots: false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3
                }
            }
        ]
    });
    jQuery( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
    jQuery('.estimate-scroll').on('click', function(){
        $('html, body').animate({
            scrollTop: $(".footer form").offset().top
        }, 2000);
    });
});