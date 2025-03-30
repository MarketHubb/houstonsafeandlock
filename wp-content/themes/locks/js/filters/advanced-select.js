(function () {
    // Track the last logged state to prevent duplicate logs
    let lastLoggedState = '';

    // Function to set up the event listeners
    function setupAdvancedSelectListeners() {
        // Look for all advanced select components on the page
        const advancedSelects = document.querySelectorAll('.hs-select');

        console.log('Found advanced selects:', advancedSelects.length);

        if (advancedSelects.length > 0) {
            // For each advanced select component
            advancedSelects.forEach(select => {
                // Get a unique identifier for logging
                const selectId = select.querySelector('select')?.id || 'unnamed-select';

                console.log('Setting up listeners for:', selectId);

                // Create a function to log all currently selected values
                const logSelectedValues = () => {
                    // Find the hidden select element that stores the actual values
                    const selectElement = select.querySelector('select');

                    if (selectElement) {
                        // Get all selected options
                        const selectedOptions = Array.from(selectElement.selectedOptions);
                        const selectedValues = selectedOptions.map(option => option.value);

                        // Create the state object with the requested structure
                        const stateObj = {
                            type: 'series',
                            selected: selectedValues
                        };

                        // Convert to string for comparison to prevent duplicate logs
                        const stateString = JSON.stringify(stateObj);

                        // Only log if the state has changed
                        if (stateString !== lastLoggedState) {
                            lastLoggedState = stateString;
                            console.log(stateObj);
                        }
                    }
                };

                // Use a debounce function to prevent multiple rapid calls
                const debounce = (func, delay) => {
                    let timeout;
                    return function () {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func.apply(this, arguments), delay);
                    };
                };

                // Create a debounced version of the log function
                const debouncedLogValues = debounce(logSelectedValues, 50);

                // Log initial values
                setTimeout(logSelectedValues, 100);

                // Use a single event listener on the select element
                select.addEventListener('click', function (e) {
                    // Only proceed if this is a dropdown item or remove button
                    if (e.target.closest('[data-value]') ||
                        e.target.closest('[data-remove]')) {
                        debouncedLogValues();
                    }
                });

                // Listen for the custom Preline events
                document.addEventListener('hs.select.changed', function (e) {
                    // Check if this event is for our select
                    if (e.detail && e.detail.target === select) {
                        debouncedLogValues();
                    }
                }, { once: false });
            });
        } else {
            console.log('No advanced select components found on the page');
        }
    }

    // Try to run immediately if Preline is already initialized
    if (typeof HSAdvancedSelect !== 'undefined') {
        console.log('Preline Advanced Select detected, setting up listeners');
        setupAdvancedSelectListeners();
    } else {
        // If not, wait a short time to ensure Preline has initialized
        console.log('Waiting for Preline Advanced Select to initialize');
        setTimeout(setupAdvancedSelectListeners, 500);
    }

    // Also set up listeners when the DOM is fully loaded (as a fallback)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupAdvancedSelectListeners);
    }

    // Final fallback - try again after window load
    window.addEventListener('load', setupAdvancedSelectListeners);
})();