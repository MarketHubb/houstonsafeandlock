// --- Start of advanced-select.js ---
(function () {
    let lastDispatchedState = {}; // Track dispatched state per group name

    // Function to get the correct group name by traversing up from the select element
    function getGroupNameFromSelect(selectElement) {
        if (!selectElement) return null;

        // 1. Look for the closest ancestor div with the data-filter-group attribute
        const groupContainer = selectElement.closest('[data-filter-group]');
        const groupNameFromAttr = groupContainer?.getAttribute('data-filter-group');

        if (groupNameFromAttr) {
            return groupNameFromAttr;
        }

        // 2. Fallback to the select element's ID if the parent attribute isn't found
        const selectId = selectElement.id;
        if (selectId) {
            console.warn(`Advanced select using ID ('${selectId}') as group name. Consider adding data-filter-group attribute to parent div.`, selectElement);
            return selectId;
        }

        // 3. If nothing found, return null and log a clear error
        console.error("Could not determine group name for advanced select. Add 'data-filter-group' to an ancestor div or 'id' to the <select> element:", selectElement);
        return null;
    }

    // Function to get the state of ALL advanced select filters
    function getAllAdvancedSelectStates() {
        const allStates = {};
        const advancedSelectContainers = document.querySelectorAll('.hs-select');

        advancedSelectContainers.forEach(container => {
            const selectElement = container.querySelector('select');
            if (selectElement) {
                // *** Use the new function to find the group name ***
                const groupName = getGroupNameFromSelect(selectElement);

                if (groupName) { // Only proceed if we found a group name
                    const selectedOptions = Array.from(selectElement.selectedOptions);
                    const selectedValues = [...new Set(selectedOptions.map(option => option.value))]; // Ensure unique
                    allStates[groupName] = selectedValues;
                }
                // Error is logged within getGroupNameFromSelect if null
            }
        });
        return allStates;
    }

    // Expose the getter function globally
    window.getAdvancedSelectState = getAllAdvancedSelectStates;

    // Debounce function
    const debounce = (func, delay) => {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };


    function setupAdvancedSelectListeners() {
        const advancedSelects = document.querySelectorAll('.hs-select');

        if (advancedSelects.length > 0) {
            advancedSelects.forEach(hsSelectContainer => {
                const selectElement = hsSelectContainer.querySelector('select');
                if (!selectElement) {
                    console.warn('Could not find select element within .hs-select container:', hsSelectContainer);
                    return;
                }

                // *** Use the new function to find the group name ***
                const groupName = getGroupNameFromSelect(selectElement);

                // If NO group name was found by the function, skip setup for this select
                if (!groupName) {
                    return; // Error already logged by getGroupNameFromSelect
                }

                // Use the correct groupName for state tracking
                lastDispatchedState[groupName] = JSON.stringify([]);


                // Function to handle the change, get values, ensure uniqueness, and dispatch
                const handleSelectChangeAndDispatch = () => {
                    const selectedOptions = Array.from(selectElement.selectedOptions);
                    const selectedValues = [...new Set(selectedOptions.map(option => option.value))]; // Ensure unique
                    const currentStateString = JSON.stringify(selectedValues.sort());

                    // Use groupName for state comparison key
                    if (currentStateString !== lastDispatchedState[groupName]) {
                        lastDispatchedState[groupName] = currentStateString;

                        console.log(`Advanced Select Changed (${groupName}). Dispatching unique values:`, selectedValues);

                        // Dispatch event using the correct groupName found via traversal
                        document.dispatchEvent(new CustomEvent('filterChanged', {
                            detail: {
                                type: 'advanced-select',
                                group: groupName, // <-- Use the correctly found group name
                                values: selectedValues
                            }
                        }));
                    }
                };

                const debouncedChangeHandler = debounce(handleSelectChangeAndDispatch, 150);

                // --- Event Listeners ---
                selectElement.addEventListener('change', debouncedChangeHandler);
                hsSelectContainer.addEventListener('click', function (e) {
                    if (e.target.closest('[data-value]') || e.target.closest('[data-remove]')) {
                        setTimeout(debouncedChangeHandler, 50);
                    }
                });
                // Optional Preline listener ('hs.select.changed') remains commented out

            });
        } else {
            // console.log('No advanced select components (.hs-select) found.');
        }
    }

    // --- Initialization Logic (Same as before) ---
    let prelineInitialized = (typeof HSStaticMethods !== 'undefined' && typeof HSStaticMethods.autoInit === 'function');
    function attemptInit() { setupAdvancedSelectListeners(); }
    if (prelineInitialized || (typeof HSAdvancedSelect !== 'undefined' && HSAdvancedSelect.initialized)) { attemptInit(); } else { if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', () => setTimeout(attemptInit, 300)); } else { setTimeout(attemptInit, 500); } }

})();
// --- End of advanced-select.js ---