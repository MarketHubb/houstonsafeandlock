<?php
// In your theme's functions.php or plugin file
add_action( 'wp_enqueue_scripts', function() {
    gravity_form_enqueue_scripts(7, true); // 7 is your form ID
});


add_filter( 'gform_form_args', function ( $args ) {
    $args['submission_method'] = GFFormDisplay::SUBMISSION_METHOD_AJAX;
    return $args;
});

// Add these filters to handle the choices at different form stages
add_filter('gform_pre_render_7', 'customize_form_7_radio_choices');
add_filter('gform_pre_validation_7', 'customize_form_7_radio_choices');
add_filter('gform_pre_submission_filter_7', 'customize_form_7_radio_choices');
add_filter('gform_admin_pre_render_7', 'customize_form_7_radio_choices');

function customize_form_7_radio_choices($form)
{
    // Only proceed if this is form ID 7
    if ($form['id'] != 7) {
        return $form;
    }

    // Get the dynamic choices from your existing function
    $custom_choices = get_gf_args_input_12();

    // Find field ID 3 (radio field)
    foreach ($form['fields'] as &$field) {
        if ($field->id == 3 && $field->type == 'radio') {
            // Transform the custom choices into Gravity Forms format
            $gf_choices = array_map(function ($choice) {
                return array(
                    'text' => $choice['value'],
                    'value' => $choice['value'],
                    'isSelected' => false,
                    'price' => '',
                    // Preserve the additional custom data
                    'icon' => $choice['icon'],
                    'description' => $choice['description'],
                    'message' => $choice['message'],
                );
            }, $custom_choices);

            // Update the field's choices
            $field->choices = $gf_choices;

            // Store complete custom data in field's customData property
            $field->customData = array(
                'choices' => $custom_choices
            );
        }
    }

    return $form;
}

add_filter('gform_field_content', 'customize_radio_field_markup', 10, 5);
function customize_radio_field_markup($content, $field, $value, $lead_id, $form_id)
{
    // Only modify radio field with ID 3 in form 7
    if ($form_id !== 7 || $field->type !== 'radio' || $field->id !== 3) {
        return $content;
    }

    // $output = '<fieldset id="field_7_3" class="gfield" data-js-reload="field_7_3">';
    $output  = '<legend class="!text-sm !font-medium !text-gray-900">' . esc_html($field->label) . '</legend>';
    $output .= '<div class="gfield_radio" id="input_7_3">';
    $output .= '<div class="mt-6 grid grid-cols-1 gap-4 sm:gap-y-6 sm:grid-cols-3 sm:gap-x-4">';

    foreach ($field->choices as $i => $choice) {
        $choice_id = 'choice_' . $form_id . '_' . $field->id . '_' . $i;
        $is_checked = $value == $choice['value'] ? 'checked="checked"' : '';

        $output .= sprintf(
            '<label aria-label="%1$s" class="group relative !flex !text-sm cursor-pointer rounded-lg border bg-white p-3 sm:p-4 shadow-sm focus:outline-none peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-600">',
            esc_attr($choice['value'])
        );

        $output .= sprintf(
            '<input type="radio" name="input_%d" id="%s" value="%s" %s class="peer sr-only">',
            $field->id,
            $choice_id,
            esc_attr($choice['value']),
            $is_checked
        );

        $output .= '<span class="flex flex-1">';
        $output .= '<span class="flex flex-col">';

        // Icon
        $output .= sprintf(
            '<span class="hidden mb-1 text-base text-gray-500" data-type="icon">%s</span>',
            $choice['icon']
        );

        // Value
        $output .= sprintf(
            '<span class="block text-sm sm:text-base/5 font-semibold antialiased text-gray-900 pr-4 pb-2" data-type="value" data-message="%s">%s</span>',
            esc_attr($choice['message']), // Add message as data attribute
            esc_html($choice['text'])
        );

        // Description
        $output .= sprintf(
            '<span class="mt-1 flex items-center text-pretty text-sm text-gray-500 leading-tight" data-type="description">%s</span>',
            esc_html($choice['description'])
        );

        $output .= '</span></span>';

        // Check icon
        $output .= '<svg class="size-5 text-indigo-600 invisible peer-checked:visible" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
        </svg>';

        // Border element
        $output .= '<span class="pointer-events-none absolute -inset-px rounded-lg border-2 peer-checked:border-indigo-600 border-transparent" aria-hidden="true"></span>';

        $output .= '</label>';
    }

    $output .= '</div></div></fieldset>';

    return $output;
}


add_filter('gform_form_post_get_meta', 'disable_chosen_for_select', 10, 1);
function disable_chosen_for_select($form)
{
    foreach ($form['fields'] as &$field) {
        if ($field->type == 'select') {
            $field->enableEnhancedUI = false;
        }
    }
    return $form;
}

