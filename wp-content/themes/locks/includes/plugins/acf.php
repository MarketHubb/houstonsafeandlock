<?php

/**
 * Registers Advanced Custom Fields (ACF) options pages for the WordPress admin.
 *
 * This code block creates multiple options pages using ACF's API:
 * - Theme Settings
 * - Alerts Configuration
 * - Sales & Promotions
 * - Global settings
 * - Global Safe Settings
 * - Global Locksmith Settings
 *
 * Each options page provides a centralized location for managing site-wide settings.
 * The code only executes if the ACF plugin is active and the function exists.
 */
if (function_exists('acf_add_options_page')) {
    // Theme Settings
    acf_add_options_page('Theme Settings');

    // Alerts Configuration
    acf_add_options_page(array(
        'page_title' => 'Alerts',
        'menu_title' => 'Alerts',
        'menu_slug'  => 'global-alerts',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));

    acf_add_options_page(array(
        'page_title' => 'Sales & Promotions',
        'menu_title' => 'Sales & Promos',
        'menu_slug'  => 'sales-promotions',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));

    acf_add_options_page(array(
        'page_title' => 'Global',
        'menu_title' => 'Global',
        'menu_slug'  => 'global',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));

    // Global Safe Settings
    acf_add_options_page(array(
        'page_title' => 'Global - Safes',
        'menu_title' => 'Safes',
        'menu_slug'  => 'safe-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));

    // Global Locksmith Settings
    acf_add_options_page(array(
        'page_title' => 'Global - Locksmith',
        'menu_title' => 'Locksmith',
        'menu_slug'  => 'locksmith-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));
}

/**
 * Dynamically populates an ACF select field with safe categories from the product_cat taxonomy.
 *
 * This function retrieves all top-level product categories (those without parents)
 * and adds them as choices to the specified ACF select field. It's specifically
 * used for the safe category alerts field.
 *
 * @param array $field The ACF field array being loaded.
 * @return array The modified field array with populated choices.
 */
function acf_populate_safe_alert_select_field_choices($field)
{
    $field['choices'] = array();

    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
    ));

    $choices = array();

    foreach ($terms as $term) {
        if (!$term->parent) {
            $choices[] = array($term->term_id, $term->name);
        }
    }

    if (is_array($choices)) {
        foreach ($choices as $key => $value) {
            $field['choices'][$value[0]] = $value[1];
        }
    }

    return $field;
}
add_filter('acf/load_field/key=field_5dea8663fe06f', 'acf_populate_safe_alert_select_field_choices');

/**
 * Dynamically populates an ACF select field with brand options.
 *
 * This function retrieves brand options from an ACF options field, parses them,
 * and adds them as choices to the specified ACF select field. The source data
 * is expected to be a newline-separated list of brands.
 *
 * @param array $field The ACF field array being loaded.
 * @return array The modified field array with populated brand choices.
 */
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

/**
 * Dynamically populates an ACF select field with fire rating options.
 *
 * This function retrieves fire rating options from an ACF options field, parses them,
 * and adds them as choices to the specified ACF select field. The source data
 * is expected to be a newline-separated list of fire ratings.
 *
 * @param array $field The ACF field array being loaded.
 * @return array The modified field array with populated fire rating choices.
 */
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

/**
 * Dynamically populates an ACF select field with security rating options.
 *
 * This function retrieves security rating options from an ACF options field, parses them,
 * and adds them as choices to the specified ACF select field. The source data
 * is expected to be a newline-separated list of security ratings.
 *
 * @param array $field The ACF field array being loaded.
 * @return array The modified field array with populated security rating choices.
 */
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

/**
 * Dynamically populates an ACF select field with safe attributes for warranty options.
 *
 * This function retrieves safe attributes from an ACF options field and formats them
 * as choices for the specified ACF select field. It maps the ACF field names to
 * their corresponding attribute display names.
 *
 * @param array $field The ACF field array being loaded.
 * @return array The modified field array with populated safe attribute choices.
 */
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
