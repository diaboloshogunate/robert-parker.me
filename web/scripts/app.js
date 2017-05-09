(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-98710706-2', 'auto');
ga('send', 'pageview');

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