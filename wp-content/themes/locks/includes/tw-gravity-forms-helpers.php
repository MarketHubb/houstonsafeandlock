<?php
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

        $choices .= '<div class="gchoice gchoice_' . $field_key . ' mb-4">';
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

function gform_input_container_open($field_type, $extra_class = '')
{
    $classes = 'ginput_container ginput_container_' . $field_type;
    if (!empty($extra_class)) {
        $classes .= ' ' . $extra_class;
    }
    return '<div class="' . $classes . '">';
}
