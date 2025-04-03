<?php
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

function enqueue_nouislider_assets()
{
    $website_root = ABSPATH;
    $nouislider_js_path = $website_root . 'node_modules/nouislider/dist/nouislider.min.js';
    $nouislider_css_path = $website_root . 'node_modules/nouislider/dist/nouislider.min.css';
    $nouislider_custom = get_template_directory_uri() . '/js/nouislider.js';

    if (file_exists($nouislider_js_path)) {
        $nouislider_js_url = str_replace(ABSPATH, site_url('/'), $nouislider_js_path);
        $nouislider_js_url = preg_replace('/([^:])(\/\/+)/', '$1/', $nouislider_js_url);
        wp_enqueue_script('nouislider-js', $nouislider_js_url, array(), '15.7.0', true);
    }

    wp_enqueue_script('nouislider-custom-js', $nouislider_custom, array(), '1.0', true);

    if (file_exists($nouislider_css_path)) {
        $nouislider_css_url = str_replace(ABSPATH, site_url('/'), $nouislider_css_path);
        $nouislider_css_url = preg_replace('/([^:])(\/\/+)/', '$1/', $nouislider_css_url);
        wp_enqueue_style('nouislider-css', $nouislider_css_url, array(), '15.7.0');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_nouislider_assets');

function enqueue_preline_script()
{
    $website_root = ABSPATH;
    $preline_path = $website_root . 'node_modules/preline/dist/preline.js';

    $preline_range_slider_path = $website_root . 'node_modules/preline/dist/components/hs-range-slider.js';
    // Adjust path if needed: check if the combobox file is in a 'dist' folder.
    $preline_combobox_path = $website_root . 'node_modules/@preline/combobox/combobox.js';

    if (file_exists($preline_path)) {
        // Enqueue main Preline script
        $preline_url = str_replace(ABSPATH, site_url('/'), $preline_path);
        $preline_url = preg_replace('/([^:])(\/\/+)/', '$1/', $preline_url);
        wp_enqueue_script('preline', $preline_url, array('nouislider-js'), '1.0.0', true);

        // Enqueue Range Slider component if it exists
        if (file_exists($preline_range_slider_path)) {
            $preline_range_slider_url = str_replace(ABSPATH, site_url('/'), $preline_range_slider_path);
            $preline_range_slider_url = preg_replace('/([^:])(\/\/+)/', '$1/', $preline_range_slider_url);
            wp_enqueue_script('preline-range-slider', $preline_range_slider_url, array('preline'), '1.0.0', true);
        }

        // Enqueue ComboBox component if it exists
        $has_combobox = false;
        if (file_exists($preline_combobox_path)) {
            $has_combobox = true;
            $preline_combobox_url = str_replace(ABSPATH, site_url('/'), $preline_combobox_path);
            $preline_combobox_url = preg_replace('/([^:])(\/\/+)/', '$1/', $preline_combobox_url);
            wp_enqueue_script('preline-combobox', $preline_combobox_url, array('preline'), '1.0.0', true);
        }

        // Advanced select
        wp_enqueue_script('preline-select', get_template_directory_uri() . '/js/filters/advanced-select.js', array('preline'), '1.0', true);
        wp_enqueue_script('preline-checkbox', get_template_directory_uri() . '/js/filters/checkbox.js', array('preline'), '1.0', true);
        wp_enqueue_script('preline-range', get_template_directory_uri() . '/js/filters/range.js', array('preline'), '1.0', true);
        wp_enqueue_script(
            'preline-filters-main',
            get_template_directory_uri() . '/js/filters/main.js',
            array('preline', 'preline-select', 'preline-checkbox', 'preline-range'),
            '1.0',
            true
        );


        // Initialization script using capture-phase event listener
        $init_script = <<<EOT
        // Initialize all Preline components
        HSStaticMethods.autoInit();

        // Initialize the Advanced Select plugin specifically
        HSAdvancedSelect.autoInit();
        EOT;

        // Attach the inline script to the combobox handle if it exists, otherwise to 'preline'
        // if ($has_combobox) {
        //     wp_add_inline_script('preline-combobox', $init_script);
        // } else {
        //     wp_add_inline_script('preline', $init_script);
        // }
        // wp_add_inline_script('preline', $init_script);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_preline_script');

function enqueue_inline_preline_script()
{

    // Initialization script using capture-phase event listener
    $init_script = <<<EOT
        // Initialize all Preline components
        HSStaticMethods.autoInit();

        // Initialize the Advanced Select plugin specifically
        HSAdvancedSelect.autoInit();
        EOT;

    wp_add_inline_script('preline', $init_script);
}
add_action('wp_enqueue_scripts', 'enqueue_inline_preline_script');

// Enqueue the script
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'font-awesome-6',
        'https://kit.fontawesome.com/364e6c2e4d.js',
        array(),
        null,
        true
    );
});

// Add crossorigin attribute
add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if ($handle === 'font-awesome-6') {
        return str_replace(
            '<script',
            '<script crossorigin="anonymous"',
            $tag
        );
    }
    return $tag;
}, 10, 3);


