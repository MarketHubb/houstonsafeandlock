<?php
/**
 * Generates CSS classes for choice input fields (radio buttons or checkboxes).
 *
 * This function returns a string of CSS classes to be applied to radio buttons
 * or checkboxes in Gravity Forms. Different classes are applied based on the field type.
 *
 * @param object $field The Gravity Forms field object containing field properties.
 * @return string A space-separated string of CSS classes for the input element.
 */
function gform_input_choices_classes($field)
{
    $classes = 'gfield-choice-input ';

    if ($field->type === 'radio') {
        $classes .= 'relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-blue-600 checked:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden';
    }

    if ($field->type === 'checkbox') {
        $classes .= 'appearance-none rounded-sm border border-gray-300 bg-white checked:bg-blue-600 checked:outline-1 focus:checked:bg-blue-600 hover:checked:bg-blue-600 checked:border-blue-600 checked:bg-blue-600 indeterminate:border-blue-600 indeterminate:bg-blue-600 focus:outline-0 focus:ring-0 focus-visible:outline-0 focus-visible:outline-offset-0 focus-visible:outline-blue-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto';
    }

    return $classes;
}

/**
 * Generates HTML markup for radio button or checkbox choice fields.
 *
 * This function creates the complete HTML structure for radio button or checkbox
 * choice fields in Gravity Forms, including the input elements and their labels.
 *
 * @param object $field The Gravity Forms field object containing field properties and choices.
 * @return string|null HTML markup for the choice fields, or null if the field is empty or not a choice field.
 */
function gform_input_choices($field)
{
    $choice_fields = ['radio', 'checkbox'];

    if (empty($field) || !in_array($field->type, $choice_fields)) return;

    $input_count = $field->type === 'radio'
        ? 0
        : 1;

    $choices = '';

    foreach ($field->choices as $choice) {
        $name_val = $field->type === 'radio'
            ? 'input_' . $field->id
            : 'input_' . $field->formId . '.' . $field->id;
        $field_key = $field->formId . '_' . $field->id . '_' . $input_count;

        $choices .= '<div class="gchoice gchoice_' . $field_key . ' mb-2">';
        $choices .= '<input class="' . gform_input_choices_classes($field) . '" ';
        $choices .= 'name="' . $name_val . '" type="' . $field->type . '" ';
        $choices .= 'value="' . $choice['value'] . '" id="choice_' . $field_key . '" ';
        $choices .= 'onchange="gformToggleRadioOther( this )" tabindex="10" ';

        if ($choice['isSelected']) {
            $choices .= 'checked ';
        }

        $choices .= '>';
        $choices .= '<label for="choice_' . $field_key . '" id="label_' . $field_key . '" class="gform-field-label gform-field-label--type-inline ml-3 text-base font-medium text-gray-900">';
        $choices .= $choice['text'];
        $choices .= '</label>';
        $choices .= '</div>';


        $input_count++;
    }

    return $choices ?? null;
}

/**
 * Generates the opening HTML for a Gravity Forms input container.
 *
 * This function creates the opening div tag with appropriate classes for a
 * Gravity Forms input container based on the field type.
 *
 * @param string $field_type The type of field (e.g., 'text', 'radio', 'checkbox').
 * @param string $extra_class Optional. Additional CSS classes to add to the container.
 * @return string HTML markup for the opening container div.
 */
function gform_input_container_open($field_type, $extra_class = '')
{
    $classes = 'ginput_container ginput_container_' . $field_type;
    if (!empty($extra_class)) {
        $classes .= ' ' . $extra_class;
    }
    return '<div class="' . $classes . '">';
}

/**
 * Retrieves data for product modal tabs.
 *
 * This function returns an array of data used to build tabs in a product modal,
 * including tab names, descriptions, icons, and content.
 *
 * @return array An array of tab data with keys for 'name', 'description', 'icon', and 'content'.
 */
function get_product_modal_tabs_data()
{
    return [
        [
            'name' => 'Contact',
            'description' => 'To start or place an order for this safe',
            'icon' => '<i class="fa-light fa-inbox-in"></i>',
            'content' => do_shortcode('[gravityform id="7" title="false" description="false" ajax="false" tabindex="10"]')
        ],
        [
            'name' => 'Visit',
            'description' => 'One of our two Houston locations',
            'icon' => '<i class="fa-light fa-shop"></i>',
            'content' => 'Visit content'
        ]
    ];
}

