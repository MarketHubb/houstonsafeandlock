import { isFormValidated } from './validation.js';
import { formPromise, modalOpenPromise } from './init.js';

formPromise
    .then((form) => {
        gform.addAction('gform_input_change', (elem, formId, fieldId) => {
            const formValidated = isFormValidated(form);
            console.log("formValidated", formValidated);
        });
    })
    .catch((form) => {
        console.error('Error fetching form:', error);
    });