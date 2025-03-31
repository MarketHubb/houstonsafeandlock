document.addEventListener('DOMContentLoaded', function () {
    // Get the main filter container
    const filterContainer = document.getElementById('filter-checkbox');

    if (!filterContainer) {
        console.error('Filter container (#filter-checkbox) not found');
        return;
    }

    // Function to get the state of a specific filter group
    function getFilterGroupState(filterGroup) {
        const groupName = filterGroup.getAttribute('data-filter-group');
        const checkedValues = [];

        // Get all checked checkboxes in this group
        filterGroup.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
            checkedValues.push(checkbox.getAttribute('data-filter-val'));
        });

        // Return this group's state as an object
        return {
            type: groupName,
            selected: checkedValues
        };
    }

    // NEW: Function to get the state of ALL checkbox filter groups
    function getAllCheckboxStates() {
        const allStates = {};
        const filterGroups = filterContainer.querySelectorAll('[data-filter-group]');
        filterGroups.forEach(group => {
            const groupState = getFilterGroupState(group);
            if (groupState.type) { // Ensure group has a name
                allStates[groupState.type] = groupState.selected;
            }
        });
        return allStates;
    }

    // NEW: Expose the getter function globally
    window.getCheckboxFilterState = getAllCheckboxStates;

    // Function to ensure at least one checkbox is checked in a group
    function ensureOneCheckboxChecked(filterGroup) {
        const checkedBoxes = filterGroup.querySelectorAll('input[type="checkbox"]:checked');
        const allCheckbox = filterGroup.querySelector('input[type="checkbox"][data-filter-val="all"]');

        if (checkedBoxes.length === 0) {
            // If no checkboxes are checked, check the "all" option if it exists
            if (allCheckbox) {
                allCheckbox.checked = true;
                allCheckbox.disabled = true; // Disable it so it can't be unchecked easily
            } else {
                // If there's no "all" option, check the first checkbox as a fallback
                const firstCheckbox = filterGroup.querySelector('input[type="checkbox"]');
                if (firstCheckbox) {
                    firstCheckbox.checked = true;
                    // Consider if the first checkbox should also be disabled if it's the only fallback
                }
            }
            // Re-enable other checkboxes if 'all' was just checked programmatically
            filterGroup.querySelectorAll('input[type="checkbox"]:not([data-filter-val="all"])').forEach(cb => cb.disabled = false);
        } else {
            // Ensure 'all' checkbox is enabled if others are checked (unless it's the one checked)
            if (allCheckbox && !allCheckbox.checked) {
                allCheckbox.disabled = false;
            }
            // Handle disabling the currently checked 'all' or 'featured' if needed
            const checkedFeatured = filterGroup.querySelector('input[type="checkbox"][data-filter-val="featured"]:checked');
            if (allCheckbox && allCheckbox.checked) allCheckbox.disabled = true;
            if (checkedFeatured && checkedFeatured.checked) checkedFeatured.disabled = true;

        }
    }


    // Function to handle checkbox changes
    function handleCheckboxChange(event) {
        const checkbox = event.target;

        // Only process if this is a checkbox inside the container
        if (checkbox.type !== 'checkbox' || !checkbox.closest('#filter-checkbox')) return;

        // Get the filter group this checkbox belongs to
        const filterGroup = checkbox.closest('[data-filter-group]');
        if (!filterGroup) return;

        const groupName = filterGroup.getAttribute('data-filter-group');
        const filterValue = checkbox.getAttribute('data-filter-val');
        const isChecked = checkbox.checked;

        // Handle disabling/enabling based on selection logic
        const allCheckbox = filterGroup.querySelector('input[type="checkbox"][data-filter-val="all"]');
        const featuredCheckbox = filterGroup.querySelector('input[type="checkbox"][data-filter-val="featured"]'); // Assuming 'featured' might exist

        if (filterValue === 'all' && isChecked) {
            // Uncheck all others, disable 'all'
            filterGroup.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                cb.checked = (cb === checkbox);
                cb.disabled = (cb === checkbox); // Disable 'all', enable others
            });
        } else if (filterValue === 'featured' && isChecked) {
            // Uncheck all others, disable 'featured'
            filterGroup.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                cb.checked = (cb === checkbox);
                // Disable 'featured', ensure 'all' is enabled if it exists
                cb.disabled = (cb === checkbox || (cb === allCheckbox && !isChecked));
            });
            if (allCheckbox) allCheckbox.disabled = false; // Ensure 'all' is enabled

        } else if (isChecked) { // A regular checkbox was checked
            // Uncheck 'all' and 'featured', enable them
            if (allCheckbox) {
                allCheckbox.checked = false;
                allCheckbox.disabled = false;
            }
            if (featuredCheckbox) {
                featuredCheckbox.checked = false;
                featuredCheckbox.disabled = false;
            }
            // Disable the currently checked regular item? (Optional, depends on UX)
            // checkbox.disabled = true;
        } else { // A checkbox was unchecked
            // Re-enable the one that was just unchecked
            checkbox.disabled = false;
        }


        // Ensure at least one checkbox remains checked AFTER updates
        ensureOneCheckboxChecked(filterGroup);

        // Get and log the current state of THIS group (optional debug)
        // const groupState = getFilterGroupState(filterGroup);
        // console.log("Checkbox Group Changed:", groupState);

        // NEW: Trigger the global custom event for main.js
        document.dispatchEvent(new CustomEvent('filterChanged', { detail: { type: 'checkbox', group: groupName } }));
    }

    // Function to initialize states (mostly setting initial disabled states)
    function initializeFilterStates() {
        const filterGroups = filterContainer.querySelectorAll('[data-filter-group]');
        filterGroups.forEach(group => {
            ensureOneCheckboxChecked(group); // Check 'all' or first if none are checked by default
            // Log initial state for debugging (optional)
            // const groupState = getFilterGroupState(group);
            // console.log(`Initial Checkbox State - ${groupState.type}: ${groupState.selected.join(', ')}`);
        });
    }

    // Add event listener to the container (event delegation)
    filterContainer.addEventListener('change', handleCheckboxChange);

    // Initialize filter states when page loads
    initializeFilterStates();
});