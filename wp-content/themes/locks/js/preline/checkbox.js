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

        // Handle "all" or "featured" checkbox logic
        if ((filterValue === 'all' || filterValue === 'featured') && checkbox.checked) {
            // Uncheck all other checkboxes in this group
            filterGroup.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
        } else if (checkbox.checked) {
            // If a regular checkbox is checked, uncheck the "all" and "featured" options
            filterGroup.querySelectorAll('input[type="checkbox"][data-filter-val="all"], input[type="checkbox"][data-filter-val="featured"]').forEach(cb => {
                cb.checked = false;
            });
        }

        // Collect all filter states and log them
        logAllFilterStates();
    }

    // Function to collect and log all filter states
    function logAllFilterStates() {
        const filterState = {};

        // Get all filter groups
        const filterGroups = filterContainer.querySelectorAll('[data-filter-group]');

        // Process each filter group
        filterGroups.forEach(group => {
            const groupName = group.getAttribute('data-filter-group');
            const checkedValues = [];

            // Get all checked checkboxes in this group
            group.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                checkedValues.push(checkbox.getAttribute('data-filter-val'));
            });

            // Add this group's state to the overall state object
            filterState[groupName] = {
                type: groupName,
                selected: checkedValues
            };
        });

        // Log the complete filter state
        console.log('Filter state:', filterState);

        return filterState;
    }

    // Add event listener to the container (event delegation)
    filterContainer.addEventListener('change', handleCheckboxChange);

    // Log initial state when page loads
    logAllFilterStates();
});
