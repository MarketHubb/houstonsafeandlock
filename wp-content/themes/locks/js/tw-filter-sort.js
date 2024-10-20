document.addEventListener('DOMContentLoaded', function() {
const gridContainer = document.querySelector('.product-grid');
const filterForm = document.querySelector('form.mt-4.border-t.border-gray-200');
const menuButton = document.getElementById('menu-button');
const sortDropdown = menuButton ? menuButton.nextElementSibling : null;
const gridItems = gridContainer ? gridContainer.querySelectorAll('.group\\/card') : [];
const sliders = document.querySelectorAll('input[type="range"]');
    
sliders.forEach(slider => {
    const output = document.getElementById(slider.id + 'Value');
        
    // Set initial value
    output.textContent = slider.value;
        
    // Update value on slider change
    slider.addEventListener('input', function () {
        output.textContent = this.value;
    });
});




if (!gridContainer || !filterForm || !menuButton || !sortDropdown || gridItems.length === 0) {
    console.error('One or more required elements not found');
    return;
}

// Initialize filters
let filters = {};
filterForm.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const filterName = this.name.replace('-', '_'); // Convert 'fire-rating' to 'fire_rating'
        if (!filters[filterName]) {
            filters[filterName] = [];
        }
            
        if (this.checked) {
            filters[filterName].push(this.value);
        } else {
            filters[filterName] = filters[filterName].filter(value => value !== this.value);
        }
            
        if (filters[filterName].length === 0) {
            delete filters[filterName];
        }
            
        applyFiltersAndSort();
    });
});

// Initialize sort
let currentSort = '';
sortDropdown.querySelectorAll('[role="menuitem"]').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        currentSort = this.id.replace('menu-item-', '');
        applyFiltersAndSort();
    });
});

function applyFiltersAndSort() {
        
    gridItems.forEach(item => {
        let show = true;

        // Apply filters
        for (let filterName in filters) {
            const itemValue = item.dataset[filterName.toLowerCase()];
            if (!itemValue || !filters[filterName].some(val => itemValue.includes(val))) {
                show = false;
                break;
            }
        }

        // Show/hide item
        item.style.display = show ? '' : 'none';

        // Show/hide badges
        const badgeContainer = item.querySelector('.badge-container');
        if (badgeContainer) {
            badgeContainer.querySelectorAll('span').forEach(badge => {
                const badgeType = badge.dataset.badge;
                if (filters[badgeType] && filters[badgeType].length > 0) {
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            });
        }
    });

    // Apply sort
    if (currentSort) {
        const sortedItems = Array.from(gridItems).filter(item => item.style.display !== 'none').sort((a, b) => {
            const aValue = a.dataset[currentSort.toLowerCase()] || '';
            const bValue = b.dataset[currentSort.toLowerCase()] || '';
            if (currentSort.includes('price') || currentSort.includes('weight') || currentSort.includes('width') || currentSort.includes('depth') || currentSort.includes('height')) {
                return (parseFloat(aValue) || 0) - (parseFloat(bValue) || 0);
            } else {
                return (aValue || '').localeCompare(bValue || '');
            }
        });
        if (currentSort.includes('high-low')) {
            sortedItems.reverse();
        }
        sortedItems.forEach(item => gridContainer.appendChild(item));
    }
}

// Initial application of filters and sort
applyFiltersAndSort();

});
