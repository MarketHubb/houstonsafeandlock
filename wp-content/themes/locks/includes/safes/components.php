<?php
// region Attributes
function output_featured_attributes($post_id)
{
    $featured_attributes = [
        'weight' => [
            'image' => '/2024/10/sl-height-2.svg',
            'field' => 'post_product_gun_weight',
            'post' => 'lbs'
        ],
        'height' => [
            'image' => '2022/11/sl-height.svg',
            'field' => 'post_product_gun_exterior_height',
            'post' => '"'
        ],
        'width' => [
            'image' => '2022/11/sl-width.svg',
            'field' => 'post_product_gun_exterior_width',
            'post' => '"'
        ],
        'depth' => [
            'image' => '2022/11/sl-length.svg',
            'field' => 'post_product_gun_exterior_depth',
            'post' => '"'
        ],
    ];

    $attributes = '<ul class="flex flex-none my-4 ps-0 ms-0 featured-attributes">';
    $icon_path = get_home_url() . '/wp-content/uploads/';

    foreach ($featured_attributes as $attribute => $values) {
        $value = floatval(get_field($values['field'], $post_id));
        $attributes .= '<li class="flex flex-1 flex-col justify-center items-center p-0 border-0 bg-transparent">';
        $attributes .= '<img src="' . $icon_path . $values['image'] . '" class="!w-[20px] sm:!w-[22px] md:!w-[35px] h-auto opacity-[.4] mb-2 inline-block" />';
        $attributes .= '<span class="text-xs sm:text-sm md:text-base font-medium tracking-tight" data-sort-type="' . strtolower($attribute) . '">' . round($value, 1);

        if (!empty($values['post'])) {
            $attributes .= '<span class="text-xs text-gray-600 pl-[1px]">' . $values['post'] . '</span>';
        }

        $attributes .= '</span>';

        $attributes .= '</li>';
    }

    $attributes .= '</ul>';

    return $attributes;
}

function output_product_rating_badges(array $product_attributes)
{
    if (! is_array($product_attributes) || empty($product_attributes)) {
        return null;
    }

    $rating_badges = '<div class="flex justify-center gap-x-4 min-h-4">';
    $ratings       = ['security', 'fire'];

    foreach ($ratings as $rating) {
        $key = $rating . '_' . 'rating';

        if (! empty($product_attributes[$key]) && $product_attributes[$key] !== 'Not rated') {
            $icon_field = 'filter_' . $rating . '_ratings_icon';
            $icon       = get_field($icon_field, 'option');
            $rating_badges .= '<span class="flex flex-row items-center gap-x-1.5 rounded-full px-2 py-1 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-200">';

            if ($icon && ! empty($icon['url'])) {
                $rating_badges .= '<img class="inline h-4 w-auto filter brightness-50 contrast-75 hue-rotate-180 saturate-150 opacity-70" src="' . $icon['url'] . '" />';
            }

            $rating_badges .= $product_attributes[$key] . '</span>';
        }
    }
    $rating_badges .= '</div>';

    return $rating_badges;
}

function output_product_series(array $product_attributes)
{
    if (empty($product_attributes['series'])) {
        return;
    }

    $series = '<div class="flex justify-center mb-2">';
    $series .= '<span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">';
    $series .= $product_attributes['series'] . ' Series';
    $series .= '</span>';
    $series .= '</div>';

    return $series;
}

function get_formatted_product_attribute_specs_table($tableHtml)
{
    // Prevent warnings for potentially malformed HTML
    libxml_use_internal_errors(true);

    $dom = new DOMDocument();
    // Ensure UTF-8 is recognized; helps avoid charset issues
    $dom->loadHTML(
        '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
            . $tableHtml
    );

    // Reset error handling
    libxml_clear_errors();
    libxml_use_internal_errors(false);

    // Get all <tr> elements
    $rows    = $dom->getElementsByTagName('tr');
    $results = [];

    // Iterate over each row
    foreach ($rows as $row) {
        // Grab the first <th> (label) and the first <td> (value)
        $th = $row->getElementsByTagName('th')->item(0);
        $td = $row->getElementsByTagName('td')->item(0);

        // If both exist, trim text content
        if ($th && $td) {
            $label = trim($th->textContent);
            $value = trim($td->textContent);

            // Only add if both label and value are non-empty
            if ($label !== '' && $value !== '') {
                $results[] = [$label => $value];
            }
        }
    }

    // return !empty($results)
    //     ?
    //     :
}
// endregion

