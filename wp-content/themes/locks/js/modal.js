document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('hs-full-screen-modal-below-md');
    const buttonContainer = document.querySelector('.product-cta-buttons');


    function setModalAttributes() {
        const title = this.getAttribute('data-title');
        const callout = this.getAttribute('data-callout');
        const image = this.getAttribute('data-image');

        // Get the modal container
        const modal = document.querySelector('#hs-full-screen-modal-below-md');

        if (modal) {
            // Find and update the title element
            const titleEl = modal.querySelector('[data-type="title"]');
            if (titleEl && title) {
                titleEl.textContent = title;
            }

            // Find and update the callout element
            const calloutEl = modal.querySelector('[data-type="callout"]');
            if (calloutEl && callout) {
                calloutEl.textContent = callout;
            }

            // Find and update the image element
            const imageEl = modal.querySelector('[data-type="image"]');
            if (imageEl && image) {
                imageEl.setAttribute('src', image);
            }
        }
    }

    if (!buttonContainer) {
        const buttonEls = document.querySelectorAll('button.locksmith-cta');

        buttonEls.forEach((button, index) => {
            button.addEventListener('click', setModalAttributes.bind(button));
        });
    }

    if (buttonContainer) {
        // Add click event listeners to all buttons within the container
        const buttons = buttonContainer.querySelectorAll('button');

        buttons.forEach(button => {
            button.addEventListener('click', setModalAttributes.bind(button));
            // button.addEventListener('click', function () {
                // Get data attributes from clicked button
                // const title = this.getAttribute('data-title');
                // const callout = this.getAttribute('data-callout');
                // const image = this.getAttribute('data-image');

                // // Get the modal container
                // const modal = document.querySelector('#hs-full-screen-modal-below-md');

                // if (modal) {
                //     // Find and update the title element
                //     const titleEl = modal.querySelector('[data-type="title"]');
                //     if (titleEl && title) {
                //         titleEl.textContent = title;
                //     }

                //     // Find and update the callout element
                //     const calloutEl = modal.querySelector('[data-type="callout"]');
                //     if (calloutEl && callout) {
                //         calloutEl.textContent = callout;
                //     }

                //     // Find and update the image element
                //     const imageEl = modal.querySelector('[data-type="image"]');
                //     if (imageEl && image) {
                //         imageEl.setAttribute('src', image);
                //     }
                // }
            // });
        });
    }

    // Function to handle modal opening
    function handleModalOpen() {
        // Get the product input field
        const productInput = document.getElementById('input_7_1');
        if (!productInput) return;

        // Get product name and set input value
        // const productName = getProductName();
        // productInput.value = productName;

        // Disable the input
        // productInput.disabled = true;
        productInput.readOnly = true;

        // Optional: Add visual indication that field is disabled
        productInput.classList.add('!bg-gray-50', '!cursor-not-allowed');
    }

    // Watch for modal visibility changes
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.target.classList.contains('opened')) {
                console.log("mutation observer");
                handleModalOpen();
            }
        });
    });

    // Start observing the modal for class changes
    observer.observe(modal, {
        attributes: true,
        attributeFilter: ['class']
    });
});
