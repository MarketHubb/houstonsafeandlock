document.addEventListener("DOMContentLoaded", () => {
    // Auto initialize all Preline components
    HSStaticMethods.autoInit();

    // Optionally, explicitly initialize ComboBox if needed
    if (typeof HSComboBox !== "undefined") {
        HSComboBox.autoInit();
    }

    // Add clear functionality to the clear icon
    const clearIcon = document.querySelector('[data-hs-combo-box-close]');
    const inputField = document.querySelector('[data-hs-combo-box-input]');
    const comboBoxContainer = document.querySelector('[data-hs-combo-box]');
    const comboBoxOutput = document.querySelector('[data-hs-combo-box-output]');

    if (clearIcon && inputField) {
        clearIcon.addEventListener('click', () => {
            // Clear the input value
            inputField.value = '';
            // Close the combobox dropdown if open
            if (typeof HSComboBox !== "undefined") {
                HSComboBox.closeCurrentlyOpened();
            }
        });
    }

    // Direct approach: Add click listeners to all combo box items
    const setupComboBoxItemListeners = () => {
        const items = document.querySelectorAll('[data-hs-combo-box-output-item]');
        items.forEach(item => {
            item.addEventListener('click', () => {
                const valueSpan = item.querySelector('[data-hs-combo-box-value]');
                if (valueSpan && inputField) {
                    // Get the full value from the data attribute
                    const fullValue = valueSpan.getAttribute('data-hs-combo-box-value') || valueSpan.textContent;

                    // Force update the input field with the full value
                    setTimeout(() => {
                        inputField.value = fullValue;
                        console.log('Selected and set full value:', fullValue);

                        // Dispatch a custom change event to notify any other listeners
                        inputField.dispatchEvent(new Event('change', { bubbles: true }));
                    }, 10); // Small delay to ensure Preline has finished its processing
                }
            });
        });
    };

    // Set up initial listeners
    setupComboBoxItemListeners();

    // Monitor for changes in the combo box output (items being added/removed)
    if (comboBoxOutput) {
        // Use a MutationObserver to detect when items are added or changed
        const observer = new MutationObserver((mutations) => {
            setupComboBoxItemListeners();
        });

        observer.observe(comboBoxOutput, { childList: true, subtree: true });
    }

    // Override the input field's behavior to prevent truncation
    if (inputField) {
        // Store the original value when the dropdown opens
        let originalValue = '';

        inputField.addEventListener('focus', () => {
            originalValue = inputField.value;
        });

        // Intercept the input event to prevent unwanted changes
        inputField.addEventListener('input', (e) => {
            // Allow typing for search, but log what's happening
            console.log('Input event:', e.target.value);
        });

        // If the value changes and looks truncated, restore it
        inputField.addEventListener('change', (e) => {
            console.log('Change event triggered, current value:', e.target.value);

            // Check if the value appears to be truncated (e.g., just "500" instead of "AMSEC-B1500")
            if (originalValue && originalValue.includes('-') && !e.target.value.includes('-')) {
                console.log('Value appears truncated, restoring from:', e.target.value, 'to:', originalValue);
                // Only restore if it looks like we're losing information
                if (originalValue.includes(e.target.value)) {
                    e.target.value = originalValue;
                }
            }
        });
    }

    // For debugging: Log when items are clicked
    document.addEventListener('click', (e) => {
        const item = e.target.closest('[data-hs-combo-box-output-item]');
        if (item) {
            console.log('Item clicked:', item);
            const valueSpan = item.querySelector('[data-hs-combo-box-value]');
            if (valueSpan) {
                console.log('Value span found:', valueSpan);
                console.log('Value attribute:', valueSpan.getAttribute('data-hs-combo-box-value'));
                console.log('Text content:', valueSpan.textContent);
            }
        }
    });
});
