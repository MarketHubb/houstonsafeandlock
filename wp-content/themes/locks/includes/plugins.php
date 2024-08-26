<?php
function acf_load_brand_options($field)
{
    $field['choices'] = array();
    $choices = get_field('filter_brand', 'option');
    $choices = explode("\n", $choices);
    $choices = array_map('trim', $choices);

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][$choice] = $choice;
        }
    }
    return $field;
}
add_filter('acf/load_field/key=field_5dbc53014ffce', 'acf_load_brand_options');

function acf_load_fire_rating_options($field)
{
    $field['choices'] = array();
    $choices = get_field('filter_fire_ratings', 'option');
    $choices = explode("\n", $choices);
    $choices = array_map('trim', $choices);

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][$choice] = $choice;
        }
    }
    return $field;
}
add_filter('acf/load_field/key=field_65c7de5dfb437', 'acf_load_fire_rating_options');

function acf_load_security_rating_options($field)
{
    $field['choices'] = array();
    $choices = get_field('filter_security_ratings', 'option');
    $choices = explode("\n", $choices);
    $choices = array_map('trim', $choices);

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][$choice] = $choice;
        }
    }
    return $field;
}
add_filter('acf/load_field/key=field_65d6932499483', 'acf_load_security_rating_options');

function acf_load_safe_attributes_for_warranty($field)
{
    $field['choices'] = array();
    $attributes = get_field('attributes', 'option');
    $choices = [];

    foreach ($attributes as $attribute) {
        $field_name = $attribute['acf_field'];
        $attribute_name = $attribute['attribute'];
        if (isset($field_name) && isset($attribute_name)) {
            $choices[] = [
                'field' => $field_name,
                'name' => $attribute_name
            ];
        }
    }

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][$choice['field']] = $choice['name'];
        }
    }
    return $field;
}
add_filter('acf/load_field/key=field_66c4ba2cb4289', 'acf_load_safe_attributes_for_warranty');
