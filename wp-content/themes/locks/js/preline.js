document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        const modalTrigger = document.querySelector('[data-hs-overlay="#hs-modal-global"]');
        if (modalTrigger) {
            modalTrigger.click();
        } else {
            console.error('Modal trigger button not found');
        }
    }, 1000); // 1 second delay
});