// Filter for input elements only
add_filter('gform_field_input', 'custom_field_input', 10, 5);
function custom_field_input($input, $field, $value, $entry_id, $form_id)
{
    if ($field->type === 'section') {
        $content  = '<div class="border-b border-gray-900/10 pb-12">';
        $content .= '<h3 class="text-base/7 font-semibold text-gray-900">' . $field->label . '</h3>';
        $content .= '<p class="mt-1 text-sm/6 text-gray-600">' . $field->description . '</p>';
        $content .= '</div>';
        return $content;
    }
    // Text, Email, Tel inputs
    if (in_array($field->type, ['text', 'phone', 'email'])) {
        $id = $form_id . '_' . $field->id;
        $field_id = 'input_' . $id;

        $content = '<div class="mt-2">';
        $content .= '<input type="' . $field->type . '" ';
        $content .= 'name="input_' . $field->id . '" ';
        $content .= 'id="' . $field_id . '" ';
        $content .= 'value="' . esc_attr($value) . '" ';

        if (!empty($field->placeholder)) {
            $content .= 'placeholder="' . esc_attr($field->placeholder) . '" ';
        }

        if ($field->isRequired) {
            $content .= 'aria-required="true" ';
        }

        $content .= 'class="!block !w-full !rounded-md bg-white !px-3 !py-1.5 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 placeholder:!text-gray-400 focus:!outline focus:!outline-2 focus:!-outline-offset-2 focus:!outline-indigo-600 sm:!text-sm/6 !-mt-2">';
        $content .= '</div>';

        return $content;
    }

    // Textarea input
    if ($field->type == 'textarea') {
        $id = $form_id . '_' . $field->id;
        $field_id = 'input_' . $id;

        $content = '<div class="mt-2">';
        $content .= '<textarea ';
        $content .= 'name="input_' . $field->id . '" ';
        $content .= 'id="' . $field_id . '" ';

        if (!empty($field->placeholder)) {
            $content .= 'placeholder="' . esc_attr($field->placeholder) . '" ';
        }

        if ($field->isRequired) {
            $content .= 'aria-required="true" ';
        }

        $content .= 'class="!block !resize-y !w-full min-h-36 sm:!min-h-24 !rounded-md !bg-white !px-3 !py-1.5 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 placeholder:!text-gray-400 focus:!outline focus:!outline-2 focus:!-outline-offset-2 focus:!outline-indigo-600 sm:!text-sm/6 !-mt-2">';
        $content .= esc_textarea($value);
        $content .= '</textarea>';
        $content .= '</div>';

        return $content;
    }

    // Select input
    if ($field->type == "select") {
        $id = $form_id . '_' . $field->id;

        $content = '<div class="mt-2 grid grid-cols-1">';
        $content .= '<select name="input_' . $field->id . '" id="input_' . $id . '" ';
        $content .= 'class=" !col-start-1 !row-start-1 !w-full !appearance-none !rounded-md !bg-white !py-1.5 !pl-3 !pr-8 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 focus:!outline focus:!outline-2 focus:!-outline-offset-2 focus:!outline-indigo-600 sm:!text-sm/6 !-mt-2">';

        if ($field->placeholder) {
            $content .= '<option value="" selected="selected">' . esc_html($field->placeholder) . '</option>';
        }

        foreach ($field->choices as $choice) {
            $selected = $choice['isSelected'] ? ' selected="selected"' : '';
            $content .= '<option value="' . esc_attr($choice['value']) . '"' . $selected . '>' . esc_html($choice['text']) . '</option>';
        }

        $content .= '</select>';
        $content .= '<svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">';
        $content .= '<path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />';
        $content .= '</svg>';
        $content .= '</div>';

        return $content;
    }

    // Checkbox input
    if ($field->type == "checkbox") {
        $id = $form_id . '_' . $field->id;

        $content = '<div class=" !space-y-5 ginput_container ginput_container_checkbox">';
        $content .= '<div class="gfield_checkbox" id="input_' . $id . '">';

        $i = 1;
        foreach ($field->inputs as $input) {
            $input_state_classes = "checked:focus:!bg-current checked:hover:!bg-current checked:!bg-current checked:!ring-2";
            $input_id = $id . '_' . $i;
            $content .= '<div class="gchoice gchoice_' . $id . '_' . $i . ' !relative !flex !items-start">';
            $content .= '<div class=" !flex !h-6 !items-center">';
            $content .= '<input id="choice_' . $input_id . '" name="input_' . $input['id'] . '" value="';
            $content .= $field->choices[$i - 1]['value'] . '" ';
            $content .= 'type="checkbox" class="' . $input_state_classes . ' !h-4 !w-4 !rounded !border-gray-300 !text-indigo-600 !focus:ring-indigo-600">';
            $content .= '</div>';
            $content .= '<div class=" !ml-3 !text-sm !leading-6">';
            $content .= '<label for="choice_' . $input_id . '" id="label_' . $input_id . '" class=" !font-medium !text-gray-900">' . $input['label'] . '</label>';
            $content .= '</div>';
            $content .= '</div>';

            $i++;
        }

        $content .= '</div>';
        $content .= '</div>';

        return $content;
    }

    return $input;
}

