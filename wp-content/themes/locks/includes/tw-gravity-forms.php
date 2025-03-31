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

add_filter('gform_field_input', 'format_gf_inputs', 10, 5);
function format_gf_inputs($input, $field, $value, $entry_id, $form_id)
{
    $modified_input = false;

    if (!is_admin()) {
        $input_types = ['text', 'email', 'phone'];

        if (in_array($field->type, $input_types)) {
            $modified_input = true;

            $input_type = $field->type !== 'phone'
                ? $field->type
                : 'tel';

            $input  = gform_input_container_open($field->type);
            $input .= '<input value="" type="' . $input_type . '" name="input_' . $field->id . '" id="input_' . $field->formId . '_' . $field->id . '" ';
            $input .= 'aria-invalid="false" ';
            $input .= 'class="block w-full rounded-md bg-white px-3 py-1.5 !border-transparent !text-base !py-[6px] !px-[12px] text-gray-900 outline outline-1 outline-solid -outline-offset-1 outline-gray-400/85 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600" ';

            if ($field->isRequired) {
                $input .= 'aria-required="true" required ';
            }

            $input .= '>';
        }

        if ($field->type === 'select') {
            $modified_input = true;
            $input  = gform_input_container_open($field->type, 'max-w-xs');
            $input .= '<select type="' . $field->type . '" name="input_' . $field->id . '" id="input_' . $field->formId . '_' . $field->id . '" ';
            $input .= 'class="appearance-none rounded-md w-full bg-white !py-1.5 !pl-3 !pr-10 !text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600">';

            if (!empty($field->choices)) {
                foreach ($field->choices as $choice) {
                    $input .= '<option value="' . $choice['value'] . '" ';

                    if ($choice['isSelected']) {
                        $input .= 'checked ';
                    }

                    $input .= '>';
                    $input .=  $choice['text'];
                    $input .=  '</option>';
                }
            }

            $input .= '</select>';
        }

        if ($field->type === 'radio' || $field->type === 'checkbox') {
            $modified_input = true;
            $input  = gform_input_container_open($field->type);
            $input .= '<div class="gfield_' . $field->type . '" id="input_' . $field->formId . '_' . $field->id . '">';

            if (!empty($field->choices)) {
                $input .= gform_input_choices($field);
            }

            $input .= '</div>';
        }

        if ($field->type === false) {
            // if ($field->type === 'date') {
            $modified_input = true;
            $field_key = $field->formId . '_' . $field->id;

            $input = gform_input_container_open($field->type);
            $input .= '<input name="input_' . $field->id . '" id="input_' . $field_key . '" type="text" value="" ';
            $input .= 'class="datepicker gform-datepicker mdy datepicker_with_icon gdatepicker_with_icon hasDatepicker text-gray-900 font-semibold !py-1.5 !pl-3 !text-base outline outline-1 outline-solid -outline-offset-1 outline-gray-400/85 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 !border-0 rounded-md" ';
            $input .= 'tabindex="19" placeholder="mm/dd/yyyy" aria-describedby="input_' . $field->formId . '_' . $field->id . '_date_format" aria-invalid="false" data-conditional-logic="visible">';
            $input .= '<span id="input_' . $field->formId . '_' . $field->id . '_date_format" class="screen-reader-text">MM slash DD slash YYYY</span>';
        }

        if ($modified_input) {
            $input = $input . '</div>';
        }

        // if ($field->calendarIconType === 'calendar') {
        //     $input .= '<input type="hidden" id="gforms_calendar_icon_input_' . $field->formId . '_' . $field->id . '" class="gform_hidden" ';
        //     $input .= 'value="' . get_home_url() . '/wp-content/plugins/gravityforms/images/datepicker/datepicker.svg" data-conditional-logic="visible">';
        // }
    }

    if ($field->type == 'textarea') {
        $modified_input = true;
        $input  = gform_input_container_open($field->type);

        $id = $form_id . '_' . $field->id;
        $field_id = 'input_' . $id;

        $input .= '<div class="mt-2">';
        $input .= '<textarea ';
        $input .= 'name="input_' . $field->id . '" ';
        $input .= 'id="' . $field_id . '" ';

        if (!empty($field->placeholder)) {
            $input .= 'placeholder="' . esc_attr($field->placeholder) . '" ';
        }

        if ($field->isRequired) {
            $input .= 'aria-required="true" ';
        }

        $input .= 'class="!block !resize-y !w-full min-h-36 sm:!min-h-24 !rounded-md !bg-white !px-3 !py-1.5 !text-base !text-gray-900 !outline !outline-1 !-outline-offset-1 !outline-gray-300 placeholder:!text-gray-400 focus:!outline focus:!outline-2 focus:!-outline-offset-2 focus:!outline-indigo-600 sm:!text-sm/6">';
        $input .= esc_textarea($value);
        $input .= '</textarea>';
        $input .= '</div></div>';
    }

    return $input;
}

add_action('wp_footer', 'reinitialize_datepickers', 99);
function reinitialize_datepickers()
{
    if (is_page_template('page-templates/gravity-test.php')) {
?>
        <script>
            jQuery(document).ready(function($) {
                // Log for debugging
                console.log('Datepicker elements:', $('.datepicker').length);

                // Remove existing datepicker initialization
                $('.datepicker').removeClass('hasDatepicker initialized');

                // Reinitialize datepickers
                if (typeof gformInitDatepicker === 'function') {
                    console.log('Using Gravity Forms initialization');
                    gformInitDatepicker();
                } else {
                    console.log('Using fallback initialization');
                    // Fallback if Gravity Forms function isn't available
                    $('.datepicker').each(function() {
                        $(this).datepicker({
                            dateFormat: 'mm/dd/yy',
                            showOn: 'both',
                            buttonImage: $(this).siblings('.ui-datepicker-trigger').attr('src'),
                            buttonImageOnly: true
                        });

                        // Log successful initialization
                        console.log('Initialized datepicker for:', $(this).attr('id'));
                    });
                }
            });
        </script>
<?php
    }
}

add_filter('gform_submit_button_14', 'input_to_button', 10, 2);
function input_to_button($button, $form)
{
    $fragment = WP_HTML_Processor::create_fragment($button);
    $fragment->next_token();

    $attributes = array('id', 'type', 'class', 'onclick');
    $new_attributes = array();
    foreach ($attributes as $attribute) {
        $value = $fragment->get_attribute($attribute);
        if (! empty($value)) {
            $new_attributes[] = sprintf('%s="%s"', $attribute, esc_attr($value));
        }
    }

    return sprintf('<button %s>%s</button>', implode(' ', $new_attributes), esc_html($fragment->get_attribute('value')));
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