// Product
function output_product_grid_title(int $post_id)
{
    $product_title = get_the_title($post_id);

    if (empty($product_title)) return;

    $title  = '<h3 class="text-base md:text-base lg:text-lg xl:text-[1.35rem] font-bold antialiased tracking-tight sm:tracking-normal !leading-snug text-gray-900 text-center">';
    $title .= $product_title . '</h3>';

    return $title;
}

function output_product_grid_category($post_id)
{
    $category_name = get_product_parent_tax_name($post_id);

    if (!$category_name) {
        return;
    }

    $category = '<span class=" text-gray-400 tracking-wide inline-block w-full mx-auto text-center font-normal">';
    $category .= $category_name . ' Safe';
    $category .= '</span>';

    return $category;
}

function output_product_description_clamp($post_id)
{
    $product_description = get_product_attribute_description_long($post_id);

    if (empty($product_description)) {
        return;
    }

    $description  = '<p class="mt-1 mb-6 text-gray-800 text-sm sm:text-base line-clamp-3 sm:line-clamp-2">';
    $description .= $product_description . '</p>';

    return $description;
}

function output_product_description_full(array $description_array)
{
    if (empty($description_array)) return;

    $description_copy = implode('. ', $description_array);

    $description  = '<p class="mt-1 mb-6 text-gray-800 text-sm sm:text-base line-clamp-3 sm:line-clamp-2">';
    $description .= $description_copy . '</p>';

    return $description;
}

function output_product_description_show_hide(array $description_array, array $product_attributes)
{
    // Get first two sentences and remaining sentences
    $first_part = array_slice($description_array, 0, 1);
    $second_part = array_slice($description_array, 1);

    // Convert to strings with periods
    $short_description = !empty($first_part) ? implode('. ', $first_part) . '.' : '';
    $long_description = !empty($second_part) ? implode('. ', $second_part) . '.' : '';


    $id = 'hs-show-hide-collapse-' . $product_attributes['post_id'];

    $show_hide  = '<div class="mt-6">';
    $show_hide .= '<p class="text-gray-500 dark:text-neutral-400">';
    $show_hide .= $short_description;
    $show_hide .= '</p>';

    $show_hide .= '<div id="' . $id . '-heading" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="' . $id . '">';
    $show_hide .= '<p class="text-gray-500  mt-2">';
    $show_hide .= $long_description;
    $show_hide .= '</p></div>';
    $show_hide .= '<p class="mt-2">';
    $show_hide .= '<button type="button" class="hs-collapse-toggle inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:outline-hidden focus:underline focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" id="' . $id . '" aria-expanded="false" aria-controls="' . $id . '-heading" data-hs-collapse="#' . $id . '-heading">';

    $show_hide .= '<span class="hs-collapse-open:hidden">Read more</span>';
    $show_hide .= '<span class="hs-collapse-open:block hidden">Read less</span>';
    $show_hide .= '<svg class="hs-collapse-open:rotate-180 shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m6 9 6 6 6-6"></path>
    </svg>';

    $show_hide .= '</button></p></div>';

    return $show_hide;
}

function output_product_description(array $product_attributes)
{
    $description_array = get_product_description_long_array($product_attributes);

    if (! $description_array) return;

    if (count($description_array) <= 1) {
        return output_product_description_full($description_array);
    }

    return output_product_description_show_hide($description_array, $product_attributes);
}


