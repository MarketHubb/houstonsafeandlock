/* jQuery (Footer) */
(function ($) {
    // Featured
    const pageId = $('#page').data('pageid');
    let targetEl = null;

    if (pageId === 7948) {
        targetEl = $('.hero-home');
    }  
    if (pageId === 3901) {
        targetEl = $('.safe-categories-container')
    }
    let featuredHome = $('#featured-safe-home');

    if (featuredHome.length > 0 && targetEl.length === 1) {
        featuredHome.insertAfter(targetEl);
    }



    // Search
    $('#searchform').on('submit', function (e) {
        let searchInput = $(this).find('input.search-field');
        if (searchInput.val().length === 0) {
            e.preventDefault();
        }
    });

    $(window).load(function () {
        let saleModal = $('#popupModal');
        if (saleModal.length > 0) {
            const myModal = new bootstrap.Modal(document.getElementById('popupModal'), {
                keyboard: false
            })

            myModal.show();

            $('#popupModal .close, #popupModal .close > span').on('click', function () {
                myModal.hide();
            });

        }
    });

    if ($(window).width() <= 768) {

        

        // Mobile search
        const search = $('#searchform');
        const menu = $('#primary-menu');

        if (search.length >= 1) {
            search.insertBefore(menu);
        }

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

})(jQuery);