window.addEventListener('load', () => {
    // Get all initialized range sliders
    const rangeSliders = document.querySelectorAll('.filter-range-slider');
    
    rangeSliders.forEach(range => {
        const sliderType = range.getAttribute('data-type');
        
        // Format the value based on the slider type
        const formatValue = (value) => {
            switch(sliderType) {
                case 'price':
                    return new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(value);
                // Add more cases for different types as needed
                default:
                    return value;
            }
        };

        // Access the existing noUiSlider instance and attach our update handler
        if (range.noUiSlider) {
            range.noUiSlider.on('update', (values) => {
                const value = parseFloat(values[0]);
                const formattedValue = formatValue(value);
                
                // Find the corresponding output element
                const outputElement = document.querySelector(`#hs-${sliderType}-slider-target`);
                if (outputElement) {
                    outputElement.textContent = formattedValue;
                }

                // Dispatch a custom event for other components that might need to react to the change
                const event = new CustomEvent('filter-slider-update', {
                    detail: {
                        type: sliderType,
                        value: value,
                        formattedValue: formattedValue
                    }
                });
                document.dispatchEvent(event);
            });
        }
    });
});
