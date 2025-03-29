document.addEventListener('DOMContentLoaded', function () {
    // Get the main filter container
    const filterContainer = document.getElementById('filter-checkbox');

    if (!filterContainer) {
        console.error('Filter container not found');
        return;
    }

    // Function to handle checkbox changes
    function handleCheckboxChange(event) {
        const checkbox = event.target;

        // Only process if this is a checkbox
        if (checkbox.type !== 'checkbox') return;

        // Get the filter group this checkbox belongs to
        const filterGroup = checkbox.closest('[data-filter-group]');
        if (!filterGroup) return;

        const groupName = filterGroup.getAttribute('data-filter-group');
        const filterValue = checkbox.getAttribute('data-filter-val');

        // Special handling for "all" checkbox
        if (filterValue === 'all' && checkbox.checked) {
            // Uncheck all other checkboxes in this group
            filterGroup.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false;
                    cb.disabled = false; // Ensure other checkboxes are enabled
                }
            });

            // Disable only the "all" checkbox
            checkbox.disabled = true;
        }
        // Special handling for "featured" checkbox
        else if (filterValue === 'featured' && checkbox.checked) {
            // Uncheck all other checkboxes except "all" (which should already be unchecked)
            filterGroup.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                if (cb !== checkbox && cb.getAttribute('data-filter-val') !== 'all') {
                    cb.checked = false;
                }
            });

            // Make sure "all" is unchecked but not disabled
            const allCheckbox = filterGroup.querySelector('input[type="checkbox"][data-filter-val="all"]');
            if (allCheckbox) {
                allCheckbox.checked = false;
                allCheckbox.disabled = false;
            }

            // Disable only the "featured" checkbox
            checkbox.disabled = true;
        }
        // Handling for regular checkboxes
        else if (checkbox.checked) {
            // If a regular checkbox is checked, uncheck the "all" and "featured" options
            filterGroup.querySelectorAll('input[type="checkbox"][data-filter-val="all"], input[type="checkbox"][data-filter-val="featured"]').forEach(cb => {
                cb.checked = false;
                cb.disabled = false; // Enable them again
            });
        }

        // Ensure at least one checkbox is checked in this group
        ensureOneCheckboxChecked(filterGroup);

        // Get and log only the changed filter group's state
        const groupState = getFilterGroupState(filterGroup);
        console.log(groupState);
    }

    // Function to ensure at least one checkbox is checked in a group
    function ensureOneCheckboxChecked(filterGroup) {
        const checkedBoxes = filterGroup.querySelectorAll('input[type="checkbox"]:checked');

        if (checkedBoxes.length === 0) {
            // If no checkboxes are checked, check the "all" option
            const allCheckbox = filterGroup.querySelector('input[type="checkbox"][data-filter-val="all"]');
            if (allCheckbox) {
                allCheckbox.checked = true;
                allCheckbox.disabled = true; // Disable it so it can't be unchecked
            } else {
                // If there's no "all" option, check the first checkbox
                const firstCheckbox = filterGroup.querySelector('input[type="checkbox"]');
                if (firstCheckbox) {
                    firstCheckbox.checked = true;
                }
            }
        }
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

    // Function to collect all filter states and ensure each group has at least one selection
    function initializeFilterStates() {
        // Get all filter groups
        const filterGroups = filterContainer.querySelectorAll('[data-filter-group]');

        console.log('Initial filter states:');

        // Process each filter group
        filterGroups.forEach(group => {
            // Ensure each group has at least one checkbox checked
            ensureOneCheckboxChecked(group);

            // Handle initial state of "all" and "featured" checkboxes
            const groupName = group.getAttribute('data-filter-group');

            // Check if this is the category group with a checked "featured" option
            if (groupName === 'category') {
                const featuredCheckbox = group.querySelector('input[type="checkbox"][data-filter-val="featured"]:checked');
                const allCheckbox = group.querySelector('input[type="checkbox"][data-filter-val="all"]');

                if (featuredCheckbox) {
                    // If "featured" is checked, disable it but make sure "all" is not disabled
                    featuredCheckbox.disabled = true;
                    if (allCheckbox) {
                        allCheckbox.disabled = false;
                    }
                } else if (allCheckbox && allCheckbox.checked) {
                    // If "all" is checked, disable it
                    allCheckbox.disabled = true;
                }
            } else {
                // For other groups, disable the checked "all" checkbox
                const checkedAllCheckbox = group.querySelector('input[type="checkbox"][data-filter-val="all"]:checked');
                if (checkedAllCheckbox) {
                    checkedAllCheckbox.disabled = true;
                }
            }

            const groupState = getFilterGroupState(group);
            console.log(`- ${groupState.type}: ${groupState.selected.join(', ') || 'none'}`);
        });
    }

    // Add event listener to the container (event delegation)
    filterContainer.addEventListener('change', handleCheckboxChange);

    // Initialize filter states when page loads
    initializeFilterStates();
});
