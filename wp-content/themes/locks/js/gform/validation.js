// @ts-nocheck
export function isFormValidated(form) {
    // Select all inputs, selects, and textareas inside the form body
    const inputs = form.querySelectorAll('.gform-body input, .gform-body select, .gform-body textarea');
    const validatedGroups = new Set();

    for (let input of inputs) {
        // Check if the input is required either by its own attribute or by being within a required container.
        if (input.hasAttribute('required') || (input.closest && input.closest('.gfield_contains_required'))) {

            // Special handling for radio buttons and checkboxes grouped by name
            if (input.type === 'radio' || input.type === 'checkbox') {
                const groupName = input.getAttribute('name');
                if (groupName && validatedGroups.has(groupName)) {
                    continue;
                }
                const groupInputs = form.querySelectorAll(`input[name="${groupName}"]`);
                const isGroupValid = Array.from(groupInputs).some(inp => inp.checked);
                if (!isGroupValid) {
                    return false;
                }
                if (groupName) {
                    validatedGroups.add(groupName);
                }
            } else {
                // For other input types, check if a trimmed value exists
                if (!input.value || input.value.trim() === '') {
                    return false;
                }
            }
        }
    }
    return true;
}
