<?php

add_action('wp_enqueue_scripts', 'dequeue_gravity_assets', 100);
function dequeue_gravity_assets()
{
    if (is_page_template('page-templates/gravity-test.php')) {
        wp_dequeue_style('locks-style');
        wp_dequeue_style('gform_theme');
        wp_enqueue_style('tw-gforms', get_template_directory_uri() . '/css/tw-gforms.css');
    }
}

add_filter('gform_field_content_10', 'gform_field_label', 10, 5);
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

add_filter('gform_field_input_10', 'format_gf_inputs', 10, 5);
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

        if ($field->type === 'date') {
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

        if ($field->calendarIconType === 'calendar') {
            $input .= '<input type="hidden" id="gforms_calendar_icon_input_' . $field->formId . '_' . $field->id . '" class="gform_hidden" ';
            $input .= 'value="' . get_home_url() . '/wp-content/plugins/gravityforms/images/datepicker/datepicker.svg" data-conditional-logic="visible">';
        }
    }

    if ($field->type === 'checkbox') {
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