/**
 * Retrieves data for Gravity Forms input field #12 options.
 *
 * This function returns an array of data used to populate options for
 * input field #12 in a Gravity Form, including icons, values, descriptions, and messages.
 *
 * @return array An array of option data with keys for 'icon', 'value', 'description', and 'message'.
 */
function get_gf_args_input_12()
{
    return [
        [
            'icon' => '<i class="fa-light fa-vault"></i>',
            'value' => 'Product information',
            'description' => 'Specs or product recommendations by certified safe experts',
            'message' => 'Product questions or comments'
        ],
        [
            'icon' => '<i class="fa-light fa-truck"></i>',
            'value' => 'Delivery information',
            'description' => 'Pickup & delivery options + custom installation quotes',
            'message' => 'Delivery questions or comments'
        ],
        [
            'icon' => '<i class="fa-light fa-square-question"></i>',
            'value' => 'Need something else?',
            'description' => 'Ask a question or leave a comment - our team is here to help you',
            'message' => 'Questions or comments?'
        ],
    ];
}

/**
 * Retrieves callout data for safe products.
 *
 * This function returns an array of callout messages specifically for safe products,
 * with different text versions for desktop and mobile displays, along with icons.
 *
 * @return array An array of callout data with keys for 'desktop', 'mobile', and 'icon'.
 */
function get_gf_callouts_safes()
{
    return [
        [
            'desktop' => 'Get our guaranteed best price',
            'mobile' => 'Get guaranteed best price',
            'icon' => '<i class="fa-light fa-tags"></i>'
        ],
        [
            'desktop' => 'Setup pickup or delivery options',
            'mobile' => 'Setup pickup or delivery',
            'icon' => '<i class="fa-light fa-truck"></i>'
        ],
        [
            'desktop' => 'Review available safe customizations',
            'mobile' => 'Review safe customizations',
            'icon' => '<i class="fa-light fa-vault"></i>'
        ],
    ];
}

/**
 * Retrieves callout data for locksmith services.
 *
 * This function returns an array of callout messages specifically for locksmith services,
 * with different text versions for desktop and mobile displays, along with icons.
 *
 * @return array An array of callout data with keys for 'desktop', 'mobile', and 'icon'.
 */
function get_gf_callouts_locksmith()
{
    return [
        [
            'desktop' => 'Fast, 24/7 emergency locksmiths',
            'mobile' => '24/7 emergency locksmiths',
            'icon' => '<i class="fa-light fa-key"></i>'
        ],
        [
            'desktop' => 'Licensed, bonded and insured',
            'mobile' => 'Licensed, bonded & insured',
            'icon' => '<i class="fa-light fa-badge-check"></i>'
        ],
        [
            'desktop' => 'Home and business services',
            'mobile' => 'Home & business services',
            'icon' => '<i class="fa-light fa-house-lock"></i>'
        ],
    ];
}

/**
 * Retrieves callout data for safe move services.
 *
 * This function returns an array of callout messages specifically for safe move services,
 * with different text versions for desktop and mobile displays, along with icons.
 *
 * @return array An array of callout data with keys for 'desktop', 'mobile', and 'icon'.
 */
function get_gf_callouts_safe_move()
{
    return [
        [
            'desktop' => 'Discrete, in-house moving team',
            'mobile' => 'In-house moving team',
            'icon' => '<i class="fa-light fa-person-dolly-empty"></i>'
        ],
        [
            'desktop' => 'Licensed, bonded and insured',
            'mobile' => 'Licensed, bonded & insured',
            'icon' => '<i class="fa-light fa-badge-check"></i>'
        ],
        [
            'desktop' => 'Home and business services',
            'mobile' => 'Home & business services',
            'icon' => '<i class="fa-light fa-house-lock"></i>'
        ],
    ];
}

/**
 * Determines and retrieves the appropriate header callouts based on the queried object.
 *
 * This function returns either safe-related or locksmith-related callouts
 * depending on whether the queried object is a product post type.
 *
 * @param object|null $queried_object Optional. The queried object from WordPress.
 * @return array An array of callout data appropriate for the context.
 */
function get_gf_header_callouts($queried_object = null)
{
    $id = get_queried_object_id();

    if (is_safe_page()) {
        return get_gf_callouts_safes();
    }

    if (is_locksmith_page($id)) {
        return get_gf_callouts_locksmith();
    }

    if (is_safe_move_page($id)) {
        return get_gf_callouts_safe_move();
    }

    return null;

    // return !empty($queried_object) && $queried_object->post_type === 'product'
    //     ? get_gf_callouts_safes()
    //     : get_gf_callouts_locksmith();
}
