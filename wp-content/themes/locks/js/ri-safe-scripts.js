/* jQuery (Footer) */
(function($) {

    // Custom Bootstrap modal with Gravity form
    $('#productModal').on('show.bs.modal', function (event) {
        let modal = $(this);
        let button = $(event.relatedTarget);
        let safeType = button.data('safetype')
        let safeName = button.data('safename')
        let safeImage = button.data('safeimage')
        let productField = $('#gform_1').find('.product-field textarea');

        productField.val(safeName);
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