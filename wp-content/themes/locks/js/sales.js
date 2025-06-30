document.addEventListener('DOMContentLoaded', function () {
    // Wait for Preline to be fully loaded
    function initModal() {
        // Check if HSOverlay is available and the modal element exists
        if (typeof HSOverlay !== 'undefined' && document.querySelector('#hs-modal-global')) {
            // Use HSOverlay.getInstance to get existing instance or create new one
            // let modal = HSOverlay.getInstance('#hs-modal-global');
            const modalElement = document.querySelector('#hs-modal-global');
            console.log("Modal element found:", modalElement);
            console.log("Modal element classes:", modalElement?.className);
            
            const modal = new HSOverlay(modalElement);
            
            console.log("modal", modal);
            console.log("modal.open exists?", typeof modal.open);
            console.log("modal properties:", Object.keys(modal));
            
            // Small delay to ensure DOM is ready
            setTimeout(() => {
                console.log("Attempting to open modal...");
                if (modal && typeof modal.open === 'function') {
                    modal.open();
                    console.log("Modal open() called successfully");
                } else {
                    console.error("Modal does not have open method or is invalid", modal);
                    
                    // Fallback: Try to trigger the button click
                    console.log("Trying fallback: triggering button click");
                    const openBtn = document.querySelector('#open-btn-sale');
                    if (openBtn) {
                        openBtn.click();
                        console.log("Button clicked");
                    } else {
                        console.error("Button not found");
                    }
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