function output_product_grid_open(int $post_id, mixed $data_attributes, bool $hidden)
{
    $permalink = $post_id
        ? get_permalink($post_id)
        : null;

    if (empty($data_attributes) || ! $permalink) {
        return;
    }

    $hidden =  ! $hidden
        ? ''
        : ' hidden';

    return '<a ' . $data_attributes . ' href="' . $permalink . '" class="relative group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white rounded-lg ring-1 shadow-sm hover:shadow-none ring-gray-200 hover:ring-gray-300 border-gray-200 group/card ' . $hidden . '">';
}

function output_product_grid_image(array $product_attributes)
{
    if (empty($product_attributes) || empty($product_attributes['image_url'])) return;

    if ($product_attributes['image_url']) {
        $product_image  = '<div class="flex justify-center h-48 w-full overflow-hidden rounded-xl group-hover:opacity-75 lg:h-56 xl:h-64 px-4 md:px-6 pt-6 mx-auto">';
        $product_image .= '<img class="h-full !w-auto max-w-full inline-block object-cover transition-transform duration-300 ease-in-out group-hover:scale-105" ';
        $product_image .= ' src="' . esc_url($product_attributes['image_url']) . '" ';
        $product_image .= 'loading="lazy"';

        if ($product_attributes['image_srcset']) {
            $product_image .= 'srcset=" ' . $product_attributes['image_srcset'] . '" ';
        }

        if ($product_attributes['image_sizes']) {
            $product_image .= 'sizes="' . $product_attributes['image_sizes'] . '" />';
        }

        $product_image .= '</div>';
    }

    return $product_image;
}

