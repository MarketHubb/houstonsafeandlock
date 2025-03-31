// --- Start of main.js ---
document.addEventListener('DOMContentLoaded', function () {

    // --- State Management ---
    let currentFilterStates = {
        checkboxes: {},
        ranges: {},
        advancedSelects: {} // Ensure this key always exists
    };
    let currentSearchPostId = null; // State for the selected Post ID from search
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
    function getCheckboxStates() { /* ... same ... */ }
    function getRangeStates() { /* ... same ... */ }
    function getAdvancedSelectStates() { /* ... same ... */ }

    // --- Product Filtering Logic (Reads global state) ---
    function filterProducts() {
        if (!productGrid) { console.error("Product grid missing!"); return; }
        if (isFiltering) { return; }
        isFiltering = true;

        const filters = currentFilterStates;
        const searchPostId = currentSearchPostId; // Use the global search Post ID state

        // Ensure sub-objects exist before accessing
        filters.checkboxes = filters.checkboxes || {};
        filters.ranges = filters.ranges || {};
        filters.advancedSelects = filters.advancedSelects || {};


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
                    const itemPostId = item.dataset.post_id; // Get product's post ID

                    // --- 1. Check Search Post ID FIRST ---
                    if (searchPostId) {
                        // Visibility depends ONLY on matching the product's data-post_id
                        shouldBeVisible = (itemPostId === searchPostId);
                    } else {
                        // --- 2. Apply Standard Filters (ONLY if no search Post ID) ---
                        const titleElement = item.querySelector('h3'); // Needed for potential debug/future use
                        const itemTitle = titleElement ? titleElement.textContent.trim() : '';

                        // Advanced Select (check if filters.advancedSelects is valid)
                        if (shouldBeVisible && filters.advancedSelects && typeof filters.advancedSelects === 'object' && Object.keys(filters.advancedSelects).length > 0) {
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
                        // Checkboxes (check if filters.checkboxes is valid)
                        if (shouldBeVisible && filters.checkboxes && typeof filters.checkboxes === 'object' && Object.keys(filters.checkboxes).length > 0) {
                            for (const groupKey in filters.checkboxes) {
                                const selectedValues = filters.checkboxes[groupKey];
                                if (!selectedValues || selectedValues.length === 0 || selectedValues.includes('all')) continue;
                                if (groupKey === 'category' && selectedValues.includes('featured')) {
                                    if (item.dataset.featured !== '1') { shouldBeVisible = false; }
                                    if (!shouldBeVisible) break; else continue;
                                }
                                const itemValue = item.dataset[groupKey];
                                if (!itemValue || !selectedValues.includes(itemValue)) {
                                    shouldBeVisible = false; break;
                                }
                            }
                        }
                        // Ranges (check if filters.ranges is valid)
                        if (shouldBeVisible && filters.ranges && typeof filters.ranges === 'object' && Object.keys(filters.ranges).length > 0) {
                            for (const groupKey in filters.ranges) {
                                const filterValue = parseFloat(filters.ranges[groupKey]);
                                const itemValueStr = item.dataset[groupKey];
                                if (isNaN(filterValue)) continue;
                                if (itemValueStr === undefined || itemValueStr === null || itemValueStr === '') {
                                    shouldBeVisible = false; break;
                                }
                                const itemValue = parseFloat(itemValueStr);
                                if (isNaN(itemValue) || itemValue < filterValue) {
                                    shouldBeVisible = false; break;
                                }
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

    // *** FIX: Define debounced function AFTER the base function is defined ***
    const debouncedFilterProducts = debounce(filterProducts, 300);


    // --- Event Handling ---

    // Listener for Checkbox/Range/AdvancedSelect filter changes
    document.addEventListener('filterChanged', (event) => {
        const eventType = event.detail?.type;
        const group = event.detail?.group;
        const values = event.detail?.values;
        let stateChanged = false;

        console.log(`Filter component changed: ${eventType}`);

        // *** FIX: Ensure currentFilterStates.advancedSelects exists ***
        if (typeof currentFilterStates.advancedSelects !== 'object' || currentFilterStates.advancedSelects === null) {
            currentFilterStates.advancedSelects = {};
        }

        // Update the corresponding state
        if (eventType === 'advanced-select' && typeof group === 'string' && group.length > 0 && values !== undefined) {
            currentFilterStates.advancedSelects[group] = values; stateChanged = true;
        } else if (eventType === 'checkbox') {
            currentFilterStates.checkboxes = getCheckboxStates(); stateChanged = true;
        } else if (eventType === 'range') {
            currentFilterStates.ranges = getRangeStates(); stateChanged = true;
        } else {
            console.warn("filterChanged event received without expected details:", event.detail);
        }

        if (stateChanged) {
            if (currentSearchPostId !== null) {
                console.log("Clearing search Post ID because another filter changed.");
                currentSearchPostId = null;
                if (searchInput) { searchInput.value = ''; }
            }
            // *** FIX: Call the correctly defined debounced function ***
            debouncedFilterProducts();
        }
    });

    // Listener for Search ITEM SELECTION (Click on Dropdown Item)
    if (searchOutputContainer && searchInput) {
        searchOutputContainer.addEventListener('click', (event) => {
            const clickedItemElement = event.target.closest('[data-hs-combo-box-output-item]');
            if (clickedItemElement) {
                // *** Simplified: Try reading directly on click ***
                const valueSpan = clickedItemElement.querySelector('[data-hs-combo-box-value][data-postid]');
                if (valueSpan) {
                    const newPostId = valueSpan.getAttribute('data-postid');
                    const displayText = valueSpan.getAttribute('data-hs-combo-box-value').trim();

                    if (newPostId && newPostId !== currentSearchPostId) {
                        console.log(`Search item selected: Post ID '${newPostId}', Text: '${displayText}'`);
                        currentSearchPostId = newPostId;
                        // Preline should update the input, but set it just in case
                        searchInput.value = displayText;
                        filterProducts(); // Filter immediately
                    }
                } else {
                    console.warn("Clicked item span missing value or postid attribute.");
                }
            }
        });
    } else { console.warn("Search output container or input not found."); }

    // Listener for Search CLEAR Button
    if (searchClearButton && searchInput) {
        searchClearButton.addEventListener('click', () => {
            console.log("Search clear button clicked.");
            if (currentSearchPostId !== null || searchInput.value !== '') {
                currentSearchPostId = null;
                searchInput.value = '';
                debouncedFilterProducts();
            }
        });
    } else { console.warn("Search clear button or input not found."); }


    // REMOVED: Listeners for 'input', 'keydown', 'blur' on searchInput

    // --- Initial Application Setup ---
    function initializeApp() {
        if (!productGrid) { return; }
        console.log('--- Fetching Initial Filter States (for reference) ---');
        currentFilterStates.checkboxes = getCheckboxStates();
        currentFilterStates.ranges = getRangeStates();
        currentFilterStates.advancedSelects = getAdvancedSelectStates();
        currentSearchPostId = null;
        if (searchInput) { searchInput.value = ''; } // Start with empty search

        console.log('--- Initial State ---');
        console.log("Filters:", JSON.stringify(currentFilterStates, null, 2));
        console.log("Search Post ID:", currentSearchPostId);
        console.log('--------------------');

        productGrid.style.opacity = '1';
        console.log("Initialization complete. Waiting for user interaction.");
    }

    initializeApp();

});
// --- End of main.js ---