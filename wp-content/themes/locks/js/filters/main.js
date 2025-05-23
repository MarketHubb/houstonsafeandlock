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
    let dropdownVisible = false;
    let lastKeyPressTime = 0;
    let pendingKeyboardSelection = false;

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

        const filters = { ...currentFilterStates }; // Create a copy to modify
        const searchPostId = currentSearchPostId; // Use the global search Post ID state

        // NEW: Check if advanced-select has values and modify the category filter accordingly
        if (filters.advancedSelects &&
            filters.advancedSelects.series &&
            filters.advancedSelects.series.length > 0) {

            // If advanced-select has values, override the category filter to 'all'
            if (!filters.checkboxes) {
                filters.checkboxes = {};
            }
            filters.checkboxes.category = ['all'];

            console.log("Advanced select has values - Setting category filter to 'all'");
        }

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
                                // if (isNaN(itemValue) || itemValue < filterValue) { shouldBeVisible = false; break; }
                                if (isNaN(itemValue) || itemValue > filterValue) { shouldBeVisible = false; break; }
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

    // --- Update UI to reflect the category filter state ---
    function updateCategoryFilterUI(value) {
        // This function should update the UI of the category filter
        // You'll need to implement this based on how your checkbox UI works
        if (typeof window.setCategoryFilterValue === 'function') {
            try {
                window.setCategoryFilterValue(value);
                console.log(`Updated category filter UI to: ${value}`);
            } catch (e) {
                console.error("Error updating category filter UI:", e);
            }
        } else {
            console.warn("setCategoryFilterValue function not available");
        }
    }

    // --- Helper function to process a selection ---
    function processSelection(postId, displayText) {
        if (postId && postId !== currentSearchPostId) {
            console.log(`Selection processed: Post ID '${postId}', Text: '${displayText}'`);
            currentSearchPostId = postId;
            if (searchInput) searchInput.value = displayText;
            filterProducts();
            return true;
        }
        return false;
    }

    // --- Helper function to find the currently highlighted item ---
    function getHighlightedItem() {
        if (!searchOutputContainer) return null;

        // Try multiple selector patterns to find the highlighted item
        return searchOutputContainer.querySelector('.hs-combo-box-output-item-highlighted:not([style*="display: none"])') ||
            searchOutputContainer.querySelector('.selected:not([style*="display: none"])') ||
            searchOutputContainer.querySelector('.active:not([style*="display: none"])') ||
            searchOutputContainer.querySelector('[data-hs-combo-box-output-item]:focus') ||
            searchOutputContainer.querySelector('[data-hs-combo-box-output-item][aria-selected="true"]');
    }

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
            currentFilterStates.advancedSelects[group] = values;
            stateChanged = true;

            // NEW: If advanced-select has values, update the category filter in the UI
            if (group === 'series' && values.length > 0) {
                // If we have series selected, programmatically set category to 'all'
                if (!currentFilterStates.checkboxes) {
                    currentFilterStates.checkboxes = {};
                }

                // Only update UI if the current value isn't already 'all'
                if (!currentFilterStates.checkboxes.category ||
                    !currentFilterStates.checkboxes.category.includes('all') ||
                    currentFilterStates.checkboxes.category.length > 1) {

                    // Update the UI to reflect this change
                    updateCategoryFilterUI('all');
                }
            }
        } else if (eventType === 'checkbox') {
            currentFilterStates.checkboxes = getCheckboxStates();
            stateChanged = true;
        } else if (eventType === 'range') {
            currentFilterStates.ranges = getRangeStates();
            stateChanged = true;
        }

        if (stateChanged) {
            // Clear search Post ID when other filters are used
            if (currentSearchPostId !== null) {
                console.log("Clearing search Post ID because another filter changed.");
                currentSearchPostId = null;
                if (searchInput) { searchInput.value = ''; } // Clear visual input too
            }
            debouncedFilterProducts(); // Trigger filtering (debounced)
        }
    });

    // NEW: Monitor dropdown visibility with MutationObserver
    if (searchOutputContainer) {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                if (mutation.attributeName === 'style') {
                    const isVisible = searchOutputContainer.style.display !== 'none';
                    if (isVisible !== dropdownVisible) {
                        dropdownVisible = isVisible;
                        console.log(`Dropdown is now ${isVisible ? 'visible' : 'hidden'}`);

                        // If dropdown becomes visible, add direct event listeners to all items
                        if (isVisible) {
                            const items = searchOutputContainer.querySelectorAll('[data-hs-combo-box-output-item]');
                            items.forEach(item => {
                                // Remove any existing listeners first to avoid duplicates
                                item.removeEventListener('mousedown', itemClickHandler);
                                item.addEventListener('mousedown', itemClickHandler);
                            });
                        } else {
                            // Dropdown was hidden - check if we have a pending keyboard selection
                            if (pendingKeyboardSelection) {
                                console.log("Dropdown hidden with pending keyboard selection - checking for selection");
                                pendingKeyboardSelection = false;

                                // If the dropdown was hidden within 300ms of a keypress, it's likely a selection
                                if (Date.now() - lastKeyPressTime < 300) {
                                    console.log("Recent keypress detected - checking input value");

                                    // If the input has a value but no postId is set, try to find a matching item
                                    if (searchInput.value && !currentSearchPostId) {
                                        const inputValue = searchInput.value.trim().toLowerCase();
                                        const allItems = Array.from(searchOutputContainer.querySelectorAll('[data-hs-combo-box-output-item]'));

                                        // Try to find an item that matches the input text
                                        for (const item of allItems) {
                                            const valueSpan = item.querySelector('[data-postid]');
                                            if (valueSpan) {
                                                const itemText = valueSpan.textContent.trim().toLowerCase();
                                                if (itemText === inputValue || itemText.includes(inputValue)) {
                                                    const postId = valueSpan.getAttribute('data-postid');
                                                    const displayText = valueSpan.textContent.trim();
                                                    console.log(`Found matching item for keyboard selection: ${displayText}`);
                                                    processSelection(postId, displayText);
                                                    const optionsList = document.getElementById("search-options-list"); // how can I get this if it's loaded after domready?
                                                    optionsList.style.display="none";
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
        });

        observer.observe(searchOutputContainer, { attributes: true });

        // Initial check
        dropdownVisible = searchOutputContainer.style.display !== 'none';
    }

    // Handler for item clicks
    function itemClickHandler(event) {
        // Prevent default to avoid immediate blur
        event.preventDefault();
        event.stopPropagation();

        const item = event.currentTarget;
        const valueSpan = item.querySelector('[data-postid]');

        if (valueSpan) {
            const postId = valueSpan.getAttribute('data-postid');
            const displayText = valueSpan.textContent.trim();
            console.log(`Item clicked directly: Post ID '${postId}', Text: '${displayText}'`);

            // Process the selection after a short delay
            setTimeout(() => {
                processSelection(postId, displayText);
            }, 10);
        }
    }

    // Add a direct click handler to the output container
    if (searchOutputContainer) {
        searchOutputContainer.addEventListener('click', (event) => {
            const item = event.target.closest('[data-hs-combo-box-output-item]');
            if (item) {
                const valueSpan = item.querySelector('[data-postid]');
                if (valueSpan) {
                    const postId = valueSpan.getAttribute('data-postid');
                    const displayText = valueSpan.textContent.trim();
                    console.log(`Output container click: Post ID '${postId}', Text: '${displayText}'`);
                    processSelection(postId, displayText);
                }
            }
        });
    }

    // ENHANCED: Keyboard navigation handling
    if (searchInput) {
        // Capture all keydown events on the document to catch keyboard navigation
        document.addEventListener('keydown', (event) => {
            // Track the time of the keypress
            lastKeyPressTime = Date.now();

            if (dropdownVisible) {
                console.log(`Key pressed: ${event.key}`);

                if (event.key === 'Enter') {
                    console.log("Enter key pressed with dropdown visible");
                    pendingKeyboardSelection = true;

                    // Try to find the highlighted item
                    const highlightedItem = getHighlightedItem();

                    if (highlightedItem) {
                        console.log("Found highlighted item:", highlightedItem);
                        const valueSpan = highlightedItem.querySelector('[data-postid]');
                        if (valueSpan) {
                            const postId = valueSpan.getAttribute('data-postid');
                            const displayText = valueSpan.textContent.trim();
                            console.log(`Keyboard selection: Post ID '${postId}', Text: '${displayText}'`);

                            // Prevent default to avoid form submission
                            event.preventDefault();
                            event.stopPropagation();

                            // Process the selection after a short delay
                            setTimeout(() => {
                                processSelection(postId, displayText);
                            }, 10);
                        }
                    }
                }
                // Also track arrow key usage to help identify keyboard navigation
                else if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                    console.log(`Arrow key pressed: ${event.key}`);
                }
            }
        }, true); // Use capture phase to get event first

        // Track focus events
        searchInput.addEventListener('focus', () => {
            console.log("Search input focused");
        });

        searchInput.addEventListener('blur', () => {
            console.log("Search input blurred");

            // If dropdown is visible, we need to wait to see if a selection is made
            if (dropdownVisible) {
                console.log("Dropdown visible on blur - waiting for possible selection");
            } else {
                // If dropdown is not visible and no selection was made, clear the input
                if (!currentSearchPostId && searchInput.value) {
                    console.log("No selection made - clearing input");
                    searchInput.value = '';
                }
            }
        });
    }

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

    // --- Initial Application Setup ---
    function initializeApp() {
        if (!productGrid) { return; }
        console.log('--- Fetching Initial Filter States (for reference) ---');
        currentFilterStates.checkboxes = getCheckboxStates();
        currentFilterStates.ranges = getRangeStates();
        currentFilterStates.advancedSelects = getAdvancedSelectStates();
        currentSearchPostId = null; // Ensure search is clear initially

        console.log('--- Initial State ---');
        console.log("Filters:", JSON.stringify(currentFilterStates, null, 2));
        console.log("Search Post ID:", currentSearchPostId); // Log initial search ID
        console.log('--------------------');

        productGrid.style.opacity = '1';
        console.log("Initialization complete. Waiting for user interaction.");
    }

    initializeApp();

    // NEW: Global event listener with capture phase
    document.addEventListener('mousedown', (event) => {
        // Check if we're clicking on a dropdown item
        if (dropdownVisible) {
            const item = event.target.closest('[data-hs-combo-box-output-item]');
            if (item && searchOutputContainer.contains(item)) {
                const valueSpan = item.querySelector('[data-postid]');
                if (valueSpan) {
                    const postId = valueSpan.getAttribute('data-postid');
                    const displayText = valueSpan.textContent.trim();
                    console.log(`Global mousedown on item: Post ID '${postId}', Text: '${displayText}'`);

                    // Process after a short delay
                    setTimeout(() => {
                        processSelection(postId, displayText);
                    }, 10);
                }
            }
        }
    }, true); // Use capture phase to get event first

    // NEW: Inject a small script to hook directly into Preline's combo box
    function injectPrelineHook() {
        try {
            const script = document.createElement('script');
            script.textContent = `
                // Try to hook into Preline's combo box
                (function() {
                    const originalComboBox = window.HSComboBox;
                    if (originalComboBox) {
                        // Hook the click handler
                        const originalOnClick = originalComboBox.prototype._onClick;
                        originalComboBox.prototype._onClick = function(event) {
                            // Call the original method
                            originalOnClick.call(this, event);

                            // Check if this was a selection
                            const item = event.target.closest('[data-hs-combo-box-output-item]');
                            if (item) {
                                const valueSpan = item.querySelector('[data-postid]');
                                if (valueSpan) {
                                    const postId = valueSpan.getAttribute('data-postid');
                                    const displayText = valueSpan.textContent.trim();

                                    // Dispatch a custom event that our main code can listen for
                                    const customEvent = new CustomEvent('preline-combo-box-selection', {
                                        detail: { postId, displayText }
                                    });
                                    document.dispatchEvent(customEvent);
                                }
                            }
                        };

                        // Hook the keydown handler
                        const originalOnKeydown = originalComboBox.prototype._onKeydown;
                        originalComboBox.prototype._onKeydown = function(event) {
                            // Track the key press before calling the original method
                            if (event.key === 'Enter') {
                                // Find the currently highlighted item
                                const highlightedItem = this.outputEl.querySelector('.hs-combo-box-output-item-highlighted') ||
                                                      this.outputEl.querySelector('.selected');

                                if (highlightedItem) {
                                    const valueSpan = highlightedItem.querySelector('[data-postid]');
                                    if (valueSpan) {
                                        const postId = valueSpan.getAttribute('data-postid');
                                        const displayText = valueSpan.textContent.trim();

                                        // Dispatch a custom event for keyboard selection
                                        const customEvent = new CustomEvent('preline-combo-box-keyboard-selection', {
                                            detail: { postId, displayText }
                                        });
                                        document.dispatchEvent(customEvent);
                                    }
                                }
                            }

                            // Call the original method
                            originalOnKeydown.call(this, event);
                        };

                        console.log("Successfully hooked into Preline's combo box");
                    }
                })();
            `;
            document.head.appendChild(script);

            // Listen for our custom events
            document.addEventListener('preline-combo-box-selection', (event) => {
                const { postId, displayText } = event.detail;
                console.log(`Preline hook detected selection: Post ID '${postId}', Text: '${displayText}'`);
                processSelection(postId, displayText);
            });

            document.addEventListener('preline-combo-box-keyboard-selection', (event) => {
                const { postId, displayText } = event.detail;
                console.log(`Preline hook detected keyboard selection: Post ID '${postId}', Text: '${displayText}'`);
                processSelection(postId, displayText);
            });
        } catch (e) {
            console.error("Failed to inject Preline hook:", e);
        }
    }

    // Try to inject the hook after a short delay to ensure Preline is loaded
    setTimeout(injectPrelineHook, 500);

});
// --- End of main.js ---
