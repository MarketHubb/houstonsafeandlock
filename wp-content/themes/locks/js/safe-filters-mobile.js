// Function to move the filter container to the modal
function moveFilterToModal() {
    // Check if window width is 768px or less
    if (window.innerWidth <= 768) {
        // Find the filter container
        const filterContainer = document.getElementById('filter-container');

        // Find the target container in the modal
        const modalContainer = document.querySelector('#hs-full-screen-modal .p-4.overflow-y-auto');

        // If both elements exist
        if (filterContainer && modalContainer) {
            // Find the filter-sort-container inside the modal
            const filterSortContainer = document.getElementById('filter-sort-container');

            // If filter-sort-container exists, move the filter container inside it
            if (filterSortContainer) {
                filterSortContainer.appendChild(filterContainer);
            } else {
                // Otherwise, move it directly to the modal container
                modalContainer.appendChild(filterContainer);
            }
        }
    }
}

// Run the function when the page loads
document.addEventListener('DOMContentLoaded', moveFilterToModal);

// Also run the function when the window is resized
window.addEventListener('resize', moveFilterToModal);