function safe_grid_item_legacy($post_id)
{
    $attributes      = tw_safe_filters_array();
    $data_attributes = '';
    $badges          = '<div class="badge-container">';

    // Get the product's categories
    $product_categories = get_the_terms($post_id, 'product_cat');
    $current_category   = get_queried_object();

    foreach ($attributes as $attribute_name => $attribute_data) {
        if (isset($attribute_data['field'])) {
            $value = get_field($attribute_data['field'], $post_id);
            if ($value) {
                // For array values, join them with commas
                if (is_array($value)) {
                    $value = implode(',', $value);
                }

                $display_value = $value;
                if (isset($attribute_data['pre'])) {
                    $display_value = $attribute_data['pre'] . $display_value;
                }
                if (isset($attribute_data['post'])) {
                    $display_value .= $attribute_data['post'];
                }

                $data_attributes .= ' data-' . sanitize_title($attribute_name) . '="' . esc_attr($value) . '"';
            }
        } elseif ($attribute_name === 'Category') {
            // Handle Category separately
            if ($product_categories && ! is_wp_error($product_categories)) {
                foreach ($product_categories as $category) {
                    if ($category->parent == $current_category->term_id) {
                        $data_attributes .= ' data-category="' . esc_attr($category->name) . '"';
                    }
                }
            }
        }
    }

    $badges .= '</div>';

    // $product_card  = '<div' . $data_attributes . ' class="product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white border-gray-200 rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 group/card">';
    $product_card = '<a ' . $data_attributes . ' href="' . get_permalink($post_id) . '" class="group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white border-gray-200 rounded-xl group/card">';
    $product_card .= '<div class="overflow-hidden h-48 w-full mx-auto">';

    $image_url    = get_the_post_thumbnail_url($post_id, 'medium');
    $image_srcset = wp_get_attachment_image_srcset(get_post_thumbnail_id($post_id), 'medium');
    $image_sizes  = wp_get_attachment_image_sizes(get_post_thumbnail_id($post_id), 'medium');

    // $product_card .= '<img class="!h-full w-auto  object-cover object-center rounded-t-xl" src="' . get_the_post_thumbnail_url($post_id) . '" alt="Card Image">';
    $product_card .= '<img class="!h-full w-auto  object-cover object-center rounded-t-xl transition-transform duration-300 ease-in-out group-hover:scale-105" ';
    $product_card .= ' src="' . esc_url($image_url) . '" ';
    $product_card .= 'loading="lazy "';
    $product_card .= 'srcset=" ' . $image_srcset . '" ';
    $product_card .= 'sizes="' . $image_sizes . '" />';
    $product_card .= '</div>';
    $product_card .= '<div class="p-4 md:p-5">';

    $price = get_field('post_product_gun_price', $post_id) ? '$' . get_field('post_product_gun_price', $post_id) : 'Call for pricing';
    $product_card .= '<p class="text-base font-medium">' . $price . '</p>';

    $product_card .= '<h3 class="text-lg font-bold text-gray-800">';
    $product_card .= get_the_title($post_id) . '</h3>';

    $product_card .= output_featured_attributes($post_id);

    $product_card .= '<p class="mt-1 mb-6 text-gray-500 text-base line-clamp-2">';
    $product_card .= get_field("post_product_gun_long_description", $post_id) . '</p>';
    $product_card .= '</div></a>';

    return $product_card;
    // return safe_grid_attributes($post_id);
    // $product_card  = '<div class=" flex flex-col bg-white border-gray-200 rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 group/card">';
    // $product_card .= '<div class="overflow-hidden h-48 w-full mx-auto">';
    // $product_card .= '<img class=" w-auto h-full object-cover object-center rounded-t-xl" src="' . get_the_post_thumbnail_url($post_id) . '" alt="Card Image">';
    // $product_card .= '</div>';
    // $product_card .= '<div class=" p-4 md:p-5">';
    // $product_card .= '<h3 class=" text-lg font-bold text-gray-800 dark:text-white">';
    // $product_card .= get_the_title($post_id) . '</h3>';
    // $product_card .= '<p class=" mt-1 mb-6 text-gray-500 dark:text-neutral-400 text-base line-clamp-2 ">';
    // $product_card .= get_field("post_product_gun_long_description", $post_id) . '</p>';
    // $product_card .= '<a class="' . get_grid_cta_btn_classes() .  '" href="' . get_permalink($post_id) . '">';
    // $product_card .= 'View detail' . '</a></div></div>';

    // return $product_card;
    // ## CONTAINER ##
    $safes = '<div class="mix w-full mb-3 ';

    // Data-attributes
    $safe_attributes = safe_grid_attributes($post_id);

    if (! empty($safe_attributes)) {
        $class_names      = "";
        $sort_badges      = "";
        $filter_badges    = "";
        $attribute_list   = "";
        $attribute_output = "";

        foreach ($safe_attributes as $safe_attribute) {
            $sanitized_val = sanitize_attribute_value($safe_attribute["value"]);

            // Class list
            if ($safe_attribute["type"] === "filter") {
                $class_names .= format_attribute_class_name($safe_attribute);
                $filter_badges .= safe_filter_badge($safe_attribute);
            }

            // Sort badgets
            if ($safe_attribute["type"] === "sort") {
                $sort_badges .= safe_sort_badges($safe_attribute);
            }

            // Date attributes
            if ($safe_attribute["type"] === "sort") {
                $attribute_list .=
                    "data-" .
                    sanitize_attribute_value($safe_attribute["label"]) .
                    '="' .
                    sanitize_attribute_value($safe_attribute["value"]) .
                    '" ';
            }

            if ($safe_attribute["label"] === "Brand") {
                $type_badge = safe_type_badge($safe_attribute["value"]);
            }

            // Attribute grid & badge (output)
            if (! empty($safe_attribute["value"])) {
                $attribute_output .= '<div class="col-span-6">';
                $attribute_output .=
                    '<p class="text-xs mb-0 text-capitalize fw-600">' .
                    $safe_attribute["label"] .
                    "</p>";
                $attribute_output .= "</div>";
                $attribute_output .= '<div class="col-span-6">';

                $pre_attribute = isset($safe_attribute["pre"])
                    ? $safe_attribute["pre"]
                    : "";
                $post_attribute = isset($safe_attribute["post"])
                    ? $safe_attribute["post"]
                    : "";
                $attribute_value =
                    $pre_attribute . $safe_attribute["value"] . $post_attribute;

                $attribute_output .=
                    '<p class="text-xs mb-0">' . $attribute_value . "</p>";
                $attribute_output .= "</div>";
            }
        }

        $safes .= $class_names . '" ';
        $safes .= $attribute_list;
    }

    $safes .= ">";
    $safes .= '<div class="product h-100 bg-white">';

    // ## IMAGE ##
    $safes .= '<div class="text-center p-4 pb-0 product-img-container">';
    $image_classes = $classes["image"] ?: "";
    $safes .=
        '<img src="' .
        get_the_post_thumbnail_url($post_id) .
        '" class="product-grid-image pb-4 ' .
        $image_classes .
        '"/>';
    $safes .= "</div>";

    // ## CONTENT ##
    $safes .= '<div class="px-4 pb-4-5 product-text-container">';

    // Capacity for Gun Safes
    if (
        has_term(37, "product_cat") &&
        get_field("post_product_gun_capacity_total", $post_id)
    ) {
        $safes .=
            '<p class="text-center mb-0 pb-0"><span class="d-none fw-light">Capacity:</span> ';
        $safes .=
            '<span class="fw-600 text-secondary">' .
            get_field("post_product_gun_capacity_total", $post_id) .
            " Guns</span></p>";
    }

    $safes .= '<div class="text-center">';

    // Price
    // $safe_price = get_safe_price_from_attributes($safe_attributes);
    $safe_price = get_product_pricing($post_id);
    if (! empty($safe_price)) {
        // $safes .= '<p class="fs-5 tracking-wide">$' . $safe_price . '</p>';
        $safes .=
            '<p class="safe-price fs-5 inline tracking-wide">$' .
            $safe_price["discounted_price"] .
            "</p>";
    }

    // Sort Badges
    if (! empty($sort_badges)) {
        $safes .=
            '<div class="d-flex flex-wrap justify-content-center gap-x-6 mb-4" id="sort-badges">';
        $safes .= $sort_badges;
        $safes .= "</div>";
    }

    // Product name
    $safes .= "<h4>" . get_the_title($post_id) . "</h4>";

    // Description
    $description_classes = $classes["description"] ?: "";
    $safes .=
        '<p class="product-grid-description mb-0 ' .
        $description_classes .
        '">' .
        get_field("post_product_gun_long_description", $post_id) .
        "</p>";
    $safes .= "</div>";

    // Filter badges
    if (! empty($filter_badges)) {
        $safes .=
            '<div class="d-flex flex-wrap justify-content-center badge-gap my-3 filter-badges" id="">';
        $safes .= $filter_badges;
        $safes .= "</div>";
    }

    $attributes = [
        "weight",
        "fire-rating",
        "exterior-depth",
        "exterior-width",
        "exterior-height",
    ];

    // All attributes (new)
    if (isset($attribute_output)) {
        $safes .=
            '<div class="accordion accordion-flush" id="productAttributeAccordion">';
        $safes .= '<div class="accordion-item bg-transparent">';
        $safes .= '<h2 class="accordion-header" id="flush-headingOne">';
        $safes .=
            '<button class="fw-600 anti bg-transparent accordion-button py-0 text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#product_' .
            $post_id .
            '" aria-expanded="false" aria-controls="product_' .
            $post_id .
            '">';
        $safes .= "Product details";
        $safes .= "</button>";
        $safes .= "</h2>";
        $safes .=
            '<div id="product_' .
            $post_id .
            '" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#productAttributeAccordion">';
        $safes .= '<div class="accordion-body px-0">';
        $safes .= '<div class="grid grid-cols-12 gap-x-2 divide-y">';
        $safes .= $attribute_output;
        $safes .= "</div></div></div></div></div>";
    }
    // Dimension attributes (legacy)
    else {
        $attribute_array = get_formatted_product_attributes(
            $post_id,
            $attributes
        );

        $safe_attributes = [
            ["2022/11/hsl-weigh.svg", "post_product_gun_weight", "lbs"],
            ["2022/11/sl-height.svg", "post_product_gun_exterior_height", '"'],
            ["2022/11/sl-width.svg", "post_product_gun_exterior_width", '"'],
            ["2022/11/sl-length.svg", "post_product_gun_exterior_depth", '"'],
        ];

        if (is_array($attribute_array)) {
            $icon_path = get_home_url() . "/wp-content/uploads/";
            $safes .= '<ul class="list-group list-group-horizontal ps-0 ms-0">';

            foreach ($safe_attributes as $safe_attribute) {
                $safes .=
                    '<li class="list-group-item flex-fill  text-center d-flex flex-column align-items-center justify-content-center no-border">'; // code...
                $safes .=
                    '<img src="' .
                    $icon_path .
                    $safe_attribute["0"] .
                    '"  class="product-grid-icon mb-1" />';
                $attribute_value = (float) get_field(
                    $safe_attribute[1],
                    $post_id
                );
                $safes .=
                    '<span class="fw-600 grid-attr-key">' .
                    round($attribute_value, 2) .
                    $safe_attribute[2] .
                    "</span>";
                $safes .= "</li>";
            }

            $safes .= "</ul>";
        }
    }

    $safes .=
        '<div class="d-flex row-cols-2 justify-content-between mt-4 pt-2 gap-2 grid-btn-container">';
    $safes .= '<div class="grid-btn-container">';
    $safes .=
        '<a class="btn px-3 py-1 w-100 small btn-outline-secondary" href="' .
        get_permalink($post_id) .
        '">View</a>';
    $safes .= "</div>";
    $safes .= '<div class="grid-btn-container text-end">';
    $safes .= get_product_inquiry_btn(
        $post_id,
        "Inquiry",
        null,
        "btn px-2 py-1 w-100 small btn-outline-primary"
    );
    $safes .= "</div>";
    $safes .= "</div>";
    $safes .= "</div></div></div>";

    return $safes ?: null;
}
// endregion

