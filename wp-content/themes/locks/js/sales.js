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
            
            // Increased delay to ensure all Preline initialization is complete
            setTimeout(() => {
                console.log("Attempting to open modal...");
                if (modal && typeof modal.open === 'function') {
                    modal.open();
                    console.log("Modal open() called successfully");
                    
                    // Check if modal is actually visible after opening
                    setTimeout(() => {
                        const modalEl = document.querySelector('#hs-modal-global');
                        console.log("Modal visibility check:");
                        console.log("- Element exists:", !!modalEl);
                        console.log("- Has 'hidden' class:", modalEl?.classList.contains('hidden'));
                        console.log("- Has 'open' class:", modalEl?.classList.contains('open'));
                        console.log("- Display style:", window.getComputedStyle(modalEl).display);
                        console.log("- Visibility style:", window.getComputedStyle(modalEl).visibility);
                        console.log("- Modal element classes:", modalEl?.className);
                        
                        // If still hidden, try manual approach
                        if (modalEl?.classList.contains('hidden')) {
                            console.log("Modal still hidden, trying manual approach...");
                            
                            // Manual approach to show modal
                            modalEl.classList.remove('hidden');
                            modalEl.classList.add('open', 'opened');
                            modalEl.style.display = 'block';
                            
                            // Create and show backdrop
                            let backdrop = document.querySelector('.hs-overlay-backdrop');
                            if (!backdrop) {
                                backdrop = document.createElement('div');
                                backdrop.className = 'hs-overlay-backdrop transition duration fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 dark:bg-neutral-900';
                                backdrop.style.zIndex = '79';
                                document.body.appendChild(backdrop);
                                console.log("Backdrop created");
                            }
                            
                            // Prevent body scroll
                            document.body.style.overflow = 'hidden';
                            
                            console.log("Manual modal display attempted");
                            console.log("- New classes:", modalEl.className);
                            console.log("- New display style:", modalEl.style.display);
                        }
                    }, 500);
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
            }, 500); // Increased from 100ms to 500ms
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
