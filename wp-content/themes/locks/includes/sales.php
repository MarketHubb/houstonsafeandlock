<?php

function is_sale_active()
{
    return get_field('enable_sale', 'option');
}

function is_popup_active()
{
    return get_field('enable_popup', 'option');
}

function is_alert_active()
{
    return get_field('enable_alert', 'option');
}

function get_alert_locations()
{
    return get_field('alert_location', 'option');
}

function get_alert_by_page($object_id)
{
    if (is_sale_active() && is_alert_active()) {
        $alert_locations = get_alert_locations();

        if (!$alert_locations) return null;

        if ($alert_locations === 'All pages') return get_template_part('template-parts/product/content', 'alert');

        if ($alert_locations === 'Safe pages') {
            if ($object_id == 3901) {
                return get_template_part('template-parts/product/content', 'alert');
            }

            // Check if it's a product category
            $term = get_term($object_id);
            if ($term && $term->taxonomy === 'product_cat') {
                return get_template_part('template-parts/product/content', 'alert');
            }

            // Check if it's a singular product
            $post_type = get_post_type($object_id);
            if ($post_type === 'product') {
                return get_template_part('template-parts/product/content', 'alert');
            }
        }
    }

    return null;
}

function get_current_sale()
{
    return get_field('current_sale', 'option');
}

function get_sale_title()
{
    return get_field('title', get_current_sale());
}

function get_sale_discount()
{
    return get_field('discount_amount', get_current_sale());
}

function get_sale_start_date()
{
    return get_field('start_date', get_current_sale());
}

function get_sale_end_date()
{
    return get_field('end_date', get_current_sale());
}

function get_sale_details()
{
    return get_field('details', get_current_sale());
}

function get_sale_alert_description(int $sale_id = null)
{
    $sale_id = $sale_id ?? get_current_sale();

    if (is_alert_active($sale_id)) {
        $description = replace_placeholders_in_string(get_field('alert_copy', $sale_id));
    }

    return $description ?? null;
}

function get_sale_popup_data()
{
    $sale_post_modal_enabled = get_field('modal_active', get_current_sale());

    return $sale_post_modal_enabled ? get_field('modal', get_current_sale()) : null;
}

function get_sale_popup()
{
    $sale_popup = get_sale_popup_data();

    if ($sale_popup) {
        $required_fields = ['image', 'heading', 'body'];

        foreach ($required_fields as $field) {
            if (empty($sale_popup[$field])) {
                return null;
            }
        }
    }

    return $sale_popup;
}
