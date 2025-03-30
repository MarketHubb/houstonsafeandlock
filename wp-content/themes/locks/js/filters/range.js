document.addEventListener('DOMContentLoaded', function () {
    // Get the main slider container
    const sliderContainer = document.getElementById('filter-sliders');

    if (!sliderContainer) {
        console.error('Slider container not found');
        return;
    }

    // Function to collect and log all slider values
    function logAllSliderValues() {
        const sliderState = {};

        // Get all slider groups
        const sliderGroups = sliderContainer.querySelectorAll('[data-filter-group]');

        // Process each slider group
        sliderGroups.forEach(group => {
            const groupName = group.getAttribute('data-filter-group');

            // Find the slider element
            const slider = group.querySelector('.filter-range-slider');
            if (!slider) return;

            // Get the current value from the aria-valuenow attribute
            const handle = slider.querySelector('.noUi-handle');
            if (!handle) return;

            const value = parseInt(handle.getAttribute('aria-valuenow'), 10);

            // Add this slider's state to the overall state object
            sliderState[groupName] = {
                type: groupName,
                value: value
            };
        });

        // Log the complete slider state
        console.log('Slider state:', sliderState);

        return sliderState;
    }

    // Listen for Preline's custom range slider events
    document.addEventListener('hs.range-slider.change', function (e) {
        // Check if the event is from one of our filter sliders
        const slider = e.detail.target;
        if (slider && slider.closest('#filter-sliders')) {
            console.log('Range slider changed:', e.detail);

            // Log all slider values
            logAllSliderValues();
        }
    });

    // Also listen for the native input event on the slider handles
    sliderContainer.addEventListener('input', function (e) {
        const handle = e.target.closest('.noUi-handle');
        if (handle) {
            // Use setTimeout to ensure the aria-valuenow is updated
            setTimeout(logAllSliderValues, 50);
        }
    });

    // Listen for mouseup events on the handles to catch when dragging ends
    sliderContainer.addEventListener('mouseup', function (e) {
        const handle = e.target.closest('.noUi-handle');
        if (handle) {
            // Use setTimeout to ensure the aria-valuenow is updated
            setTimeout(logAllSliderValues, 50);
        }
    });

    // Listen for touchend events for mobile support
    sliderContainer.addEventListener('touchend', function (e) {
        const handle = e.target.closest('.noUi-handle');
        if (handle) {
            // Use setTimeout to ensure the aria-valuenow is updated
            setTimeout(logAllSliderValues, 50);
        }
    });

    // Log initial state when page loads
    setTimeout(logAllSliderValues, 100); // Small delay to ensure sliders are initialized
});