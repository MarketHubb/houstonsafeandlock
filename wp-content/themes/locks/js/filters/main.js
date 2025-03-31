// --- Start of main.js ---
document.addEventListener('DOMContentLoaded', function () {

    // --- State Management ---
    let currentFilterStates = {
        checkboxes: {},
        ranges: {},
        advancedSelects: {}
    };
    const productGrid = document.querySelector('.product-grid');
    let isFiltering = false; // Flag to prevent concurrent filtering operations

    // --- Utility Functions ---
    const debounce = (func, delay) => {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };

    // --- State Getters (called by update function or init) ---
    function getCheckboxStates() {
        if (typeof window.getCheckboxFilterState === 'function') {
            try { return window.getCheckboxFilterState(); }
            catch (e) { console.error("Error getting checkbox state:", e); return {}; }
        } else { console.warn('Checkbox state function not found.'); return {}; }
    }

    function getRangeStates() {
        if (typeof window.getRangeFilterState === 'function') {
            try { return window.getRangeFilterState(); }
            catch (e) { console.error("Error getting range state:", e); return {}; }
        } else { console.warn('Range state function not found.'); return {}; }
    }

    function getAdvancedSelectStates() {
        if (typeof window.getAdvancedSelectState === 'function') {
            try { return window.getAdvancedSelectState(); }
            catch (e) { console.error("Error getting advanced select state:", e); return {}; }
        } else { console.warn('Advanced select state function not found.'); return {}; }
    }

    // --- Product Filtering Logic ---
    function filterProducts(filters) {
        if (!productGrid) {
            console.error("Product grid container (.product-grid) not found for filtering.");
            return;
        }
        if (isFiltering) {
            console.log("Filter requested but previous filter is still running.");
            return; // Exit if already processing
        }
        isFiltering = true;
        console.log("Starting filter process with state:", filters);

        const productItems = productGrid.querySelectorAll('a.product-item');
        if (productItems.length === 0) {
            console.log("No product items found to filter.");
            isFiltering = false;
            return;
        }

        // Animation: Start Hide Grid
        productGrid.style.transition = 'opacity 0.3s ease-in-out';
        productGrid.style.opacity = '0';

        // Use requestAnimationFrame to ensure the style change is applied before timeout
        requestAnimationFrame(() => {
            setTimeout(() => {
                productItems.forEach(item => {
                    let shouldBeVisible = true;

                    // 1. Advanced Select Filter (Series)
                    if (filters.advancedSelects && Object.keys(filters.advancedSelects).length > 0) {
                        for (const groupKey in filters.advancedSelects) {
                            const selectedValues = filters.advancedSelects[groupKey];
                            if (selectedValues && selectedValues.length > 0) {
                                const itemValue = item.dataset[groupKey];
                                if (!itemValue || !selectedValues.includes(itemValue)) {
                                    shouldBeVisible = false; break;
                                }
                            }
                        }
                    }

                    // 2. Checkbox Filters
                    if (shouldBeVisible && filters.checkboxes && Object.keys(filters.checkboxes).length > 0) {
                        for (const groupKey in filters.checkboxes) {
                            const selectedValues = filters.checkboxes[groupKey];
                            if (!selectedValues || selectedValues.length === 0 || selectedValues.includes('all')) continue;

                            if (groupKey === 'category' && selectedValues.includes('featured')) {
                                if (item.dataset.featured !== '1') {
                                    shouldBeVisible = false;
                                }
                                // Apply featured rule, then skip other category checks for this item
                                if (!shouldBeVisible) break; else continue;
                            }

                            const itemValue = item.dataset[groupKey];
                            // Treat checkbox filters as requiring an EXACT match from the product's attribute
                            // Check if the specific itemValue exists within the selectedValues array
                            if (!itemValue || !selectedValues.includes(itemValue)) {
                                shouldBeVisible = false; break;
                            }
                        }
                    }

                    // 3. Range Filters
                    if (shouldBeVisible && filters.ranges && Object.keys(filters.ranges).length > 0) {
                        for (const groupKey in filters.ranges) {
                            const filterValue = parseFloat(filters.ranges[groupKey]);
                            const itemValueStr = item.dataset[groupKey];

                            if (isNaN(filterValue)) continue;

                            // If item lacks the attribute, hide it (unless filter is at max? - decide requirement)
                            // Current logic: hide if attribute missing
                            if (itemValueStr === undefined || itemValueStr === null || itemValueStr === '') {
                                shouldBeVisible = false; break;
                            }

                            const itemValue = parseFloat(itemValueStr);
                            // Hide if item value is invalid or less than the filter value
                            if (isNaN(itemValue) || itemValue < filterValue) {
                                shouldBeVisible = false; break;
                            }
                        }
                    }

                    // Apply Visibility
                    if (shouldBeVisible) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                }); // End forEach productItem

                // Animation: End Show Grid
                productGrid.style.opacity = '1';
                isFiltering = false;
                console.log("Filtering complete. Grid revealed.");

            }, 300); // Match timeout duration to CSS transition time
        }); // End requestAnimationFrame

    } // End filterProducts function


    // --- Event Handling ---

    // Function to update state and trigger filtering
    function updateStateAndFilter(eventType, eventDetail) {
        let stateChanged = false;
        const group = eventDetail?.group;
        const values = eventDetail?.values;

        console.log(`Handling state update for: ${eventType}`);

        if (eventType === 'advanced-select' && group && values !== undefined) {
            currentFilterStates.advancedSelects[group] = values;
            stateChanged = true;
        } else if (eventType === 'checkbox') {
            currentFilterStates.checkboxes = getCheckboxStates();
            stateChanged = true;
        } else if (eventType === 'range') {
            currentFilterStates.ranges = getRangeStates();
            stateChanged = true;
        }

        if (stateChanged) {
            console.log("State updated by user interaction, triggering filtering:", currentFilterStates);
            filterProducts(currentFilterStates); // Trigger filtering now
        }
    }

    // Debounced version for handling filter events
    const debouncedUpdateAndFilter = debounce(updateStateAndFilter, 250);

    // Main event listener for changes from filter components
    function handleFilterUpdate(event) {
        const eventType = event.detail?.type;
        console.log(`Filter change event received. Type: ${eventType}`);
        // Use the debounced handler for all filter types triggered by user
        debouncedUpdateAndFilter(eventType, event.detail);
    }

    document.addEventListener('filterChanged', handleFilterUpdate);

    // --- Initial Application Setup ---
    function initializeApp() {
        if (!productGrid) {
            console.error("Product grid container (.product-grid) not found on initialization.");
            return;
        }
        console.log('--- Fetching Initial Filter States (for reference) ---');
        // Fetch initial state just to have it available if needed, but DON'T filter yet.
        currentFilterStates.checkboxes = getCheckboxStates();
        currentFilterStates.ranges = getRangeStates();
        currentFilterStates.advancedSelects = getAdvancedSelectStates();

        console.log('--- Initial Filter States ---');
        console.log(JSON.stringify(currentFilterStates, null, 2));
        console.log('-----------------------------');

        // *** FIX: REMOVED the automatic filtering call on load ***
        // The setTimeout block that called filterProducts is removed.

        // Ensure grid is visible by default (if not hidden by CSS initially)
        // If AJAX loads hidden items, they stay hidden until a filter potentially reveals them.
        productGrid.style.opacity = '1'; // Make sure grid container is visible
        console.log("Initialization complete. Waiting for user filter interaction.");
    }

    // Initialize the application state without triggering filtering
    initializeApp();

});
// --- End of main.js ---