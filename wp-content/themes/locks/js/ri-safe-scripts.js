/* jQuery (Footer) */
(function($) {

    function triggerKeypress(el) {
        el.keydown();
        el.keypress();
        el.keyup();
        el.blur();
    }

    function bitrixForm() {
        let safeName = $('h1.product-detail-heading').text().trim();
        let currentURL = window.location.href;
        let bitrixFormInputs = $('.b24-form form input');
        let safeField = bitrixFormInputs.last();


        if (safeField.length === 1) {
            triggerKeypress(safeField);

            safeField.on('keypress', function(){
                console.log("pressed!");
            });

            safeField.val(safeName).trigger(jQuery.Event('keypress', {keycode: 13}));
            safeField.addClass('b24-form-control-not-empty');
        }
    }

    $(window).load(function() {

        bitrixForm();


        $('#specs table tbody tr').each(function() {
            if ($(this).find('th').text() === 'Burglary Protection (Safe Rating)') {
                var rating = $(this).find('td').text();
                if (rating.length) {
                    $('.card .burglary_rating').text(rating);
                }
            }

        });
    });

    // Prevent default WP image thumbnail click event
    $('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:nth-of-type(2)').addClass('active-thumb');
    
    $('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:not(:first-of-type) a').each(function() {
        let anchorSrc = $(this).attr('href');
        $(this).find('img')
            .attr('src', anchorSrc)
            .attr('srcset', anchorSrc);
    });

    $('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image a').on('click', function(event){
        event.preventDefault();

        $('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image').each(function() {
           $(this).removeClass('active-thumb');
        });

        $(this).closest('.woocommerce-product-gallery__image').addClass('active-thumb');

        let activeSrc = $(this).find('img').attr('srcset');
        $('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:first-of-type img')
            .attr('srcset', activeSrc);

    });

    // Custom Bootstrap modal with Gravity form
    $('#productModal').on('show.bs.modal', function (event) {
        let modal = $(this);
        let button = $(event.relatedTarget);
        let safeType = button.data('safetype')
        let safeName = button.data('safename')
        let safeImage = button.data('safeimage')

        var formId = (typeof button.data('safeformid') !== 'undefined') ? button.data('safeformid') : 1;

        let productField = $('#gform_' + formId).find('.product-field textarea');

        productField.val(safeName);
        productField.addClass('fw-normal');
        modal.find('.modal-subtitle').text(safeType + ' Product Inquiry');
        modal.find('.modal-image').attr('src', safeImage);

    });

    //-----------------------------------------------------
    // Google Analytics
    //-----------------------------------------------------

    // Custom event: Hours & Directions button in alert bar
    $('.safes-alert-btn').on('click', function() {
        ga('send', 'event', 'Link', 'Click', 'Hours & Directions');
    });

})( jQuery );