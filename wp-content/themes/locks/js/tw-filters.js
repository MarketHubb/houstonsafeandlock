window.addEventListener('DOMContentLoaded', () => {
    const rangeSliders = document.querySelectorAll('.filter-range-slider');
    const checkboxes = document.querySelectorAll('.filter-group input[type="checkbox"]');
    const productsContainer = document.querySelector('.product-grid');
    const products = Array.from(document.querySelectorAll('.product-item'));
    const sortOptions = document.querySelectorAll('[role="menuitem"]');
    const sortsContainer = document.getElementById('sorts');
    const filtersContainer = document.getElementById('filters');
    const filterSortContainer = document.getElementById('filter-sort-container');
    const productListAnchor = document.getElementById('product-list');
    let originalSortsParent = sortsContainer?.parentElement;
    let originalFiltersParent = filtersContainer?.parentElement;

    // Initialize sort inputs
    const sortInputs = document.querySelectorAll('#sorts input[type="radio"]');
    console.log('Sort inputs found:', sortInputs.length);

    // Add event listeners for sort inputs
    sortInputs.forEach(input => {
        console.log('Setting up sort input:', {
            id: input.id,
            sortType: input.getAttribute('data-sort'),
            direction: input.getAttribute('data-direction')
        });

        input.addEventListener('change', (e) => {
            const sortType = e.target.getAttribute('data-sort');
            const direction = e.target.getAttribute('data-direction');
        
            console.log('Sort changed:', {
                sortType,
                direction
            });

            // Sort the products array
            products.sort((a, b) => {
                let aValue, bValue;

                // Handle price specifically
                if (sortType === 'price') {
                    // Check if either product lacks a price
                    const aHasPrice = a.hasAttribute('data-price');
                    const bHasPrice = b.hasAttribute('data-price');

                    // If either product lacks a price, move it to the end
                    if (!aHasPrice && !bHasPrice) return 0;  // Both no price, keep original order
                    if (!aHasPrice) return 1;  // a goes last
                    if (!bHasPrice) return -1; // b goes last

                    // Both have prices, sort normally
                    aValue = parseFloat(a.getAttribute('data-list-price')) || 0;
                    bValue = parseFloat(b.getAttribute('data-list-price')) || 0;
                } else {
                    aValue = parseFloat(a.getAttribute(`data-${sortType}`)) || 0;
                    bValue = parseFloat(b.getAttribute(`data-${sortType}`)) || 0;
                }

                // Handle direction
                return direction === 'asc' ? aValue - bValue : bValue - aValue;
            });

            // Clear and repopulate the products container
            productsContainer.innerHTML = '';
            products.forEach(product => {
                productsContainer.appendChild(product);
            });
        });
    });

    products.forEach(product => {
        product.setAttribute('data-visible', 'true');
    });

    rangeSliders.forEach((slider) => {
        const noUiSlider = slider.noUiSlider;
        if (noUiSlider) {
            noUiSlider.on('end', (values, handleIndex) => {
                console.log('Slider interaction ended:', {
                    type: slider.getAttribute('data-type'),
                    finalValue: values[handleIndex],
                });
                filterProducts();
            });
        }
    });

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', filterProducts);
    });

    sortOptions.forEach((option) => {
        option.addEventListener('click', (event) => {
            event.preventDefault();
            const attribute = option.getAttribute('data-attribute');
            sortProducts(attribute);
            highlightSortedAttribute(attribute);
        });
    });

    window.addEventListener('resize', moveSortsAndFilters);
    moveSortsAndFilters();

    const modalInstance = HSOverlay.getInstance('[data-hs-overlay="#hs-full-screen-modal"]', true);
    modalInstance.element.on('close', () => {
        productListAnchor.scrollIntoView({ behavior: 'smooth' });
    });

    function filterProducts() {
        const filterValues = {};
        const checkedFilters = {};

        // Get slider values
        rangeSliders.forEach((slider) => {
            const type = slider.getAttribute('data-type');
            const handle = slider.querySelector('.noUi-handle-lower');
            if (handle) {
                const value = handle.getAttribute('aria-valuenow');
                filterValues[type] = parseFloat(value);
            }
        });

        // Get checkbox values grouped by filter type
        const filterGroups = document.querySelectorAll('#filter-checkbox .filter-group');
        filterGroups.forEach((group) => {
            const filterType = group.getAttribute('data-filter-group');
            if (!checkedFilters[filterType]) {
                checkedFilters[filterType] = new Set();
            }
    
            const checkedBoxes = group.querySelectorAll('input[type="checkbox"]:checked');
            checkedBoxes.forEach((checkbox) => {
                checkedFilters[filterType].add(checkbox.value);
            });
        });

        products.forEach((product) => {
            let isVisible = true;
            const productTitle = product.querySelector('h3').textContent;

            // Check slider filters
            for (let key in filterValues) {
                let rawProductValue;
                if (key === 'price') {
                    if (!product.hasAttribute('data-price')) {
                        console.log(`${productTitle} price check: no price attribute, passing filter`);
                        continue;
                    }
                    rawProductValue = product.getAttribute('data-list-price');
                } else {
                    rawProductValue = product.getAttribute(`data-${key}`);
                }
        
                const productValue = parseFloat(rawProductValue);
                const sliderValue = filterValues[key];

                if (isNaN(productValue) || productValue > sliderValue) {
                    isVisible = false;
                    break;
                }
            }

            // If product passes slider filters, check each filter group
            if (isVisible) {
                // Check each filter group
                filterGroups.forEach((group) => {
                    const filterType = group.getAttribute('data-filter-group');
                    const checkedBoxes = group.querySelectorAll('input[type="checkbox"]:checked');
            
                    // If no boxes are checked in this group, product should be hidden
                    if (checkedBoxes.length === 0) {
                        isVisible = false;
                        return;
                    }
            
                    // If boxes are checked, product must match one of them
                    if (checkedFilters[filterType].size > 0) {
                        const productValue = product.getAttribute(`data-${filterType}`);
                
                        if (!productValue || !Array.from(checkedFilters[filterType]).some(value => 
                            productValue.includes(value))) {
                            isVisible = false;
                            return;
                        }
                    }
                });
            }

            product.setAttribute('data-visible', isVisible.toString());
        });

        // Update available filters after all products have been processed
        // updateAvailableFilters();
    }

    function sortProducts(attribute) {
        products.sort((a, b) => {
            const aValue = parseFloat(a.getAttribute(`data-${attribute}`)) || 0;
            const bValue = parseFloat(b.getAttribute(`data-${attribute}`)) || 0;

            if (aValue === 0 && bValue === 0) return 0;
            if (aValue === 0) return 1;
            if (bValue === 0) return -1;
            return aValue - bValue;
        });

        productsContainer.innerHTML = '';
        products.forEach((product) => {
            productsContainer.appendChild(product);
        });
    }

    function highlightSortedAttribute(attribute) {
        products.forEach((product) => {
            const featuredAttributes = product.querySelectorAll('.featured-attributes span');
            featuredAttributes.forEach((span) => {
                span.classList.remove('font-bold');
            });
        });

        products.forEach((product) => {
            const matchingSpan = product.querySelector(`.featured-attributes span[data-sort-type="${attribute}"]`);
            if (matchingSpan) {
                matchingSpan.classList.add('font-bold');
            }
        });
    }

    function moveSortsAndFilters() {
        if (window.innerWidth < 768) {
            if (!filterSortContainer.contains(sortsContainer)) {
                filterSortContainer.appendChild(sortsContainer);
            }
            if (!filterSortContainer.contains(filtersContainer)) {
                filterSortContainer.appendChild(filtersContainer);
            }
        } else {
            if (sortsContainer.parentElement !== originalSortsParent) {
                originalSortsParent.appendChild(sortsContainer);
            }
            if (filtersContainer.parentElement !== originalFiltersParent) {
                originalFiltersParent.appendChild(filtersContainer);
            }
        }
    }

});
