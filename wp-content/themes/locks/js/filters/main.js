// --- Start of main.js ---
document.addEventListener('DOMContentLoaded', function () {

    // Variable to hold the latest known state of all filters
    let currentFilterStates = {
        checkboxes: {},
        ranges: {},
        advancedSelects: {}
    };

    // Function to get the initial state or state for non-advanced-select types
    function updateNonAdvancedSelectStates() {
        // Checkbox States
        if (typeof window.getCheckboxFilterState === 'function') {
            try { currentFilterStates.checkboxes = window.getCheckboxFilterState(); }
            catch (e) { console.error("Error getting checkbox state:", e); }
        } else { console.warn('Checkbox state function (getCheckboxFilterState) not found.'); }

        // Range States
        if (typeof window.getRangeFilterState === 'function') {
            try { currentFilterStates.ranges = window.getRangeFilterState(); }
            catch (e) { console.error("Error getting range state:", e); }
        } else { console.warn('Range state function (getRangeFilterState) not found.'); }

        // Advanced Select States (ONLY for initial load)
        if (typeof window.getAdvancedSelectState === 'function') {
            try {
                if (Object.keys(currentFilterStates.advancedSelects).length === 0) {
                    currentFilterStates.advancedSelects = window.getAdvancedSelectState();
                }
            } catch (e) { console.error("Error getting initial advanced select state:", e); }
        } else { console.warn('Advanced select state function (getAdvancedSelectState) not found for initial load.'); }
    }

    // Debounce function
    const debounce = (func, delay) => {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };

    // Function to log the current state (called after updates)
    function logCurrentState(triggerType) {
        console.log(`Logging state triggered by: ${triggerType || 'unknown'}`);
        console.log('--- All Current Filter States ---');
        console.log(JSON.stringify(currentFilterStates, null, 2)); // Log the stored state variable
        console.log('---------------------------------');

        // --------------------------------------------------
        // **** FIX: Comment out the call until function is defined ****
        // filterProducts(currentFilterStates);
        // --------------------------------------------------
    }

    // Create a debounced version for logging/filtering
    const debouncedLogCurrentState = debounce(logCurrentState, 200);


    // Function to handle the filter change event
    function handleFilterUpdate(event) {
        const eventType = event.detail?.type;
        const eventGroup = event.detail?.group;
        const eventValues = event.detail?.values; // Get values from event detail

        console.log(`Filter change event received. Type: ${eventType}, Group: ${eventGroup || 'N/A'}`);

        let stateUpdated = false;

        // *** Use event detail for advanced-select ***
        if (eventType === 'advanced-select' && eventGroup && eventValues !== undefined) {
            // Directly update the stored state using values from the event detail
            currentFilterStates.advancedSelects[eventGroup] = eventValues;
            console.log(`Updated advancedSelects state for group '${eventGroup}' from event detail.`);
            stateUpdated = true;
            // Log/filter immediately or debounce
            debouncedLogCurrentState(eventType);

        } else if (eventType === 'checkbox' || eventType === 'range') {
            // For other types, update their state by calling the respective getters
            if (eventType === 'checkbox' && typeof window.getCheckboxFilterState === 'function') {
                try { currentFilterStates.checkboxes = window.getCheckboxFilterState(); stateUpdated = true; }
                catch (e) { console.error("Error updating checkbox state:", e); }
            } else if (eventType === 'range' && typeof window.getRangeFilterState === 'function') {
                try { currentFilterStates.ranges = window.getRangeFilterState(); stateUpdated = true; }
                catch (e) { console.error("Error updating range state:", e); }
            }
            // Use debounce for checkboxes/ranges
            if (stateUpdated) { debouncedLogCurrentState(eventType); }
        } else {
            console.warn("Received filterChanged event with unknown type or missing data:", event.detail);
        }
    }

    // Listen for the custom 'filterChanged' event
    document.addEventListener('filterChanged', handleFilterUpdate);

    // --- Initial State Fetch and Log on Page Load ---
    setTimeout(() => {
        console.log('--- Fetching Initial Filter States ---');
        updateNonAdvancedSelectStates(); // Fetch initial state for all types
        console.log('--- Initial Filter States ---');
        logCurrentState('initial load'); // Log the fetched initial state
        console.log('-----------------------------');

        // Optionally trigger initial filtering
        // filterProducts(currentFilterStates);

    }, 800); // Adjust delay as needed

});
// --- End of main.js ---