function locks_scripts()
{
    // Core styles
    wp_enqueue_style('locks-style', get_stylesheet_uri(), array());
    wp_enqueue_style('bootstrap-5-styles', get_template_directory_uri() . '/css/bootstrap.css', [], '5.1.3');
    wp_enqueue_style('bootstrap-overrides', get_template_directory_uri() . '/css/bootstrap-overrides.css', ['bootstrap-5-styles']);
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/css/owl.theme.css');
    // wp_enqueue_style('font-awesome-6', get_template_directory_uri() . '/fontawesome/css/all.min.css');
    // wp_enqueue_style('font-awesome-6', 'https://kit.fontawesome.com/364e6c2e4d.js');
    wp_enqueue_style('banner', get_template_directory_uri() . '/css/banner.css');
    wp_enqueue_style('container', get_template_directory_uri() . '/css/containers.css');
    wp_enqueue_style('header', get_template_directory_uri() . '/css/header.css');

    if (!is_page_template('page-templates/locksmith.php')) {
        wp_enqueue_style('global', get_template_directory_uri() . '/css/global.css');
    }


    // Core scripts
    wp_enqueue_script('bootstrap-5-scripts', get_template_directory_uri() . '/js/bootstrap513/js/bootstrap.bundle.js', [], '5.1.3', true);
    wp_enqueue_script('locks-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);
    wp_enqueue_script('customimr', get_template_directory_uri() . '/js/custom-imr.js', array('jquery'), '20151216', true);
    // wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20151216', true);
    wp_enqueue_script('locks-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);
    // wp_enqueue_script('lucide-icons', 'https://unpkg.com/lucide@latest', array(), '', true);

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
        wp_enqueue_script('product-script', get_template_directory_uri() . '/js/product.js', array(), '', true);
        wp_enqueue_script('product-confirmation-script', get_template_directory_uri() . '/js/product-confirmation.js', array(), '', true);
    }

    if (!is_admin()) {
        wp_enqueue_style('ri-global-styles', get_template_directory_uri() . '/css/ri-global-styles.css');
        wp_enqueue_style('font-styles', get_template_directory_uri() . '/css/fonts.css');
        wp_enqueue_style('genesis-alternate', get_template_directory_uri() . '/css/genesis/alternate.css');
        // wp_enqueue_style('ri-form-styles', get_template_directory_uri() . '/css/ri-form-styles.css');
        wp_enqueue_style('web-fonts', "https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap", [], '1.0');
        // wp_enqueue_style('tailwind-styles', get_template_directory_uri() . '/css/tailwind.css', ['bootstrap-5-styles']);
        wp_enqueue_style('tailwind-styles', get_template_directory_uri() . '/css/tailwind.css', []);
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

    $is_page_builder_used = null;
    // $is_page_builder_used = function_exists("et_pb_is_pagebuilder_used") ? et_pb_is_pagebuilder_used(get_the_ID()) : null;

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


/**
 * Dequeue Genesis Blocks assets conditionally.
 */
function dequeue_unused_assets()
{

    if (is_singular('product') || is_page(3901) || is_tax('product_cat') || is_page('9385')) {

        // Styles
        wp_dequeue_style('genesis-page-builder-frontend-styles');
        wp_dequeue_style('genesis-blocks-style-css');
        wp_dequeue_style('genesis-alternate');
        wp_dequeue_style('owl-theme');
        wp_dequeue_style('bootstrap-5-styles');
        wp_dequeue_style('bootstrap-overrides');
        wp_dequeue_style('wp-emoji-styles');
        wp_dequeue_style('google_business_reviews_rating_wp_css');

        // Scripts
        wp_dequeue_script('genesis-blocks-dismiss-js');
        wp_dequeue_script('wc-order-attribution');
        wp_dequeue_script('wc-add-to-cart');
        wp_dequeue_script('bootstrap-5-scripts');
        wp_dequeue_script('google_business_reviews_rating_wp_js');
    }
}
add_action('wp_enqueue_scripts', 'dequeue_unused_assets', 100);

/**
 * Enqueue Gravity Forms scripts in header for modal-window forms
 */
function gf_enqueue_header_scripts()
{
    GFCommon::log_debug(__METHOD__ . '(): running.');
    if (is_page('9385')) {
        gravity_form_enqueue_scripts(10, true);
        wp_enqueue_style('tw-gforms', get_template_directory_uri() . '/css/tw-gforms.css');
        wp_enqueue_script('debug-scripts', get_template_directory_uri() . '/js/debug.js');
    }
}
add_action('get_header', 'gf_enqueue_header_scripts');

function enqueue_locksmith_scripts()
{
    GFCommon::log_debug(__METHOD__ . '(): running.');
    if (is_page([7728, 6624, 6839, 6448, 7276, 8743, 9385])) {
        wp_dequeue_style('locks-style');
        wp_dequeue_style('gform_theme');
        wp_enqueue_style('tw-gforms', get_template_directory_uri() . '/css/tw-gforms.css');
        wp_enqueue_script('preline-modal-scripts', get_template_directory_uri() . '/js/modal.js');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_locksmith_scripts');


function dequeue_theme_styles()
{
    wp_dequeue_style('locks-style');
    wp_dequeue_style('ri-global-styles');
    wp_dequeue_style('global');
}

function dequeue_genesis_styles()
{
    wp_dequeue_style('genesis-blocks-style-css');
    wp_dequeue_style('genesis-page-builder-frontend-styles');
    wp_dequeue_style('genesis-alternate');
}

function dequeue_woocommerce_styles()
{
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-inline');
}

function dequeue_bootstrap_styles()
{
    wp_dequeue_style('bootstrap-5-styles');
    wp_dequeue_style('bootstrap-overrides');
}

function enqueue_gravity_forms_modal_styles()
{
    wp_dequeue_style('locks-style');
    wp_dequeue_style('gform_theme');
    wp_enqueue_style('tw-gforms', get_template_directory_uri() . '/css/tw-gforms.css');
}

function enqueue_preline_package_leaflet()
{
    wp_enqueue_style('preline_leaflet_styles', '/node_modules/leaflet/dist/leaflet.css', [], '1.9.4');
    wp_enqueue_style('preline_leaflet_custom_styles', get_template_directory_uri() . '/css/preline-leaflet.css');
    wp_enqueue_script('preline_leaflet_lodash', '/node_modules/lodash/lodash.min.js');
    wp_enqueue_script('preline_leaflet_scripts', '/node_modules/leaflet/dist/leaflet.js');
    wp_enqueue_script('preline_leaflet_custom_scripts', get_template_directory_uri() . '/js/preline-leaflet.js');
}

function enqueue_all_preline_packages()
{
    enqueue_preline_package_leaflet();
}

function locksmith_page_styles()
{
    if (is_page_template('page-templates/locksmith.php')) {
        dequeue_theme_styles();
        dequeue_genesis_styles();
        dequeue_woocommerce_styles();
        dequeue_bootstrap_styles();
        enqueue_preline_package_leaflet();
    }
}
add_action('wp_enqueue_scripts', 'locksmith_page_styles');

function enqueue_product_category_scripts()
{
    wp_enqueue_script('safe-filters-mobile', get_template_directory_uri() . '/js/safe-filters-mobile.js', array(), '1.0', true);
    wp_enqueue_script('tw-load-safes', get_template_directory_uri() . '/js/load-safes.js', array(), '1.0', true);
    // wp_enqueue_script('tw-filters', get_template_directory_uri() . '/js/tw-filters.js', array('jquery'), '1.0', true);
    wp_enqueue_style('tw-product-category-style', get_template_directory_uri() . '/css/tw-safe-cat.css', array(), '1.0');
}

function conditionally_enqueue_product_category_assets()
{
    if (is_tax('product_cat') || is_page(3901)) {
        enqueue_product_category_scripts();
        dequeue_theme_styles();
        dequeue_genesis_styles();
        dequeue_woocommerce_styles();
        dequeue_bootstrap_styles();
    }
}
add_action('wp_enqueue_scripts', 'conditionally_enqueue_product_category_assets');

function conditionally_enqueue_gravity_forms_modal_assets()
{
    if (has_gform_in_modal()) {
        enqueue_gravity_forms_modal_styles();
    }
}
add_action('wp_enqueue_scripts', 'conditionally_enqueue_gravity_forms_modal_assets');
