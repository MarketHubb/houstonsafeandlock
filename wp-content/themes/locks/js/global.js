/* jQuery (Footer) */
(function($) {

    // Search
    $('#searchform').on('submit', function(e) {
       let searchInput = $(this).find('input.search-field');
       if (searchInput.val().length === 0) {
           e.preventDefault();
       }
    });

    if($(window).width() <= 768){

        // Auto-fob link
        let mobileMenu = $('header.site-header div#brand-info div.container-fixed div#menu-responsive div#menu-responsive-container > div.menu-primary-menu-container ul.menu');

        let mobileLinks = $('header.site-header div#brand-info div.container-fixed div#menu-responsive div#menu-responsive-container > div.menu-primary-menu-container ul.menu > li');

        let fobLink = mobileLinks.last().clone();
        fobLink.find('a')
            .attr('href', 'https://www.autofobs.com/?ref=44&locid=18451')
            .text('Auto Remotes');

        mobileMenu.append(fobLink);

        //---------------------------

        let customTemplate = $('.custom-template');

        if (customTemplate.length) {
            let header = $('#masthead');
            customTemplate.css('padding-top', header.height());
        }
    }

})( jQuery );