add_filter('gform_field_content', function ($field_content, $field) {
    // Handle sections specifically
    if ($field->type === 'section') {
        return '<div class="py-6">
            <h3 class="text-lg/7 font-semibold text-gray-900">' . $field->label . '</h3>
            <p class="mt-1 text-sm/6 text-gray-600">' . $field->description . '</p>
        </div>';
    }

    // For all other fields, apply the label styling
    $field_content = preg_replace(
        '/<label([^>]*?)class=(["\'])(.*?)\2/i',
        '<label$1class=$2$3 !text-sm !font-medium !sm:text-base/6 !sm:font-semibold !sm:antialiased !text-gray-900$2',
        $field_content
    );

    // Handle case where label doesn't have a class attribute yet
    $field_content = preg_replace(
        '/<label(?![^>]*class=)/i',
        '<label class="text-sm/6 font-medium text-gray-900"',
        $field_content
    );

    return $field_content;
}, 10, 2);

/**
 * Add custom CSS classes to Gravity Forms submit buttons
 *
 * @param string $button_input The button HTML
 * @param object $form The form object
 * @return string Modified button HTML
 */
add_filter('gform_submit_button', function ($button_input, $form) {
    $dom = new DOMDocument();
    $dom->loadHTML($button_input, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $input = $dom->getElementsByTagName('input')->item(0);

    // Add custom classes
    $custom_classes = ' !w-full !rounded-md !border !border-transparent !bg-secondary-500 !px-4 !py-3 !text-base !font-medium !text-white !shadow-xs hover:!bg-secondary-600 focus:!ring-2 focus:!ring-secondary-500 focus:!ring-offset-2 focus:!ring-offset-gray-50 focus:!outline-hidden';

    // Get existing classes if any
    $existing_classes = $input->getAttribute('class');

    // Combine existing and new classes
    $all_classes = trim($existing_classes . ' ' . $custom_classes);

    // Set the combined classes
    $input->setAttribute('class', $all_classes);

    // Return the modified button HTML
    return $dom->saveHTML();
}, 10, 2);


// add_filter('gform_field_content', 'custom_radio_field_input_12', 10, 5);
// function custom_radio_field_input_12($content, $field, $value, $lead_id, $form_id)
// {
//     // Only modify radio field with ID 12
//     if (!$form_id === 7 && $field->type !== 'radio' || $field->id !== 3) {
//         return $content;
//     }

//     // Get custom choices data
//     $custom_choices = get_gf_args_input_12();

//     $output = '<fieldset>';
//     $output .= '<legend class="!text-base/6 !font-semibold !antialiased !text-gray-900">' . esc_html($field->label) . '</legend>';
//     $output .= '<div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-4 sm:gap-x-4">';

//     foreach ($custom_choices as $i => $choice) {
//         $choice_id = 'choice_' . $form_id . '_' . $field->id . '_' . $i;

//         $output .= sprintf(
//             '<label aria-label="%1$s" class="group relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-600">',
//             esc_attr($choice['value'])
//         );

//         $output .= sprintf(
//             '<input type="radio" name="input_%d" id="%s" value="%s" class="peer sr-only">',
//             $field->id,
//             $choice_id,
//             esc_attr($choice['value'])
//         );

//         $output .= '<span class="flex flex-1">';
//         $output .= '<span class="flex flex-col">';

//         // Icon (new)
//         $output .= sprintf(
//             '<span class="mb-1 text-base text-gray-500" data-type="icon">%s</span>',
//             $choice['icon']
//         );

//         // Main value
//         $output .= sprintf(
//             '<span class="block text-sm sm:text-base/5 font-semibold text-gray-900 pr-4" data-type="value">%s</span>',
//             esc_html($choice['value'])
//         );

//         // Description
//         $output .= sprintf(
//             '<span class="hidden mt-1 flex items-center text-pretty text-sm text-gray-500" data-type="description">%s</span>',
//             esc_html($choice['description'])
//         );

//         $output .= '</span></span>';

//         // Check icon
//         $output .= '<svg class="size-5 text-indigo-600 invisible peer-checked:visible" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
//             <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
//         </svg>';

//         // Border element
//         $output .= '<span class="pointer-events-none absolute -inset-px rounded-lg border-2 peer-checked:border-indigo-600 border-transparent" aria-hidden="true"></span>';

//         $output .= '</label>';
//     }

//     $output .= '</div></fieldset>';

//     return $output;
// }

// add_filter('gform_pre_render_7', 'customize_form_7_fields');
// add_filter('gform_pre_validation_7', 'customize_form_7_fields');
// add_filter('gform_pre_submission_filter_7', 'customize_form_7_fields');
// add_filter('gform_admin_pre_render_7', 'customize_form_7_fields');

// function customize_form_7_fields($form)
// {
//     // Only proceed if this is form ID 7
//     if ($form['id'] != 7) {
//         return $form;
//     }

//     // Loop through fields and hide all except field 7_3
//     foreach ($form['fields'] as &$field) {
//         if ($field->id != 3) {
//             $field->cssClass .= ' hidden opacity-0 transition-all duration-300';
//         }
//     }

//     return $form;
// }
