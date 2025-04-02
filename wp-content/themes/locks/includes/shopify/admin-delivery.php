<?php
// Add this to your functions.php or your existing file

// Register the submenu and settings
add_action('admin_menu', function () {
    add_submenu_page(
        'shopify-inventory',           // Parent slug (must match exactly the parent's slug)
        'Delivery Settings',           // Page title
        'Delivery Settings',           // Menu title
        'manage_options',              // Capability
        'shopify-delivery-settings',   // Changed the slug to be more unique
        'render_delivery_settings_page' // Callback function
    );
});

// Register settings
add_action('admin_init', function () {
    register_setting('delivery_settings_group', 'delivery_settings');

    add_settings_section(
        'delivery_settings_section',
        'Delivery Configuration',
        function() {
            echo '<p>Configure your delivery settings below:</p>';
        },
        'shopify-delivery-settings'    // Match this with the menu slug
    );

    // Add all settings fields
    $fields = [
        'zip_code' => 'Base Zip Code',
        'delivery_radius' => 'Delivery Radius (miles)',
        'free_delivery_radius' => 'Free Delivery Radius (miles)',
        'cost_per_mile' => 'Cost Per Mile ($)',
        'bolt_down_charge' => 'Bolt Down Charge ($)',
        'floors_charge' => 'Floors Charge ($)'
    ];

    foreach ($fields as $field_id => $field_label) {
        add_settings_field(
            $field_id,
            $field_label,
            'render_delivery_setting_field',
            'shopify-delivery-settings',    // Match this with the menu slug
            'delivery_settings_section',
            [
                'field_id' => $field_id,
                'label_for' => $field_id
            ]
        );
    }
});

// Make sure this function exists and is defined BEFORE it's called by add_submenu_page
function render_delivery_settings_page() {
    // Check for permissions
    if (!current_user_can('manage_options')) {
        return;
    }

    // Show success message if settings were updated
    if (isset($_GET['settings-updated'])) {
        add_settings_error(
            'delivery_settings_messages',
            'delivery_settings_message',
            'Settings Saved',
            'updated'
        );
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <?php settings_errors('delivery_settings_messages'); ?>

        <form action="options.php" method="post">
            <?php
            settings_fields('delivery_settings_group');
            do_settings_sections('shopify-delivery-settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

// Field renderer function
function render_delivery_setting_field($args) {
    $field_id = $args['field_id'];
    $options = get_option('delivery_settings', []);
    $value = isset($options[$field_id]) ? $options[$field_id] : '';
    
    $type = ($field_id === 'zip_code') ? 'text' : 'number';
    $step = ($field_id === 'zip_code') ? '' : 'step="0.01"';
    
    printf(
        '<input type="%s" id="%s" name="delivery_settings[%s]" value="%s" class="regular-text" %s />',
        $type,
        esc_attr($field_id),
        esc_attr($field_id),
        esc_attr($value),
        $step
    );
}
