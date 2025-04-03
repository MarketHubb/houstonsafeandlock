// Single DOMContentLoaded listener that resolves multiple promises
export const domReadyPromise = new Promise(resolve => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => resolve());
    } else {
        resolve(); // DOM already loaded
    }
});

// Form promise
export const formPromise = domReadyPromise.then(() => {
    const forms = document.querySelectorAll('form[id*="gform"]');

    if (forms.length > 0) {
        return forms[0];
    } else {
        throw new Error('No Gravity Form found');
    }
});

// Modal observer promise
export const modalOpenPromise = domReadyPromise.then(() => {
    return new Promise(resolve => {
        const modal = document.getElementById('hs-full-screen-modal-below-md');

        if (!modal) {
            throw new Error('Modal element not found');
        }

        // Check if modal is already open
        if (modal.classList.contains('opened')) {
            resolve(modal);
            return;
        }

        // Set up observer for modal opening
        const observer = new MutationObserver(mutations => {
            for (const mutation of mutations) {
                if (mutation.type === 'attributes' &&
                    mutation.attributeName === 'class' &&
                    modal.classList.contains('opened')) {

                    observer.disconnect(); // Clean up observer once modal is opened
                    resolve(modal);
                    break;
                }
            }
        });

        // Start observing the modal for class changes
        observer.observe(modal, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
});