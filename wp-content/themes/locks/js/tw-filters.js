window.addEventListener('DOMContentLoaded', () => {
    const sliders = document.querySelectorAll('input[type="range"]');
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const productsContainer = document.querySelector('.product-grid');
    const products = Array.from(document.querySelectorAll('.product-item'));
    const sortOptions = document.querySelectorAll('[role="menuitem"]');

    // Add event listeners for both sliders and checkboxes
    sliders.forEach((slider) => {
        slider.addEventListener('input', filterProducts);
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

    function filterProducts() {
        const filterValues = {};
        const checkedFilters = {};

        // Populate filterValues for sliders
        sliders.forEach((slider) => {
            filterValues[slider.name] = parseFloat(slider.value);
        });

        // Populate checkedFilters for checkboxes
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                if (!checkedFilters[checkbox.name]) {
                    checkedFilters[checkbox.name] = new Set();
                }
                checkedFilters[checkbox.name].add(checkbox.value);
            }
        });

        products.forEach((product) => {
            let isVisible = true;

            // Check slider filters
            for (let key in filterValues) {
                const productValue = parseFloat(product.getAttribute(`data-${key}`));
                const sliderValue = filterValues[key];

                if (isNaN(productValue) || productValue > sliderValue) {
                    isVisible = false;
                    break;
                }
            }

            // Check checkbox filters
            if (isVisible) {
                for (let key in checkedFilters) {
                    if (checkedFilters[key].size > 0) {
                        const productValue = product.getAttribute(`data-${key}`);
                        if (productValue === null) {
                            // If the product doesn't have this attribute, it doesn't match the filter
                            isVisible = false;
                            break;
                        }
                        // Split the product value in case it's a comma-separated list
                        const productValues = productValue.split(',').map(v => v.trim());
                        // Check if any of the product's values match the checked filters
                        const hasMatch = productValues.some(value => checkedFilters[key].has(value));
                        if (!hasMatch) {
                            isVisible = false;
                            break;
                        }
                    }
                }
            }

            // Show or hide the product with fade effect
            if (isVisible) {
                product.style.transition = 'opacity 0.5s ease';
                product.style.opacity = '1';
                setTimeout(() => {
                    product.style.display = 'block';
                }, 500);
            } else {
                product.style.transition = 'opacity 0.5s ease';
                product.style.opacity = '0';
                setTimeout(() => {
                    product.style.display = 'none';
                }, 500);
            }
        });
    }

    function sortProducts(attribute) {
        // Sort products array based on the selected attribute
        products.sort((a, b) => {
            const aValue = parseFloat(a.getAttribute(`data-${attribute}`)) || 0;
            const bValue = parseFloat(b.getAttribute(`data-${attribute}`)) || 0;

            if (aValue === 0 && bValue === 0) return 0;
            if (aValue === 0) return 1;
            if (bValue === 0) return -1;
            return aValue - bValue;
        });

        // Remove all products from the container
        productsContainer.innerHTML = '';

        // Append sorted products back to the container
        products.forEach((product) => {
            productsContainer.appendChild(product);
        });
    }

    function highlightSortedAttribute(attribute) {
        // Remove font-bold from all spans in featured-attributes
        products.forEach((product) => {
            const featuredAttributes = product.querySelectorAll('.featured-attributes span');
            featuredAttributes.forEach((span) => {
                span.classList.remove('font-bold');
            });
        });

        // Add font-bold to the span matching the sorted attribute
        products.forEach((product) => {
            const matchingSpan = product.querySelector(`.featured-attributes span[data-sort-type="${attribute}"]`);
            if (matchingSpan) {
                matchingSpan.classList.add('font-bold');
            }
        });
    }
});
