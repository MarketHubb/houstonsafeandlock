/* jQuery (Footer) */
(function($) {

    if($(window).width() <= 768){
        let customTemplate = $('.custom-template');

        if (customTemplate.length) {
            let header = $('#masthead');
            customTemplate.css('padding-top', header.height());
        }
    }

})( jQuery );