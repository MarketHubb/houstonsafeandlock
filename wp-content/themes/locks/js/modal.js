document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('hs-full-screen-modal-below-md');
    const buttonContainer = document.querySelector('.product-cta-buttons');
    const buttonEls = document.querySelectorAll('button.locksmith-cta');
    const usedButtonEls = document.querySelectorAll('.used-btn');

    const isModal = () => document.querySelector('#hs-full-screen-modal-below-md') ? true : false;

    function setModalFormProductVal(title)
    {
        console.log("title",title);
        if (isModal()) {
            const productInput = document.getElementById('input_7_1');
            if (productInput && title) {
                productInput.value = title;
            }
        }
    }

    function setModalValues(title, callout, image) {
        // Get the modal container
        if (isModal()) {
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

    function getModalAttributeValues(button, event) {
        const title = button.getAttribute('data-title');
        const callout = button.getAttribute('data-callout');
        const image = button.getAttribute('data-image');

        setModalValues(title, callout, image);
    }

    usedButtonEls.forEach(btn => {
        btn.addEventListener('click', () => {
            const callout = btn.getAttribute('data-callout');
            const usedContainer = btn.closest('.used-container');

            if (!usedContainer) return;

            const titleEl = usedContainer.querySelector('h2');
            const title = titleEl ? titleEl.textContent.trim() : '';

            const imageEl = usedContainer.querySelector('.used-img-container img');
            const image = imageEl ? imageEl.src : '';

            if (title) {
                setModalFormProductVal(title);
            }

            setModalValues(title, callout, image);
        });
    });

    // Locksmith pages
    if (!buttonContainer && buttonEls) {
        console.log("locksmith page");

        const buttonEls = document.querySelectorAll('button.locksmith-cta');

        buttonEls.forEach((button, index) => {
            button.addEventListener('click', event => {
                getModalAttributeValues(button, event);
            });
        });
    }

    // Used safe page


    // Safe page
    if (buttonContainer) {
        console.log("safe page");

        // Add click event listeners to all buttons within the container
        const buttons = buttonContainer.querySelectorAll('button');

        buttons.forEach(button => {
            button.addEventListener('click', event => {
                getModalAttributeValues(button, event);
            });
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
