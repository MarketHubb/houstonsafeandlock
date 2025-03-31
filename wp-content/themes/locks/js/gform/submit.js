import { isFormValidated } from './validation.js';
import { formPromise, modalOpenPromise } from './init.js';

// Function to handle submit button status
export function submitStatus(submitButton, form) {
    // Disable button initially
    submitButton.setAttribute('disabled', true);
    submitButton.classList.add('opacity-50', 'cursor-not-allowed');

    // Monitor form input changes
    gform.addAction('gform_input_change', (elem, formId, fieldId) => {
        if (isFormValidated(form)) {
            submitButton.removeAttribute('disabled');
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitButton.setAttribute('disabled', true);
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    });
}

// Using the formPromise to get the form and initialize behaviors
formPromise
    .then((form) => {
        // Example: select your submit button (adjust the selector as needed)
        const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');

        if (submitButton) {
            // Initialize the submit status function with the submit button and form
            submitStatus(submitButton, form);
        } else {
            console.error('Submit button not found');
        }

        // Existing form change logging (if still needed)
        gform.addAction('gform_input_change', (elem, formId, fieldId) => {
            const formValidated = isFormValidated(form);
            console.log("formValidated", formValidated);
        });
    })
    .catch((error) => {
        console.error('Error fetching form:', error);
    });
