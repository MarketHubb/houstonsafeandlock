<?php

/**
 * Enqueue scripts and styles for Locks theme
 *
 * @package locks
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function enqueue_zipcode_distance()
{
    wp_enqueue_script(
        'zipcode-distance',
        get_template_directory_uri() . '/js/dist/distance-calculator.bundle.js',
        array(),
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'delivery-calculator',
        get_template_directory_uri() . '/js/delivery-calculator.js',
        array('zipcode-distance'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_zipcode_distance');

function enqueue_product_category_scripts()
{
    wp_enqueue_script('tw-product-category-script', get_template_directory_uri() . '/js/tw-safe-cat.js', array('jquery'), '1.0', true);
    wp_enqueue_script('tw-filters', get_template_directory_uri() . '/js/tw-filters.js', array('jquery'), '1.0', true);
    wp_enqueue_style('tw-product-category-style', get_template_directory_uri() . '/css/tw-safe-cat.css', array(), '1.0');
}

function conditionally_enqueue_product_category_assets()
{
    if (is_tax('product_cat') || is_page(3901)) {
        enqueue_product_category_scripts();
    }
}
add_action('wp_enqueue_scripts', 'conditionally_enqueue_product_category_assets');

function enqueue_product_single_scripts()
{
    wp_enqueue_script('custom-accordion', get_template_directory_uri() . '/js/accordion.js', array(), '1.0', true);
}

function conditionally_enqueue_product_single_assets()
{
    if (is_singular('product')) {
        enqueue_product_single_scripts();
    }
}
add_action('wp_enqueue_scripts', 'conditionally_enqueue_product_single_assets');

function enqueue_preline_script()
{
    $website_root = ABSPATH;
    $preline_path = $website_root . 'node_modules/preline/dist/preline.js';

    if (file_exists($preline_path)) {
        $preline_url = str_replace(ABSPATH, site_url('/'), $preline_path);
        $preline_url = preg_replace('/([^:])(\/\/+)/', '$1/', $preline_url);
        wp_enqueue_script('preline', $preline_url, array(), '1.0.0', true);
        wp_add_inline_script('preline', 'document.addEventListener("DOMContentLoaded", () => { HSStaticMethods.autoInit(); });');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_preline_script');

function locks_scripts()
{
    // Core styles
    wp_enqueue_style('locks-style', get_stylesheet_uri(), array());
    wp_enqueue_style('bootstrap-5-styles', get_template_directory_uri() . '/css/bootstrap.css', [], '5.1.3');
    wp_enqueue_style('bootstrap-overrides', get_template_directory_uri() . '/css/bootstrap-overrides.css', ['bootstrap-5-styles']);
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/css/owl.theme.css');
    wp_enqueue_style('font-awesome-6', get_template_directory_uri() . '/fontawesome/css/all.min.css');
    wp_enqueue_style('banner', get_template_directory_uri() . '/css/banner.css');
    wp_enqueue_style('container', get_template_directory_uri() . '/css/containers.css');
    wp_enqueue_style('header', get_template_directory_uri() . '/css/header.css');
    wp_enqueue_style('global', get_template_directory_uri() . '/css/global.css');

    // Core scripts
    wp_enqueue_script('bootstrap-5-scripts', get_template_directory_uri() . '/js/bootstrap513/js/bootstrap.bundle.js', [], '5.1.3', true);
    wp_enqueue_script('locks-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);
    wp_enqueue_script('customimr', get_template_directory_uri() . '/js/custom-imr.js', array('jquery'), '20151216', true);
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20151216', true);
    wp_enqueue_script('locks-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    // Conditional enqueuing
    if (is_front_page()) {
        wp_enqueue_style('google-icon-font', 'https://fonts.googleapis.com/icon?family=Material+Icons');
    }

    if (is_page_template('page-templates/full-width.php') || is_page_template('page-templates/genesis-custom.php')) {
        wp_enqueue_style('genesis-global', get_template_directory_uri() . '/css/genesis/global.css');
        wp_enqueue_script('genesis-scripts', get_template_directory_uri() . '/js/genesis-scripts.js', [], '', true);
    }

    if (is_page_template('page-templates/full-width.php')) {
        wp_enqueue_style('genesis-styles', get_template_directory_uri() . '/css/genesis-styles.css');
    }

    if (is_singular('safe')) {
        wp_enqueue_style('magnific-popup-style', get_template_directory_uri() . '/css/magnific-popup.css');
        wp_enqueue_style('responsive-tables-style', get_template_directory_uri() . '/css/responsive-tables.css');
        wp_enqueue_script('magnific-popup-script', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true);
        wp_enqueue_script('responsive-tables-script', get_template_directory_uri() . '/js/responsive-tables.js', array('jquery'), '', true);
    }

    if (is_singular('product')) {
        wp_enqueue_style('ri-woo-single-styles', get_template_directory_uri() . '/css/ri-woo-single-styles.css');
    }

    if (!is_admin()) {
        wp_enqueue_style('ri-global-styles', get_template_directory_uri() . '/css/ri-global-styles.css');
        wp_enqueue_style('genesis-alternate', get_template_directory_uri() . '/css/genesis/alternate.css');
        wp_enqueue_style('ri-form-styles', get_template_directory_uri() . '/css/ri-form-styles.css');
        wp_enqueue_style('web-fonts', "https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap", [], '1.0');
        wp_enqueue_style('tailwind-styles', get_template_directory_uri() . '/css/tailwind.css', ['bootstrap-5-styles']);
        wp_enqueue_style('web-fonts-source', "https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;500;600;700;800&display=swap", [], '1.0');
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_front_page()) {
        wp_enqueue_script('preline-modal-custom', get_template_directory_uri() . '/js/preline.js', ['preline']);
    }
}
add_action('wp_enqueue_scripts', 'locks_scripts');

function dequeue_unnecessary_assets()
{
    if (!is_admin()) {
        wp_dequeue_style('font-awesome');
    }

    $is_page_builder_used = function_exists("et_pb_is_pagebuilder_used") ? et_pb_is_pagebuilder_used(get_the_ID()) : null;

    if (!$is_page_builder_used) {
        $scripts_to_dequeue = [
            'et-builder-modules-global-functions-script',
            'google-maps-api',
            'divi-fitvids',
            'waypoints',
            'magnific-popup',
            'hashchange',
            'salvattore',
            'easypiechart',
            'et-jquery-visible-viewport',
            'et-jquery-touch-mobile',
            'et-builder-modules-script',
            'et-core-common-js'
        ];

        foreach ($scripts_to_dequeue as $script) {
            wp_dequeue_script($script);
        }
    }

    if (is_front_page()) {
        wp_dequeue_style('divi-builder-dynamic');
    }
}
add_action('wp_print_scripts', 'dequeue_unnecessary_assets', 100);
