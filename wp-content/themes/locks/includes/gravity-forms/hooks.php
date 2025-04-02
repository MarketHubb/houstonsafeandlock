<?php
add_action('wp_enqueue_scripts', 'dequeue_gravity_assets', 100);
function dequeue_gravity_assets()
{
    if (is_page('9385') || is_singular('product')) {
        wp_dequeue_style('locks-style');
        wp_dequeue_style('gform_theme');
        wp_enqueue_style('tw-gforms', get_template_directory_uri() . '/css/tw-gforms.css');
    }
}

add_filter('gform_field_input', 'custom_field_input', 10, 5);
function custom_field_input($input, $field, $value, $entry_id, $form_id)
{
    // If we are in the admin editor or entries screen, bail.
    if (GFCommon::is_form_editor() || GFCommon::is_entry_detail()) {
        return $input;
    }

    // Skip radio fields so they are handled by customize_radio_field_markup only
    if ($field->type === 'radio') {
        return $input;
    }
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

        $content .= 'class="!block !w-full !rounded-md bg-white !px-3 !py-1.5 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 placeholder:!text-gray-400 focus:!outline focus:!outline-2 focus:!outline-brand-375 sm:!text-sm/6 !-mt-2">';
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

        $content .= 'class="!block !resize-y !w-full min-h-36 sm:!min-h-24 !rounded-md !bg-white !px-3 !py-1.5 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 placeholder:!text-gray-400 focus:!outline focus:!outline-2 focus:!outline-brand-375 sm:!text-sm/6 !-mt-2">';
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
        $content .= 'class=" !col-start-1 !row-start-1 !w-full !appearance-none !rounded-md !bg-white !py-1.5 !pl-3 !pr-8 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 focus:!outline focus:!outline-2 i focus:!outline-brand-375 sm:!text-sm/6 !-mt-2">';

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

add_filter('gform_field_content', 'gform_field_label', 10, 5);
function gform_field_label($content, $field, $value, $lead_id, $form_id)
{
    $fields_mb = ['select', 'radio', 'date'];

    $label_mb = in_array($field->type, $fields_mb)
        ? '!mb-4 '
        : '';
    $classes = $label_mb . 'block !mb-2 !text-base/6 !font-semibold antialiased !text-gray-900';

    if (str_contains($content, 'gfield_label gform-field-label')) {
        $content = str_replace('gfield_label gform-field-label', 'gfield_label gform-field-label ' . $classes, $content);
    }

    return $content;
}

add_filter('gform_field_content', 'radio_field_card', 10, 5);
function radio_field_card($content, $field, $value, $lead_id, $form_id)
{
    if (!is_admin()) {
        if ($field->type === 'radio' && str_contains($field->cssClass, 'cards')) {
            // $output = '<fieldset id="field_7_3" class="gfield" data-js-reload="field_7_3">';
            $output  = '<legend class="!text-sm !font-medium !text-gray-900">' . esc_html($field->label) . '</legend>';
            $output .= '<div class="gfield_radio" id="input_7_3">';
            $output .= '<div class="mt-6 grid grid-cols-1 gap-4 sm:gap-y-6 sm:grid-cols-3 sm:gap-x-4">';

            foreach ($field->choices as $i => $choice) {
                $choice_id = 'choice_' . $form_id . '_' . $field->id . '_' . $i;
                $is_checked = $value == $choice['value'] ? 'checked="checked"' : '';

                $output .= sprintf(
                    '<label aria-label="%1$s" class="group relative !flex !text-sm cursor-pointer rounded-lg border bg-white p-3 sm:p-4 shadow-sm focus:outline-none peer-checked:border-brand-375 peer-checked:ring-2 peer-checked:ring-brand-375">',
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
                $output .= '<svg class="size-5 text-brand-375 invisible peer-checked:visible" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
        </svg>';

                // Border element
                $output .= '<span class="pointer-events-none absolute -inset-px rounded-lg border-2 peer-checked:border-brand-375 border-transparent" aria-hidden="true"></span>';

                $output .= '</label>';
            }

            $output .= '</div></div></fieldset>';

            return $output;
        }
    }

    return $content;
}

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


/*
REVIEW
*/


// add_action('wp_enqueue_scripts', function () {
//     gravity_form_enqueue_scripts(7, true); // 7 is your form ID
// });

// add_filter('gform_form_args', function ($args) {
//     $args['submission_method'] = GFFormDisplay::SUBMISSION_METHOD_AJAX;
//     return $args;
// });


// add_filter('gform_field_input', 'format_gf_inputs', 10, 5);
// function format_gf_inputs($input, $field, $value, $entry_id, $form_id)
// {
//     $modified_input = false;

//     if (!is_admin()) {
//         $input_types = ['text', 'email', 'phone'];

//         if (in_array($field->type, $input_types)) {
//             $modified_input = true;

//             $input_type = $field->type !== 'phone'
//                 ? $field->type
//                 : 'tel';

//             $input  = gform_input_container_open($field->type);
//             $input .= '<input value="" type="' . $input_type . '" name="input_' . $field->id . '" id="input_' . $field->formId . '_' . $field->id . '" ';
//             $input .= 'aria-invalid="false" ';
//             $input .= 'class="block w-full rounded-md bg-white px-3 py-1.5 !border-transparent !text-base !py-[6px] !px-[12px] text-gray-900 outline outline-1 outline-solid -outline-offset-1 outline-gray-400/85 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600" ';

//             if ($field->isRequired) {
//                 $input .= 'aria-required="true" required ';
//             }

//             $input .= '>';
//         }

//         if ($field->type === 'select') {
//             $modified_input = true;
//             $input  = gform_input_container_open($field->type, 'max-w-xs');
//             $input .= '<select type="' . $field->type . '" name="input_' . $field->id . '" id="input_' . $field->formId . '_' . $field->id . '" ';
//             $input .= 'class="appearance-none rounded-md w-full bg-white !py-1.5 !pl-3 !pr-10 !text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600">';

//             if (!empty($field->choices)) {
//                 foreach ($field->choices as $choice) {
//                     $input .= '<option value="' . $choice['value'] . '" ';

//                     if ($choice['isSelected']) {
//                         $input .= 'checked ';
//                     }

//                     $input .= '>';
//                     $input .=  $choice['text'];
//                     $input .=  '</option>';
//                 }
//             }

//             $input .= '</select>';
//         }

//         if ($field->type === 'radio' || $field->type === 'checkbox') {
//             $modified_input = true;
//             $input  = gform_input_container_open($field->type);
//             $input .= '<div class="gfield_' . $field->type . '" id="input_' . $field->formId . '_' . $field->id . '">';

//             if (!empty($field->choices)) {
//                 $input .= gform_input_choices($field);
//             }

//             $input .= '</div>';
//         }

//         if ($field->type === false) {
//             // if ($field->type === 'date') {
//             $modified_input = true;
//             $field_key = $field->formId . '_' . $field->id;

//             $input = gform_input_container_open($field->type);
//             $input .= '<input name="input_' . $field->id . '" id="input_' . $field_key . '" type="text" value="" ';
//             $input .= 'class="datepicker gform-datepicker mdy datepicker_with_icon gdatepicker_with_icon hasDatepicker text-gray-900 font-semibold !py-1.5 !pl-3 !text-base outline outline-1 outline-solid -outline-offset-1 outline-gray-400/85 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 !border-0 rounded-md" ';
//             $input .= 'tabindex="19" placeholder="mm/dd/yyyy" aria-describedby="input_' . $field->formId . '_' . $field->id . '_date_format" aria-invalid="false" data-conditional-logic="visible">';
//             $input .= '<span id="input_' . $field->formId . '_' . $field->id . '_date_format" class="screen-reader-text">MM slash DD slash YYYY</span>';
//         }

//         if ($modified_input) {
//             $input = $input . '</div>';
//         }

//         // if ($field->calendarIconType === 'calendar') {
//         //     $input .= '<input type="hidden" id="gforms_calendar_icon_input_' . $field->formId . '_' . $field->id . '" class="gform_hidden" ';
//         //     $input .= 'value="' . get_home_url() . '/wp-content/plugins/gravityforms/images/datepicker/datepicker.svg" data-conditional-logic="visible">';
//         // }
//     }

//     if ($field->type == 'textarea') {
//         $modified_input = true;
//         $input  = gform_input_container_open($field->type);

//         $id = $form_id . '_' . $field->id;
//         $field_id = 'input_' . $id;

//         $input .= '<div class="mt-2">';
//         $input .= '<textarea ';
//         $input .= 'name="input_' . $field->id . '" ';
//         $input .= 'id="' . $field_id . '" ';

//         if (!empty($field->placeholder)) {
//             $input .= 'placeholder="' . esc_attr($field->placeholder) . '" ';
//         }

//         if ($field->isRequired) {
//             $input .= 'aria-required="true" ';
//         }

//         $input .= 'class="!block !resize-y !w-full min-h-36 sm:!min-h-24 !rounded-md !bg-white !px-3 !py-1.5 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 placeholder:!text-gray-400 focus:!outline focus:!outline-2 focus:!-outline-offset-2 focus:!outline-indigo-600 sm:!text-sm/6">';
//         $input .= esc_textarea($value);
//         $input .= '</textarea>';
//         $input .= '</div></div>';
//     }

//     return $input;
// }

// add_filter('gform_submit_button_14', 'input_to_button', 10, 2);
// function input_to_button($button, $form)
// {
//     $fragment = WP_HTML_Processor::create_fragment($button);
//     $fragment->next_token();

//     $attributes = array('id', 'type', 'class', 'onclick');
//     $new_attributes = array();
//     foreach ($attributes as $attribute) {
//         $value = $fragment->get_attribute($attribute);
//         if (! empty($value)) {
//             $new_attributes[] = sprintf('%s="%s"', $attribute, esc_attr($value));
//         }
//     }

//     return sprintf('<button %s>%s</button>', implode(' ', $new_attributes), esc_html($fragment->get_attribute('value')));
// }

