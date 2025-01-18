document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('gform_7');
    const modal = document.getElementById('hs-full-screen-modal-below-md');
    const formFooter = document.querySelector('#gform_7 .gform-footer');
    const buttonContainer = document.querySelector('.product-cta-buttons');
    
    if (buttonContainer) {
        // Add click event listeners to all buttons within the container
        const buttons = buttonContainer.querySelectorAll('button');
        
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                // Get data attributes from clicked button
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
                    console.log(imageEl); 
                    if (imageEl && image) {
                        imageEl.setAttribute('src', image);
                    }
                }
            });
        });
    }
    
    if (formFooter) {
        // 1. Create a new div to wrap the inputs
        const inputWrapper = document.createElement('div');
        inputWrapper.className = 'flex-1 w-full sm:w-fit';
        
        // Move all existing inputs into the new wrapper
        const inputs = [...formFooter.getElementsByTagName('input')];
        inputs.forEach(input => {
            inputWrapper.appendChild(input);
        });
        
        // 2. Create the sibling div with the message
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex-1 order-last sm:order-first';
        messageDiv.innerHTML = `
        <p class="relative text-sm text-pretty sm:text-base antialiased !leading-tight text-gray-500 tracking-tight">A team member will respond <span class="underline font-semibold">today</span> with everything you need to order this safe</p>`;
        // <p class="relative text-sm sm:text-base antialiased !leading-tight tracking-tight">Our team will review your information & respond <span class="underline font-semibold">today</span> with everything you need to order this safe</p>`;
        
        // 3. Add the flex classes to the footer
        formFooter.className += ' flex flex-col sm:flex-row w-full items-center gap-y-6 sm:gap-x-8 !pt-8 sm:!pt-12 sm:!mt-12 sm:border-t sm:!border-gray-200';
        
        // Clear the footer's existing content and append the new elements
        formFooter.innerHTML = '';
        formFooter.appendChild(inputWrapper);
        formFooter.appendChild(messageDiv);
    }


    // Show/hide form inputs on change (7_3)
    // Get all radio inputs in field 7_3
    const radioInputs = form.querySelectorAll('[name="input_3"]');
    
    // Get the section field elements
    const sectionTitle = document.querySelector('#field_7_9 h3');
    const sectionDescription = document.querySelector('#field_7_9 p');
    
    // Function to show hidden fields
    function showHiddenFields() {
        const hiddenFields = form.querySelectorAll('.hidden.opacity-0');
        hiddenFields.forEach(field => {
            field.classList.remove('hidden', 'opacity-0');
            field.classList.add('opacity-100');
        });
    }

    // Add change event listener to radio inputs
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function (e) {
            if (this.checked) {
                // Get the parent label element
                const label = this.closest('label');
                
                // Get the value and description
                const value = label.querySelector('[data-type="value"]').textContent;
                const description = label.querySelector('[data-type="description"]').textContent;
                
                // Update the section content
                sectionTitle.textContent = value;
                sectionDescription.textContent = description;
                
                // Show remaining fields with animation
                setTimeout(showHiddenFields, 300);
            }
        });
    });
    
    // Function to get product name from H1
    function getProductName() {
        const h1 = document.querySelector('h1');
        if (!h1) return '';
        
        // Get all text content, split by the span, and get the last part
        const spanText = h1.querySelector('span')?.textContent || '';
        return h1.textContent.replace(spanText, '').trim();
    }
    
    // Function to handle modal opening
    function handleModalOpen() {
        // Get the product input field
        const productInput = document.getElementById('input_7_1');
        if (!productInput) return;
        
        // Get product name and set input value
        const productName = getProductName();
        productInput.value = productName;
        
        // Disable the input
        productInput.disabled = true;
        
        // Optional: Add visual indication that field is disabled
        productInput.classList.add('!bg-gray-50', '!cursor-not-allowed');
    }
    
    // Watch for modal visibility changes
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.target.classList.contains('opened')) {
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
