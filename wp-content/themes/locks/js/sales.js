document.addEventListener('DOMContentLoaded', function () {
    // Wait for Preline to be fully loaded
    function initModal() {
        // Check if HSOverlay is available and the modal element exists
        if (typeof HSOverlay !== 'undefined' && document.querySelector('#hs-modal-global')) {
            // Use HSOverlay.getInstance to get existing instance or create new one
            // let modal = HSOverlay.getInstance('#hs-modal-global');
            const modal = new HSOverlay(document.querySelector('#hs-modal-global'));
            
            if (!modal) {
                // If no instance exists, create one
                modal = new HSOverlay(document.querySelector('#hs-modal-global'));
            }
            
            console.log("modal", modal);
            
            // Small delay to ensure DOM is ready
            setTimeout(() => {
                console.log("Attempting to open modal...");
                if (modal && typeof modal.open === 'function') {
                    modal.open();
                    console.log("Modal open() called successfully");
                } else {
                    console.error("Modal does not have open method or is invalid", modal);
                }
            }, 100);
            
            const openBtn = document.querySelector('#open-btn-sale');
        } else {
            // If HSOverlay is not ready, try again in 100ms
            console.log("HSOverlay not ready, retrying in 100ms...");
            setTimeout(initModal, 100);
        }
    }
    
    // Start initialization
    console.log("=== SALES.JS LOADED - Starting modal initialization ===");
    initModal();
});
