if (window.gform) {
    gform.initializeOnLoaded(function () {
        console.log('Gravity Forms initialized');
        
        gform.utils.addFilter('gform/ajax/post_ajax_submission', (data) => {
            console.log('Submission filter triggered', data);
            
            // Get form ID from the form element
            const formId = data.form.getAttribute('data-formid');
            console.log('Form ID:', formId);
            
            if (formId === '7' && data.submissionResult.success === true) {
                const modalContent = document.getElementById('product-lead-modal');
                
                // Get the image source before replacing content
                const productImage = modalContent.querySelector('.product-modal-image img');
                const imageSrc = productImage ? productImage.getAttribute('src') : '';
                
                console.log('Modal content element:', modalContent);
                
                if (modalContent) {
                    modalContent.innerHTML = `
                    <div class="flex items-center justify-center py-12 sm:py-16 md:py-28 px-6">
                        <div class="text-center">
                            <i class="fa-light fa-badge-check text-3xl sm:text-4xl md:text-6xl lg:text-7xl !block text-green-600 mb-6"></i>
                            <div class="max-w-xl mx-auto">
                                <h1 class="text-base font-medium text-brand-500 uppercase tracking-widest">THANK YOU!</h1>
                                <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl !leading-tight">Submission Received</p>
                                <p class="mt-2 text-base md:text-lg text-gray-500 py-5">A Houston Safe & Lock team member will respond soon with everything you need.</p>
                                <img src="${imageSrc}" class="inline-block max-h-[250px] w-auto object-contain object-center mt-6" />
                            </div>
                        </div>
                    </div>
                `;

                    console.log('Content replaced');
                }
            }
            return data;
        });
    });
}