// region Price & Discounts
function get_product_price_format($price_val)
{
    $price_split = split_price($price_val);

    if (empty($price_split['dollars']) || empty($price_split['cents'])) {
        return;
    }

    $price = '<div class="inline-flex justify-center items-center sm:items-start">';
    $price .= '<span class="text-xs sm:text-base font-bold antialiased tracking-tight !leading-none font-system">$</span>';
    $price .= '<span class="text-xl sm:text-[1.4rem] md:text-[1.6rem] font-semibold tracking-normal align-middle !leading-none pl-[1px] font-system relative sm:bottom-[2px]">' . $price_split['dollars'] . '</span>';
    $price .= '<span class=" inline-flex font-system pl-[.02rem]">';
    $price .= '<span class="inline-flex text-xs sm:text-base font-semibold tracking-tight align-start !leading-none relative font-system">.' . $price_split['cents'] . '</span>';
    $price .= '</span>';
    $price .= '</div>';

    return $price;
}

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
// endregion

// region Sales & Promotions
function get_product_sale_callout(int $post_id, string $location)
{
    $discount = get_product_attribute_discount_amount($post_id);

    if (! isset($post_id) || ! isset($location) || ! $discount) {
        return;
    }

    $callout = '';

    if ($location === 'grid') {
        $callout .= '<p class="text-red-500 text-xs sm:text-base sm:text-center leading-tight tracking-tight font-semibold antialiased px-1">';
        $callout .= 'Save <strong class="!font-bolder">$' . get_product_attribute_discount_amount($post_id) . '</strong> ';
        $callout .= 'during <span class="font-semibold">' . get_sale_title() . '</span> sale';
    }

    return $callout;
}
// endregion

// region Shared
function get_product_archive_open()
{
    $grid_open = <<<STRING
    <div class="bg-white">
        <div>
        <main class="mx-auto container px-3 lg:px-8">
    STRING;

    return $grid_open;
}

function get_product_archive_close()
{
    $grid_close = <<<STRING
        </main>
        </div>
    </div>
    STRING;

    return $grid_close;
}
// endregion
