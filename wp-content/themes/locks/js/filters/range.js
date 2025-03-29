document.addEventListener('DOMContentLoaded', function () {
    // Get the main slider container
    const sliderContainer = document.getElementById('filter-sliders');

    if (!sliderContainer) {
        console.error('Slider container not found');
        return;
    }

    // Function to get slider value for a specific slider and update target span
    function getSliderValue(slider) {
        // Find the parent container with data-filter-group
        const filterGroupContainer = slider.closest('[data-filter-group]');
        if (!filterGroupContainer) return null;

        // Get the filter group name
        const groupName = filterGroupContainer.getAttribute('data-filter-group');

        // Get the current value from the handle
        const handle = slider.querySelector('.noUi-handle');
        if (!handle) return null;

        const value = parseInt(handle.getAttribute('aria-valuenow'), 10);

        // Update the target span if it exists
        // First, try to find a target with the slider's ID pattern
        const sliderId = slider.id;
        if (sliderId) {
            const targetSpan = document.getElementById(`${sliderId}-target`);
            if (targetSpan) {
                targetSpan.textContent = value;
                console.log(`Updated ${sliderId}-target to ${value}`);
            }
        }

        // Also try with the filter group name pattern as fallback
        const groupTargetSpan = document.getElementById(`hs-${groupName}-target`);
        if (groupTargetSpan) {
            groupTargetSpan.textContent = value;
            console.log(`Updated hs-${groupName}-target to ${value}`);
        }

        // Return the slider state object
        return {
            type: groupName,
            selected: value
        };
    }

    // Direct approach: manually attach to noUiSlider instances
    function setupNoUiSliderListeners() {
        const sliders = sliderContainer.querySelectorAll('.filter-range-slider');

        sliders.forEach(slider => {
            console.log(`Setting up listeners for slider: ${slider.id || 'unnamed'}`);

            // Check if noUiSlider instance exists on this element
            if (slider.noUiSlider) {
                console.log('noUiSlider instance found, attaching events');

                // Listen for the 'update' event which fires after the slider value is updated
                slider.noUiSlider.on('update', function(values, handle) {
                    const value = parseInt(values[handle], 10);
                    console.log(`Slider updated: ${value}`);

                    // Update the value display
                    const sliderValue = getSliderValue(slider);
                    if (sliderValue) {
                        console.log('Range slider updated:', sliderValue);
                    }
                });

                // Also listen for the 'change' event which fires when user stops interacting
                slider.noUiSlider.on('change', function(values, handle) {
                    const value = parseInt(values[handle], 10);
                    console.log(`Slider changed: ${value}`);

                    // Update the value display
                    const sliderValue = getSliderValue(slider);
                    if (sliderValue) {
                        console.log('Range slider changed:', sliderValue);
                    }
                });
            } else {
                console.log('No noUiSlider instance found on this element yet');
            }
        });
    }

    // Try to set up listeners immediately
    setupNoUiSliderListeners();

    // Also try again after a short delay to ensure noUiSlider is initialized
    setTimeout(setupNoUiSliderListeners, 500);

    // As a fallback, use MutationObserver to detect when noUiSlider might be initialized
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' &&
                mutation.target.classList.contains('filter-range-slider') &&
                mutation.target.classList.contains('noUi-target')) {

                console.log('Slider appears to be initialized, setting up listeners');
                setupNoUiSliderListeners();
            }
        });
    });

    // Start observing the slider container for attribute changes
    observer.observe(sliderContainer, {
        attributes: true,
        subtree: true,
        attributeFilter: ['class']
    });

    console.log('Range slider handler setup complete');
});
