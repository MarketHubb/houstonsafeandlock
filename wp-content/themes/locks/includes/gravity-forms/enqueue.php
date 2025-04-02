<?php

/**
 * Enqueue Gravity Forms custom scripts as ES modules
 */
function gfe_enqueue_scripts()
{
    // Only enqueue on pages with Gravity Forms
    if (is_page('9385') && function_exists('gravity_form')) {
        // Register validation script
        wp_register_script(
            'gfe-preline-script',
            get_template_directory_uri() . '/js/gform/preline.js',
            [], // No dependencies
            filemtime(get_template_directory() . '/js/gform/preline.js'), // Version based on file modification time
            true // Load in footer
        );

        // Register submit script
        wp_register_script(
            'gfe-submit-script',
            get_template_directory_uri() . '/js/gform/submit.js',
            [], // No dependencies - the import is handled by the module system
            filemtime(get_template_directory() . '/js/gform/submit.js'), // Version based on file modification time
            true // Load in footer
        );

        // Actually enqueue the scripts (this was missing in your code)
        wp_enqueue_script('gfe-preline-script');
        wp_enqueue_script('gfe-submit-script');
    }
}
add_action('wp_enqueue_scripts', 'gfe_enqueue_scripts');

/**
 * Add type="module" to specific scripts
 */
function add_type_attribute($tag, $handle, $src)
{
    // List of script handles that should be loaded as modules
    $module_scripts = ['gfe-preline-script', 'gfe-submit-script'];

    if (in_array($handle, $module_scripts)) {
        // Remove any existing type attributes
        $tag = preg_replace('/\s*type=(["\']).*?\1/', '', $tag);
        // Add the module type attribute
        $tag = str_replace('<script ', '<script type="module" ', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute', 10, 3);
