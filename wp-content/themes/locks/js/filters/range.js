// --- Start of range.js ---
document.addEventListener('DOMContentLoaded', function () {
    const sliderContainer = document.getElementById('filter-sliders');

    if (!sliderContainer) {
        console.error('Slider container (#filter-sliders) not found');
        return;
    }

    // --- Function to Update Target Spans (Based on your example) ---
    // Updates the span associated with a specific slider
    function updateValueDisplay(slider, value) {
        // Find the parent container with data-filter-group
        const filterGroupContainer = slider.closest('[data-filter-group]');
        if (!filterGroupContainer) return;
        const groupName = filterGroupContainer.getAttribute('data-filter-group');

        // Try to find a target span using slider ID pattern: slider.id + "-target"
        const sliderId = slider.id;
        let targetUpdated = false;
        if (sliderId) {
            const targetSpanById = document.getElementById(`${sliderId}-target`);
            if (targetSpanById) {
                targetSpanById.textContent = value;
                // console.log(`Updated ${sliderId}-target to ${value}`); // Debug log
                targetUpdated = true;
            }
        }

        // If not found by ID, try the group name pattern: "hs-" + groupName + "-target" (as fallback)
        if (!targetUpdated && groupName) {
            const targetSpanByGroup = document.getElementById(`hs-${groupName}-target`);
            if (targetSpanByGroup) {
                targetSpanByGroup.textContent = value;
                // console.log(`Updated hs-${groupName}-target to ${value}`); // Debug log
                targetUpdated = true;
            }
        }
        // if(!targetUpdated) { console.log(`No target span found for slider ${sliderId || groupName}`); } // Debug log
    }

    // --- State Getter for Main.js ---
    // Gets the state of ALL range sliders
    function getRangeSliderStates() {
        const sliderState = {};
        const sliders = sliderContainer.querySelectorAll('.filter-range-slider');

        sliders.forEach(slider => {
            const filterGroupContainer = slider.closest('[data-filter-group]');
            const groupName = filterGroupContainer?.getAttribute('data-filter-group');

            if (slider.noUiSlider && groupName) { // Check instance exists and has group name
                let value = slider.noUiSlider.get();
                // If the slider has multiple handles, 'get' returns an array (or string array)
                // Assuming single handle sliders based on previous context
                if (Array.isArray(value)) {
                    value = value[0]; // Take the first handle's value
                }
                const numericValue = parseFloat(value);
                if (!isNaN(numericValue)) {
                    sliderState[groupName] = Math.round(numericValue);
                }
            }
        });
        return sliderState;
    }
    // Expose getter for main.js
    window.getRangeFilterState = getRangeSliderStates;


    // --- Setup Listeners (Based on your example, adding dispatch) ---
    function setupNoUiSliderListeners() {
        const sliders = sliderContainer.querySelectorAll('.filter-range-slider');

        sliders.forEach(slider => {
            // console.log(`Checking slider: ${slider.id || 'unnamed'}`); // Debug log
            if (slider.noUiSlider && !slider.dataset.nouiListenersAttached) { // Check instance and prevent duplicate listeners
                // console.log(`Attaching noUiSlider events to: ${slider.id || 'unnamed'}`); // Debug log

                // 'update' fires continuously during drag or on programmatic changes
                slider.noUiSlider.on('update', function (values, handle) {
                    const value = Math.round(parseFloat(values[handle]));
                    // console.log(`Slider ${slider.id || 'unnamed'} updated: ${value}`); // Debug log
                    // Update the visual display span immediately
                    updateValueDisplay(slider, value);
                });

                // 'change' fires when the user stops interacting or value is set programmatically and differs
                slider.noUiSlider.on('change', function (values, handle) {
                    const value = Math.round(parseFloat(values[handle]));
                    // console.log(`Slider ${slider.id || 'unnamed'} changed (interaction ended): ${value}`); // Debug log
                    // Value display should already be updated by 'update', but ensure final state is shown
                    updateValueDisplay(slider, value);

                    // *** Dispatch filterChanged event for main.js ***
                    // Only dispatch when interaction likely finishes ('change')
                    document.dispatchEvent(new CustomEvent('filterChanged', { detail: { type: 'range' } }));
                    // console.log(`Dispatched filterChanged event from range slider ${slider.id || 'unnamed'}`); // Debug log
                });

                // Mark listeners as attached to prevent duplicates if setup runs multiple times
                slider.dataset.nouiListenersAttached = 'true';

                // Set initial display value after attaching listeners
                const initialValue = slider.noUiSlider.get();
                const numericInitial = parseFloat(Array.isArray(initialValue) ? initialValue[0] : initialValue);
                if (!isNaN(numericInitial)) {
                    updateValueDisplay(slider, Math.round(numericInitial));
                }

            } else if (slider.dataset.nouiListenersAttached) {
                // console.log(`Listeners already attached to: ${slider.id || 'unnamed'}`); // Debug log
            } else {
                // console.log(`No noUiSlider instance found yet on: ${slider.id || 'unnamed'}`); // Debug log
            }
        });
    }

    // --- Initialization (Based on your example) ---

    // Try to set up listeners immediately
    setupNoUiSliderListeners();

    // Also try again after a short delay to catch sliders initialized asynchronously
    setTimeout(setupNoUiSliderListeners, 500);

    // As a fallback, use MutationObserver to detect when noUiSlider might be initialized
    // This is helpful if sliders are added dynamically or initialized late
    const observer = new MutationObserver(function (mutations) {
        let needsSetup = false;
        mutations.forEach(function (mutation) {
            // Check if a slider element was added or modified to become a noUiSlider instance
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1 && node.matches('.filter-range-slider.noUi-target') && !node.dataset.nouiListenersAttached) {
                        needsSetup = true;
                    } else if (node.nodeType === 1) { // Check children of added nodes too
                        node.querySelectorAll('.filter-range-slider.noUi-target:not([data-noui-listeners-attached="true"])').forEach(() => needsSetup = true);
                    }
                });
            } else if (mutation.type === 'attributes' &&
                mutation.target.matches && // Ensure target is an element
                mutation.target.matches('.filter-range-slider') &&
                mutation.target.classList.contains('noUi-target') && // Check if noUiSlider class was added
                !mutation.target.dataset.nouiListenersAttached) {
                // console.log('Slider attributes changed, might be initialized:', mutation.target.id); // Debug log
                needsSetup = true;
            }
        });
        // If any mutation suggests a new/uninitialized slider was found, run setup again
        if (needsSetup) {
            // console.log('Mutation detected, attempting listener setup again.'); // Debug log
            // Use a small delay after mutation to allow potential batch updates to finish
            setTimeout(setupNoUiSliderListeners, 50);
        }
    });

    // Start observing the slider container for DOM changes and attribute changes
    observer.observe(sliderContainer, {
        childList: true, // Watch for sliders being added/removed
        attributes: true, // Watch for class attribute changes (like noUi-target being added)
        subtree: true, // Watch descendants too
        attributeFilter: ['class'] // Only observe class changes
    });

    console.log('Range slider handler setup using noUiSlider events initiated.');
});
// --- End of range.js ---