// --- Start of main.js ---
document.addEventListener('DOMContentLoaded', function () {

    // --- State Management ---
    let currentFilterStates = {
        checkboxes: {},
        ranges: {},
        advancedSelects: {}
    };
    let currentSearchPostId = null; // NEW: State for the selected Post ID from search
    const productGrid = document.querySelector('.product-grid');
    const searchInput = document.querySelector('[data-hs-combo-box-input]');
    const searchBoxWrapper = document.querySelector('[data-hs-combo-box]');
    const searchOutputContainer = document.querySelector('[data-hs-combo-box-output]');
    const searchClearButton = document.querySelector('[data-hs-combo-box-close]');
    let isFiltering = false;

    // --- Utility Functions ---
    const debounce = (func, delay) => {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };

    // --- State Getters ---
    function getCheckboxStates() { /* ... same ... */
        if (typeof window.getCheckboxFilterState === 'function') {
            try { return window.getCheckboxFilterState(); } catch (e) { console.error("Error getting checkbox state:", e); return {}; }
        } else { return {}; }
    }
    function getRangeStates() { /* ... same ... */
        if (typeof window.getRangeFilterState === 'function') {
            try { return window.getRangeFilterState(); } catch (e) { console.error("Error getting range state:", e); return {}; }
        } else { return {}; }
    }
    function getAdvancedSelectStates() { /* ... same ... */
        if (typeof window.getAdvancedSelectState === 'function') {
            try { return window.getAdvancedSelectState(); } catch (e) { console.error("Error getting advanced select state:", e); return {}; }
        } else { return {}; }
    }

    // --- Product Filtering Logic (Reads global state) ---
    function filterProducts() { // Reads global currentFilterStates and currentSearchPostId
        if (!productGrid) { console.error("Product grid missing!"); return; }
        if (isFiltering) { return; }
        isFiltering = true;

        const filters = currentFilterStates;
        const searchPostId = currentSearchPostId; // Use the global search Post ID state

        console.log("FILTERING - Search Post ID:", `'${searchPostId || 'None'}'`, "Filters:", filters);

        const productItems = productGrid.querySelectorAll('a.product-item');
        if (productItems.length === 0) { isFiltering = false; return; }

        // Start Hide Animation
        productGrid.style.transition = 'opacity 0.3s ease-in-out';
        productGrid.style.opacity = '0';

        requestAnimationFrame(() => {
            setTimeout(() => {
                productItems.forEach(item => {
                    let shouldBeVisible = true;

                    // --- 1. Check Search Post ID FIRST ---
                    if (searchPostId) { // If a specific post ID is selected via search
                        // Visibility depends ONLY on matching the product's data-post_id
                        shouldBeVisible = (item.dataset.post_id === searchPostId);
                    } else {
                        // --- 2. Apply Standard Filters (ONLY if no search Post ID) ---
                        // Advanced Select
                        if (shouldBeVisible && filters.advancedSelects && Object.keys(filters.advancedSelects).length > 0) {
                            for (const groupKey in filters.advancedSelects) { /* ... same logic ... */
                                const selectedValues = filters.advancedSelects[groupKey];
                                if (selectedValues && selectedValues.length > 0) {
                                    const itemValue = item.dataset[groupKey];
                                    if (!itemValue || !selectedValues.includes(itemValue)) { shouldBeVisible = false; break; }
                                }
                            }
                        }
                        // Checkboxes
                        if (shouldBeVisible && filters.checkboxes && Object.keys(filters.checkboxes).length > 0) {
                            for (const groupKey in filters.checkboxes) { /* ... same logic ... */
                                const selectedValues = filters.checkboxes[groupKey];
                                if (!selectedValues || selectedValues.length === 0 || selectedValues.includes('all')) continue;
                                if (groupKey === 'category' && selectedValues.includes('featured')) {
                                    if (item.dataset.featured !== '1') { shouldBeVisible = false; }
                                    if (!shouldBeVisible) break; else continue;
                                }
                                const itemValue = item.dataset[groupKey];
                                if (!itemValue || !selectedValues.includes(itemValue)) { shouldBeVisible = false; break; }
                            }
                        }
                        // Ranges
                        if (shouldBeVisible && filters.ranges && Object.keys(filters.ranges).length > 0) {
                            for (const groupKey in filters.ranges) { /* ... same logic ... */
                                const filterValue = parseFloat(filters.ranges[groupKey]);
                                const itemValueStr = item.dataset[groupKey];
                                if (isNaN(filterValue)) continue;
                                if (itemValueStr === undefined || itemValueStr === null || itemValueStr === '') { shouldBeVisible = false; break; }
                                const itemValue = parseFloat(itemValueStr);
                                if (isNaN(itemValue) || itemValue < filterValue) { shouldBeVisible = false; break; }
                            }
                        }
                    } // End standard filter block

                    // Apply Visibility
                    if (shouldBeVisible) { item.classList.remove('hidden'); }
                    else { item.classList.add('hidden'); }
                }); // End forEach

                // End Show Animation
                productGrid.style.opacity = '1';
                isFiltering = false;
                console.log("Filtering complete.");
            }, 300); // Match CSS transition
        }); // End requestAnimationFrame
    } // End filterProducts

    // --- Debounced version of the main filter function ---
    const debouncedFilterProducts = debounce(filterProducts, 300);


    // --- Event Handling ---

    // Listener for Checkbox/Range/AdvancedSelect filter changes
    document.addEventListener('filterChanged', (event) => {
        const eventType = event.detail?.type;
        const group = event.detail?.group;
        const values = event.detail?.values;
        let stateChanged = false;

        console.log(`Filter component changed: ${eventType}`);

        // Update the corresponding state
        if (eventType === 'advanced-select' && group && values !== undefined) {
            currentFilterStates.advancedSelects[group] = values; stateChanged = true;
        } else if (eventType === 'checkbox') {
            currentFilterStates.checkboxes = getCheckboxStates(); stateChanged = true;
        } else if (eventType === 'range') {
            currentFilterStates.ranges = getRangeStates(); stateChanged = true;
        }

        if (stateChanged) {
            // Clear search Post ID when other filters are used
            if (currentSearchPostId !== null) {
                console.log("Clearing search Post ID because another filter changed.");
                currentSearchPostId = null;
                if (searchInput) { searchInput.value = ''; } // Clear visual input too
                // You might need to tell Preline to visually reset its selection state here if clearing the input value isn't enough
                // Example: HSComboBox.getInstance(searchBoxWrapper, true)?.clearSelection(); (Check Preline docs)
            }
            debouncedFilterProducts(); // Trigger filtering (debounced)
        }
    });

    // Listener for Search ITEM SELECTION (Click on Dropdown Item)
    if (searchOutputContainer) {
        searchOutputContainer.addEventListener('click', (event) => {
            const clickedItem = event.target.closest('[data-hs-combo-box-output-item]');
            if (clickedItem) {
                const valueSpan = clickedItem.querySelector('[data-hs-combo-box-value][data-postid]'); // Ensure it has postid
                if (valueSpan) {
                    const newPostId = valueSpan.getAttribute('data-postid'); // Get the post ID
                    const displayText = valueSpan.getAttribute('data-hs-combo-box-value').trim(); // Get text for display

                    if (newPostId && newPostId !== currentSearchPostId) {
                        console.log(`Search item selected via click: Post ID '${newPostId}', Text: '${displayText}'`);
                        currentSearchPostId = newPostId; // Set the Post ID state
                        if (searchInput) { searchInput.value = displayText; } // Update input visually with text
                        filterProducts(); // Filter *immediately* based on Post ID
                    }
                }
            }
        });
    } else { console.warn("Search output container not found."); }

    // Listener for Search CLEAR Button
    if (searchClearButton) {
        searchClearButton.addEventListener('click', () => {
            console.log("Search clear button clicked.");
            if (currentSearchPostId !== null || (searchInput && searchInput.value !== '')) {
                currentSearchPostId = null; // Clear the Post ID state
                if (searchInput) { searchInput.value = ''; } // Clear visual input
                debouncedFilterProducts(); // Re-apply standard filters
            }
        });
    } else { console.warn("Search clear button not found."); }

    // REMOVED: Listeners for 'input', 'keydown', and 'blur' on searchInput
    // Filtering is now only triggered by explicit selection or clear


    // --- Initial Application Setup ---
    function initializeApp() {
        if (!productGrid) { return; }
        console.log('--- Fetching Initial Filter States (for reference) ---');
        currentFilterStates.checkboxes = getCheckboxStates();
        currentFilterStates.ranges = getRangeStates();
        currentFilterStates.advancedSelects = getAdvancedSelectStates();
        currentSearchPostId = null; // Ensure search is clear initially
        if (searchInput) { currentSearchTerm = searchInput.value.trim(); } // Read initial text for logging if needed

        console.log('--- Initial State ---');
        console.log("Filters:", JSON.stringify(currentFilterStates, null, 2));
        console.log("Search Post ID:", currentSearchPostId); // Log initial search ID
        console.log('--------------------');

        productGrid.style.opacity = '1';
        console.log("Initialization complete. Waiting for user interaction.");
    }

    initializeApp();

});
// --- End of main.js ---