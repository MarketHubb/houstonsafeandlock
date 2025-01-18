<?php

/**
 * Generate a Shopify Buy Now button using ACF field data
 * 
 * @param int $post_id Post ID (optional, defaults to current post)
 * @param array $args Optional button customization arguments
 * @return string|false HTML button if fields exist, false if missing data
 */
function get_shopify_buy_button($post_id = null, $args = array())
{
    // Get post ID if not provided
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $inventory_repeater = get_field('product_inventory', $post_id);

    if (empty($inventory_repeater) || !isset($inventory_repeater[0])) {
        return false;
    }

    // Get ACF fields
    $variant_id = $inventory_repeater[0]['variant_id'];
    $sku = $post_id;
    $price = $inventory_repeater[0]['discount_price'];

    // Verify all fields are populated
    if (empty($variant_id) || empty($sku) || empty($price)) {
        return "no fields";
    }

    // Default args
    $defaults = array(
        'button_text' => 'Buy Now',
        'button_class' => 'shopify-buy-button',
        'quantity' => 1,
        'show_price' => true,
        'discount_code' => '25OFFSAFES3100'
    );
    $args = wp_parse_args($args, $defaults);

    // Demo customer information
    $customer_info = array(
        'email' => 'test@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'address1' => '123 Main Street',
        'city' => 'Houston',
        'zip' => '77001',
        'country' => 'United States',
        'phone' => '713-555-0123'
    );

    // Construct the checkout URL with prefilled fields and discount code
    $url = sprintf(
        'https://%s/cart/%s:%d?checkout' .
            '&checkout[email]=%s' .
            '&checkout[shipping_address][first_name]=%s' .
            '&checkout[shipping_address][last_name]=%s' .
            '&checkout[shipping_address][address1]=%s' .
            '&checkout[shipping_address][city]=%s' .
            '&checkout[shipping_address][zip]=%s' .
            '&checkout[shipping_address][country]=%s' .
            '&checkout[shipping_address][phone]=%s' .
            '&discount=' . urlencode($args["discount_code"]),
        SHOPIFY_STORE_URL,
        $variant_id,
        $args['quantity'],
        urlencode($customer_info['email']),
        urlencode($customer_info['first_name']),
        urlencode($customer_info['last_name']),
        urlencode($customer_info['address1']),
        urlencode($customer_info['city']),
        urlencode($customer_info['zip']),
        urlencode($customer_info['country']),
        urlencode($customer_info['phone'])
    );

    // Rest of your code remains the same...
    $button_html = '<div class="shopify-buy-wrapper">';

    $button_html .= sprintf(
        '<a href="%s" class="%s" target="_blank">%s</a>',
        esc_url($url),
        esc_attr($args['button_class']),
        esc_html($args['button_text'])
    );

    $button_html .= '</div>';

    // Add default styling if not disabled
    if (!isset($args['disable_default_styles'])) {
        $button_html = '<style>
            .shopify-buy-wrapper {
                margin: 20px 0;
            }
            .shopify-buy-button {
                display: inline-block;
                padding: 12px 24px;
                background-color: #008060;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                font-weight: bold;
                transition: background-color 0.3s ease;
            }
            .shopify-buy-button:hover {
                background-color: #006048;
                color: white;
            }
            .shopify-price {
                font-size: 1.2em;
                font-weight: bold;
                margin-bottom: 10px;
            }
        </style>' . $button_html;
    }

    return $button_html;
}



function all_safes()
{
    return get_posts([
        "post_type" => "product",
        "posts_per_page" => -1,
        "orderby" => "title",
        "order" => "ASC",
    ]);
}

function safe_filters()
{
    $filters_array = [
        [
            "name" => "Brand",
            "field" => "filter_brand",
            "type" => "checkbox",
        ],
        [
            "name" => "Type",
            "field" => "filter_type",
            "type" => "checkbox",
        ],
        [
            "name" => "Fire Rating",
            "field" => "filter_fire_ratings",
            "type" => "checkbox",
        ],
        [
            "name" => "Security Rating",
            "field" => "filter_security_ratings",
            "type" => "checkbox",
        ],
    ];

    return $filters_array;
}

