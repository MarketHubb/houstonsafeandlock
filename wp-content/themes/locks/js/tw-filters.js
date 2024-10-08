// Wait until the DOM content is fully loaded before running the JavaScript
window.addEventListener('DOMContentLoaded', () => {
    // Get all slider inputs and product elements
    const sliders = document.querySelectorAll('input[type="range"]');
    const products = document.querySelectorAll('.product-item');

    // Add an input event listener for each slider
    sliders.forEach((slider) => {
        slider.addEventListener('input', () => {
            console.log(`Slider ${slider.name} changed to value: ${slider.value}`);
            // Call the filter function whenever the slider value changes
            filterProducts();
        });
    });

    function filterProducts() {
        // Create an object to hold the current values of each slider
        const filterValues = {};

        // Populate the filterValues object with slider name and current value
        sliders.forEach((slider) => {
            filterValues[slider.name] = parseFloat(slider.value);
            console.log(`Filter value for ${slider.name}: ${filterValues[slider.name]}`);
        });

        // Iterate over each product and determine whether it should be shown or hidden
        products.forEach((product) => {
            let isVisible = true;

            // Check each data attribute of the product against the corresponding slider value
            for (let key in filterValues) {
                const productValue = parseFloat(product.getAttribute(`data-${key}`));
                const sliderValue = filterValues[key];

                if (isNaN(productValue)) {
                    console.error(`Product ${product.id} is missing data-${key} attribute or has invalid value.`);
                    isVisible = false;
                    break;
                }

                console.log(`Product ${product.id} - ${key}: ${productValue}, Slider value: ${sliderValue}`);

                if (productValue > sliderValue) {
                    // If the product value is greater than the slider value, hide the product
                    isVisible = false;
                    console.log(`Product ${product.id} will be hidden`);
                    break;
                }
            }

            // Show or hide the product based on the visibility condition
            if (isVisible) {
                console.log(`Product ${product.id} will be shown`);
                product.style.transition = 'opacity 0.5s ease';
                product.style.opacity = '1';
                setTimeout(() => {
                    product.style.display = 'block';
                }, 500);
            } else {
                console.log(`Product ${product.id} will be hidden with fade-out`);
                product.style.transition = 'opacity 0.5s ease';
                product.style.opacity = '0';
                setTimeout(() => {
                    product.style.display = 'none';
                }, 500);
            }
        });
    }
});