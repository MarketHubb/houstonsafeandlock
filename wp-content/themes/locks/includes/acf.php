
<?php
/**
 * Advanced Custom Fields Configuration
 *
 * @package locks
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register ACF Options Pages
 * 
 * - Theme Settings: General theme configuration options
 * - Alerts: Global alert messages and notifications
 * - Global Safes: Safe-specific settings and configurations
 * - Global Locksmith: Locksmith service settings and configurations
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
 * Dynamically populate select field for safe category alerts
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