function output_safe_sorts()
{
    $filters = safe_attribute_array();
    $sorts =
        '<ul id="sort-filter-nav" class="nav nav-pills d-inline-flex mb-2 pe-0 pe-md-3" data-sort-order="desc">';
    $sorts .= '<li class="nav-item dropdown bg-transparent">';
    $sorts .=
        '<a class="nav-link dropdown-toggle border-0 filter-sort-type" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">';
    $sorts .= "Sort by:</a>";
    $sorts .= '<div class="dropdown-menu">';

    $asc_icon = get_template_directory_uri() . "/images/asc.svg";
    $desc_icon = get_template_directory_uri() . "/images/desc.svg";

    foreach ($filters as $filter) {
        if ($filter["type"] === "sort") {
            $sort_label = $filter["label"];
            $sorts .=
                '<a class="dropdown-item" data-mixitup-control data-sort="';
            $sorts .= sanitize_attribute_value($filter["label"]) . ':desc">';
            $sorts .= $filter["label"];
            $sorts .= "</a>";
        }
    }

    $sorts .= "</div></li></ul>";

    $order_array = [
        ["DESC", "fa-arrow-down-wide-short"],
        ["ASC", "fa-arrow-down-short-wide"],
    ];

    foreach ($order_array as $order) {
        $sort_color_class = $order[0] === "DESC" ? "active-sort-order" : "";
        $sorts .=
            '<span id="grid-sort-' .
            $order[0] .
            '" class="grid-sort-order px-2 ms-1 ' .
            $sort_color_class .
            '" ';
        $sorts .= 'data-type="' . strtolower($order[0]) . '" >';
        $sorts .= '<i class="fa-regular ' . $order[1] . '"></i>';
        $sorts .=
            '<span class="d-none d-md-inline text-sm ps-2 text-secondary">' .
            $order[0] .
            "</span>";
        $sorts .= "</span>";
    }

    return $sorts;
}

function get_safe_grid_and_filters($post_ids = [])
{
    $array_attributes = [];

    foreach ($post_ids as $id) {
    }
}

function output_safe_filters()
{
    $filters = safe_attribute_array();
    $output = "";

    foreach ($filters as $filter) {
        if ($filter["type"] === "filter" && isset($filter["global_field"])) {
            $filter_options = get_field($filter["global_field"], "option");
            $filter_options = explode("\n", $filter_options);
            $filter_options = array_map("trim", $filter_options);

            if (is_array($filter_options)) {
                $filter_icon = get_field(
                    $filter["global_field"] . "_icon",
                    "option"
                );
                $output .=
                    '<div class="my-3 pt-3 pb-4 border-bottom filter-group ' .
                    sanitize_attribute_value($filter["label"]) .
                    '"';

                if ($filter_icon) {
                    $output .=
                        'data-icon="' .
                        urlencode(trim($filter_icon["url"])) .
                        '" ';
                }

                $output .=
                    'data-filter-type="' .
                    sanitize_attribute_value($filter["label"]) .
                    '" ';
                $output .= ">";
                $output .= '<p class="fw-600">' . $filter["label"] . "</p>";
                $output .=
                    '<div class="d-grid grid-cols-2 gap-y-2 d-md-block">';

                foreach ($filter_options as $filter_option) {
                    $input_id =
                        sanitize_attribute_value($filter["label"]) .
                        "--" .
                        sanitize_attribute_value($filter_option);
                    $checkbox_id = strtolower(
                        str_replace(" ", "_", $filter_option)
                    );

                    $output .= '<div class="form-check">';
                    $output .=
                        '<input class="form-check-input" type="checkbox" value="' .
                        $input_id .
                        '" id="' .
                        $input_id .
                        '" ';
                    $output .=
                        'data-filter-type="' .
                        strtolower(str_replace(" ", "_", $filter["label"])) .
                        '"">';
                    $output .=
                        '<label class="form-check-label" for="' .
                        $input_id .
                        '">';
                    $output .= $filter_option;
                    $output .= "</label>";
                    $output .= "</div>";
                }

                $output .= "</div>";
                $output .= "</div>";
            }
        }
    }

    return $output;
}
