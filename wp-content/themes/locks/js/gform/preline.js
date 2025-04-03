import { domReadyPromise, formPromise, modalOpenPromise } from './init.js';

Promise.all([modalOpenPromise, formPromise])
    .then(([modal, form]) => {
        // Extract the form's numeric ID from its id attribute.
        const formIdMatch = form.id.match(/\d+/);
        const formId = formIdMatch ? formIdMatch[0] : '10';

        // Find the form wrapper by assuming its id is "gform_wrapper_{formId}".
        const $formWrapper = jQuery(form).closest(`#gform_wrapper_${formId}`);
        if (!$formWrapper.length) {
            console.error('Form wrapper not found for form ID:', formId);
            return;
        }

        // Clone the entire form wrapper to get a pristine copy.
        const $clonedWrapper = $formWrapper.clone();
        // Optionally remove elements that shouldn't be reloaded.
        $clonedWrapper.find('.ginput_counter').remove();

        // Cache the cloned HTML markup.
        const formHtml = $clonedWrapper.html();

        // Replace the current form markup with the pristine copy.
        // (In a real scenario, you might do this on user action or after a timeout.)
        $formWrapper.html(formHtml);

        // Reset Gravity Forms' global submission flag.
        window['gf_submitting_' + formId] = false;

        // (Optional) If your site uses a spinner, reinitialize it.
        if (typeof gformInitSpinner === 'function') {
            gformInitSpinner(formId);
        }

        // Trigger the documented GF hook gform_post_render.
        // Gravity Forms listens for this event to reapply conditional logic.
        jQuery(document).trigger('gform_post_render', [parseInt(formId, 10), form]);

        // Reinitialize datepicker functionality if available.
        if (typeof gformInitDatepicker === 'function') {
            gformInitDatepicker();
        }

        console.log('Form reloaded and Gravity Forms reinitialized for form ID:', formId);
    })
    .catch((error) => {
        console.error('Error loading modal or form:', error);
    });
