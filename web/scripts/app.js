jQuery(document).ready(function() {
    jQuery(document).foundation();

    jQuery("video").each(function() {
        var sourceFile = $(this).attr("data-src");
        jQuery(this).attr("src", sourceFile);
        this.load();
        this.play();
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