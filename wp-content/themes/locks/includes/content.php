<?php
function tw_sort_dropdown($attributes)
{
    $output = '<div class="relative inline-block text-left">';
    $output .= '<button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" id="menu-button" aria-expanded="false" aria-haspopup="true">';
    $output .= 'Sort';
    $output .= '<svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">';
    $output .= '<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />';
    $output .= '</svg>';
    $output .= '</button>';

    $output .= '<div class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">';
    $output .= '<div class="py-1" role="none">';

    $menu_item_index = 0;
    foreach ($attributes as $filter_name => $filter_data) {
        if ($filter_data['type'] !== 'sort') {
            continue;
        }

        $class = ($menu_item_index === 0) ? 'block px-4 py-2 text-sm font-medium text-gray-900' : 'block px-4 py-2 text-sm text-gray-500';
        $attribute = strtolower($filter_name);

        $output .= '<a href="#" class="' . $class . '" role="menuitem" data-attribute="' . $attribute . '" tabindex="-1" id="menu-item-' . $menu_item_index . '">' . esc_html($filter_name) . '</a>';

        $menu_item_index++;
    }

    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

function tw_product_posts_by_product_cat_tax()
{
    $output = '';
    $product_post_ids = []; // keep track for products in duplicate categories
    $product_cat_tax_terms = get_product_cat_tax_terms(false);

    foreach ($product_cat_tax_terms as $parent_tax_term) {
        $child_terms = get_product_cat_child_terms($parent_tax_term);
    }

    return $output;
}

function remove_extra_parent_term_from_breadcrumbs($terms)
{
    // Count items with parent = 0
    $parentZeroCount = 0;
    $parentZeroIds = [];
    $childItem = null;
    $indexToRemove = null;

    foreach ($terms as $index => $item) {
        if (
            is_array($item) &&
            isset($item["parent"]) &&
            $item["parent"] === 0
        ) {
            $parentZeroCount++;
            $parentZeroIds[] = $item["id"];
        } elseif (
            is_array($item) &&
            isset($item["parent"]) &&
            $item["parent"] !== 0
        ) {
            $childItem = $item;
        }
    }

    // If there's more than one item with parent = 0 and a child item exists
    if ($parentZeroCount > 1 && $childItem !== null) {
        // Check if the child's parent matches one of the parent = 0 items
        if (in_array($childItem["parent"], $parentZeroIds)) {
            // Find the item to remove (the one that doesn't match)
            foreach ($terms as $index => $item) {
                if (
                    is_array($item) &&
                    isset($item["parent"]) &&
                    $item["parent"] === 0 &&
                    $item["id"] !== $childItem["parent"]
                ) {
                    $indexToRemove = $index;
                    break;
                }
            }

            // Remove the item if found
            if ($indexToRemove !== null) {
                unset($terms[$indexToRemove]);
            }
        }
    }

    // Re-index the array
    return array_values($terms);
}
function get_breadcrumbs_from_queried_object($queried_object)
{
    $terms = get_the_terms($queried_object, "product_cat");
    $breadcrumbs = [];

    $breadcrumbs[] = [
        "page" => "Safes",
        "url" => get_permalink(3901),
    ];

    if ($terms && !is_wp_error($terms)) {
        // Custom sorting function
        usort($terms, function ($a, $b) {
            // If 'a' has no parent, it should come first
            if ($a->parent == 0) {
                return -1;
            }
            // If 'b' has no parent, it should come first
            if ($b->parent == 0) {
                return 1;
            }
            // If both have parents, maintain original order or sort by term_order if needed
            return $a->term_order <=> $b->term_order;
        });

        $childTerm = $terms[count($terms) - 1];

        if ($childTerm->parent !== 0) {
            $child_term_parent_id = $childTerm->parent;
        }

        $parent_count = 0;
        // Now $terms is sorted with "no parent" term first
        foreach ($terms as $term) {
            if ($term->parent === 0) {
                $parent_count++;
            }

            $breadcrumbs[] = [
                "page" => $term->name,
                "url" => get_term_link($term),
                "id" => $term->term_id,
                "parent" => $term->parent,
            ];
        }
    }

    $breadcrumbs = remove_extra_parent_term_from_breadcrumbs($breadcrumbs);

    return $breadcrumbs;
}

function output_breadcrumbs($queried_object)
{
    $breadcrumb_data = get_breadcrumbs_from_queried_object($queried_object);

    if (!empty($breadcrumb_data)) {
        $breadcrumbs =
            '<ol role="list" class="flex items-center space-x-2 pl-0 ml-0 list-none" vocab="https://schema.org/" typeof="BreadcrumbList" id="breadcrumbs">';

        foreach ($breadcrumb_data as $breadcrumb) {
            $link_text = str_replace("by AMSEC", "", $breadcrumb["page"]);
            $breadcrumbs .=
                '<li property="iitemListElement" typeof="ListItem">';
            $breadcrumbs .= '<div class="flex items-center text-sm">';
            $breadcrumbs .=
                '<a href="' .
                $breadcrumb["url"] .
                '" property="item" typeof="WebPage" class="text-gray-500 tracking-wide hover:text-blue-600 hover:underline">';
            $breadcrumbs .= $link_text . "</a>";
            $breadcrumbs .=
                '<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="breadcrumb-divide ml-2 h-5 w-5 flex-shrink-0 text-gray-300"><path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" /></svg>';
            $breadcrumbs .= "</div></li>";
        }

        $breadcrumbs .= "</ol>";
    }

    return $breadcrumbs;
}

function get_product_featured_image_id($product_id)
{
    $product = wc_get_product($product_id);

    if (!$product) {
        return null;
    }

    return $product->get_image_id();
}

function custom_product_image_gallery($post_id)
{
    $product = wc_get_product($post_id);

    if (!$product) {
        return;
    }

    $attachment_ids = $product->get_gallery_image_ids();
    $main_image_id = $product->get_image_id();

    if ($main_image_id) {
        array_unshift($attachment_ids, $main_image_id);
    }

    if ($attachment_ids) {
        echo '<div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">';
        echo '<div class="woocommerce-product-gallery__wrapper">';

        foreach ($attachment_ids as $attachment_id) {
            $image_url = wp_get_attachment_image_url($attachment_id, "full");
            $image_alt = get_post_meta(
                $attachment_id,
                "_wp_attachment_image_alt",
                true
            );
            $image_title = get_the_title($attachment_id);

            echo '<div class="woocommerce-product-gallery__image">';
            echo '<a href="' . esc_url($image_url) . '">';
            echo wp_get_attachment_image(
                $attachment_id,
                "woocommerce_single",
                false,
                [
                    "class" => "wp-post-image",
                    "alt" => $image_alt,
                    "title" => $image_title,
                    "data-src" => $image_url,
                    "data-large_image" => $image_url,
                    "data-large_image_width" => wp_get_attachment_image_src(
                        $attachment_id,
                        "full"
                    )[1],
                    "data-large_image_height" => wp_get_attachment_image_src(
                        $attachment_id,
                        "full"
                    )[2],
                ]
            );
            echo "</a>";
            echo "</div>";
        }

        echo "</div>";
        echo "</div>";
    }
}

function safe_attribute_array($tax = null)
{
    $attribute_array = [
        [
            "label" => "Price",
            "field" => "post_product_gun_price",
            "value" => "acf",
            "pre" => '$',
            "type" => "sort",
            "icon" => "price.svg",
            "attribute" => "detail",
        ],
        [
            "label" => "Weight",
            "field" => "post_product_gun_weight",
            "value" => "acf",
            "post" => "lbs",
            "type" => "sort",
            "icon" => "weight.svg",
            "attribute" => "size",
        ],
        [
            "label" => "Brand",
            "field" => "post_product_manufacturer",
            "value" => "acf",
            "global_field" => "filter_brand",
            "type" => "filter",
            "attribute" => "detail",
        ],
        [
            "label" => "Fire Rating",
            "field" => "post_product_fire_rating",
            "value" => "acf",
            "global_field" => "filter_fire_ratings",
            "type" => "filter",
        ],
        [
            "label" => "Security Rating",
            "field" => "post_product_security_rating",
            "value" => "acf",
            "global_field" => "filter_security_ratings",
            "type" => "filter",
            "attribute" => "rating",
        ],
        [
            "label" => "Type",
            "field" => "post_product_gun_type",
            "value" => "acf",
            "global_field" => "filter_type",
            "taxonomy" => "safe_type",
            "type" => "filter",
            "attribute" => "detail",
        ],
        [
            "label" => "Width",
            "field" => "post_product_gun_exterior_width",
            "value" => "acf",
            "post" => '"',
            "type" => "sort",
            "icon" => "width.svg",
            "attribute" => "size",
        ],
        [
            "label" => "Depth",
            "field" => "post_product_gun_exterior_depth",
            "value" => "acf",
            "post" => '"',
            "type" => "sort",
            "icon" => "depth.svg",
            "attribute" => "size",
        ],
        [
            "label" => "Height",
            "field" => "post_product_gun_exterior_height",
            "value" => "acf",
            "post" => '"',
            "type" => "sort",
            "icon" => "height.svg",
            "attribute" => "size",
        ],
    ];

    if ($tax) {
        $attribute_array[] = [];
    }
    return $attribute_array;
}
function safe_grid_attributes($post_id)
{
    $safe_attributes = safe_attribute_array();

    foreach ($safe_attributes as $key => &$safe_attribute) {
        $field_value = get_field($safe_attribute["field"], $post_id);

        // Field value is an array
        if (is_array($field_value)) {
            $concat_value = "";
            $seperator = empty($concat_value) ? "" : "/";

            // Taxonomy
            if ($safe_attribute["taxonomy"]) {
                $field_terms = get_terms([
                    "taxonomy" => $safe_attribute["taxonomy"],
                    "include" => array_values($field_value),
                ]);

                foreach ($field_terms as $field_term) {
                    $seperator = empty($concat_value) ? "" : "/";
                    $concat_value .= $seperator . $field_term->name;
                }
            }
            // Non taxonomy
            else {
                foreach ($field_value as $value) {
                    $seperator = empty($concat_value) ? "" : "/";
                    $concat_value .= $seperator . $value;
                }
            }

            $field_value = $concat_value;
        }

        $safe_attribute["value"] =
            $safe_attribute["label"] === "Security Rating" &&
            $field_value === "Not rated"
            ? "B-rated"
            : $field_value;
    }

    return $safe_attributes;
}

function sanitize_attribute_value($string)
{
    return trim(strtolower(str_replace(" ", "-", $string)));
}

function safe_type_badge($type)
{
    $output = "";

    if (str_contains($type, "/")) {
        $type = explode("/", $type);
        $type = array_map("trim", $type);

        foreach ($type as $badge) {
            $output .= '<span class="tw-badge">' . $badge . "</span>";
        }
    } else {
        $output .= '<span class="tw-badge">' . $type . "</span>";
    }

    return $output ?: null;
}

function format_attribute_class_name($safe_attribute)
{
    $class_name = "";
    $sanitized_val = sanitize_attribute_value($safe_attribute["value"]);
    $class_prefix =
        trim(strtolower(str_replace(" ", "-", $safe_attribute["label"]))) .
        "--";

    if (str_contains($sanitized_val, "/")) {
        $sanitized_val = explode("/", $sanitized_val);
        $sanitized_val = array_map("trim", $sanitized_val);

        foreach ($sanitized_val as $value) {
            $class_name .= $class_prefix . $value . " ";
        }
    } else {
        $class_name .= $class_prefix . $sanitized_val . " ";
    }

    return $class_name;
}

function safe_sort_badges($safe_attribute)
{
    if ($safe_attribute["value"]) {
        $pre_attribute = isset($safe_attribute["pre"])
            ? $safe_attribute["pre"]
            : "";
        $post_attribute = isset($safe_attribute["post"])
            ? $safe_attribute["post"]
            : "";
        $attribute_value =
            $pre_attribute . $safe_attribute["value"] . $post_attribute;

        $sort_badge =
            '<span class="tw-badge d-none ' .
            sanitize_attribute_value($safe_attribute["label"]) .
            '">';
        $sort_badge .=
            '<img class="d-inline filter-badge safe-sort-icon" src="' .
            get_template_directory_uri() .
            "/images/" .
            $safe_attribute["icon"] .
            '" />';
        $sort_badge .= $attribute_value;
        $sort_badge .= "</span>";

        return $sort_badge;
    }
}

function safe_filter_badge($safe_attribute)
{
    if ($safe_attribute["value"]) {
        $pre_attribute = isset($safe_attribute["pre"])
            ? $safe_attribute["pre"]
            : "";
        $post_attribute = isset($safe_attribute["post"])
            ? $safe_attribute["post"]
            : "";
        $attribute_value =
            $pre_attribute . $safe_attribute["value"] . $post_attribute;

        $filter_badge =
            '<span class="tw-badge badge-filter d-none ' .
            sanitize_attribute_value($safe_attribute["label"]) .
            '">';
        // $sort_badge .= '<img class="d-inline filter-badge safe-sort-icon" src="' . get_template_directory_uri() . '/images/' . $safe_attribute['icon'] . '" />';
        $filter_badge .= $attribute_value;
        $filter_badge .= "</span>";

        return $filter_badge;
    }
}

function get_safe_price_from_attributes($attributes)
{
    foreach ($attributes as $attribute) {
        if (
            isset($attribute["label"], $attribute["value"]) &&
            $attribute["label"] === "Price" &&
            !empty($attribute["value"]) &&
            $attribute["value"] != 0
        ) {
            return $attribute["value"];
        }
    }
    return null;
}

function get_grid_cta_btn_classes()
{
    return ' block text-center rounded-full bg-primary/90 hover:opacity-85 border border-transparent px-6 py-1.5 text-base font-semibold antialiased text-white shadow-sm hover:bg-secondary-600 hover:border hover:border-secondary-600 hover:shadow-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-500 tracking-normal hover:scale-105 ease-linear duration-150  ';
}

function safe_grid_item($post_id)
{
    $attributes = tw_safe_filters_array();
    $data_attributes = '';
    $badges = '<div class="badge-container">';

    // Get the product's categories
    $product_categories = get_the_terms($post_id, 'product_cat');
    $current_category = get_queried_object();

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
            if ($product_categories && !is_wp_error($product_categories)) {
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
    $product_card = '<a ' . $data_attributes . ' href="' . get_permalink( $post_id ) . '" class="group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white border-gray-200 rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 group/card">';
    $product_card .= '<div class="overflow-hidden h-48 w-full mx-auto">';

    $image_url = get_the_post_thumbnail_url($post_id, 'medium');
    $image_srcset = wp_get_attachment_image_srcset(get_post_thumbnail_id($post_id), 'medium');
    $image_sizes = wp_get_attachment_image_sizes(get_post_thumbnail_id($post_id), 'medium');

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

    $product_card .= '<h3 class="text-lg font-bold text-gray-800 dark:text-white group-hover:underline">';
    $product_card .= get_the_title($post_id) . '</h3>';

    $product_card .= output_featured_attributes($post_id);

    $product_card .= '<p class="mt-1 mb-6 text-gray-500 dark:text-neutral-400 text-base line-clamp-2">';
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

    if (!empty($safe_attributes)) {
        $class_names = "";
        $sort_badges = "";
        $filter_badges = "";
        $attribute_list = "";
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
            if (!empty($safe_attribute["value"])) {
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
    if (!empty($safe_price)) {
        // $safes .= '<p class="fs-5 tracking-wide">$' . $safe_price . '</p>';
        $safes .=
            '<p class="safe-price fs-5 inline tracking-wide">$' .
            $safe_price["discounted_price"] .
            "</p>";
    }

    // Sort Badges
    if (!empty($sort_badges)) {
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
    if (!empty($filter_badges)) {
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
// function safe_grid_item($post_id, $col_width = 4, $classes = null)
// {
//     $columns = $col_width ? "col-md-" . $col_width : "";

//     // ## CONTAINER ##
//     $safes = '<div class="mix ' . $columns . " mb-3 ";

//     // Data-attributes
//     $safe_attributes = safe_grid_attributes($post_id);

//     if (!empty($safe_attributes)) {
//         $class_names = "";
//         $sort_badges = "";
//         $filter_badges = "";
//         $attribute_list = "";
//         $attribute_output = "";

//         foreach ($safe_attributes as $safe_attribute) {
//             $sanitized_val = sanitize_attribute_value($safe_attribute["value"]);

//             // Class list
//             if ($safe_attribute["type"] === "filter") {
//                 $class_names .= format_attribute_class_name($safe_attribute);
//                 $filter_badges .= safe_filter_badge($safe_attribute);
//             }

//             // Sort badgets
//             if ($safe_attribute["type"] === "sort") {
//                 $sort_badges .= safe_sort_badges($safe_attribute);
//             }

//             // Date attributes
//             if ($safe_attribute["type"] === "sort") {
//                 $attribute_list .=
//                     "data-" .
//                     sanitize_attribute_value($safe_attribute["label"]) .
//                     '="' .
//                     sanitize_attribute_value($safe_attribute["value"]) .
//                     '" ';
//             }

//             if ($safe_attribute["label"] === "Brand") {
//                 $type_badge = safe_type_badge($safe_attribute["value"]);
//             }

//             // Attribute grid & badge (output)
//             if (!empty($safe_attribute["value"])) {
//                 $attribute_output .= '<div class="col-span-6">';
//                 $attribute_output .=
//                     '<p class="text-xs mb-0 text-capitalize fw-600">' .
//                     $safe_attribute["label"] .
//                     "</p>";
//                 $attribute_output .= "</div>";
//                 $attribute_output .= '<div class="col-span-6">';

//                 $pre_attribute = isset($safe_attribute["pre"])
//                     ? $safe_attribute["pre"]
//                     : "";
//                 $post_attribute = isset($safe_attribute["post"])
//                     ? $safe_attribute["post"]
//                     : "";
//                 $attribute_value =
//                     $pre_attribute . $safe_attribute["value"] . $post_attribute;

//                 $attribute_output .=
//                     '<p class="text-xs mb-0">' . $attribute_value . "</p>";
//                 $attribute_output .= "</div>";
//             }
//         }

//         $safes .= $class_names . '" ';
//         $safes .= $attribute_list;
//     }

//     $safes .= ">";
//     $safes .= '<div class="product h-100 bg-white">';

//     // ## IMAGE ##
//     $safes .= '<div class="text-center p-4 pb-0 product-img-container">';
//     $image_classes = $classes["image"] ?: "";
//     $safes .=
//         '<img src="' .
//         get_the_post_thumbnail_url($post_id) .
//         '" class="product-grid-image pb-4 ' .
//         $image_classes .
//         '"/>';
//     $safes .= "</div>";

//     // ## CONTENT ##
//     $safes .= '<div class="px-4 pb-4-5 product-text-container">';

//     // Capacity for Gun Safes
//     if (
//         has_term(37, "product_cat") &&
//         get_field("post_product_gun_capacity_total", $post_id)
//     ) {
//         $safes .=
//             '<p class="text-center mb-0 pb-0"><span class="d-none fw-light">Capacity:</span> ';
//         $safes .=
//             '<span class="fw-600 text-secondary">' .
//             get_field("post_product_gun_capacity_total", $post_id) .
//             " Guns</span></p>";
//     }

//     $safes .= '<div class="text-center">';

//     // Price
//     // $safe_price = get_safe_price_from_attributes($safe_attributes);
//     $safe_price = get_product_pricing($post_id);
//     if (!empty($safe_price)) {
//         // $safes .= '<p class="fs-5 tracking-wide">$' . $safe_price . '</p>';
//         $safes .=
//             '<p class="safe-price fs-5 inline tracking-wide">$' .
//             $safe_price["discounted_price"] .
//             "</p>";
//     }

//     // Sort Badges
//     if (!empty($sort_badges)) {
//         $safes .=
//             '<div class="d-flex flex-wrap justify-content-center gap-x-6 mb-4" id="sort-badges">';
//         $safes .= $sort_badges;
//         $safes .= "</div>";
//     }

//     // Product name
//     $safes .= "<h4>" . get_the_title($post_id) . "</h4>";

//     // Description
//     $description_classes = $classes["description"] ?: "";
//     $safes .=
//         '<p class="product-grid-description mb-0 ' .
//         $description_classes .
//         '">' .
//         get_field("post_product_gun_long_description", $post_id) .
//         "</p>";
//     $safes .= "</div>";

//     // Filter badges
//     if (!empty($filter_badges)) {
//         $safes .=
//             '<div class="d-flex flex-wrap justify-content-center badge-gap my-3 filter-badges" id="">';
//         $safes .= $filter_badges;
//         $safes .= "</div>";
//     }

//     $attributes = [
//         "weight",
//         "fire-rating",
//         "exterior-depth",
//         "exterior-width",
//         "exterior-height",
//     ];

//     // All attributes (new)
//     if (isset($attribute_output)) {
//         $safes .=
//             '<div class="accordion accordion-flush" id="productAttributeAccordion">';
//         $safes .= '<div class="accordion-item bg-transparent">';
//         $safes .= '<h2 class="accordion-header" id="flush-headingOne">';
//         $safes .=
//             '<button class="fw-600 anti bg-transparent accordion-button py-0 text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#product_' .
//             $post_id .
//             '" aria-expanded="false" aria-controls="product_' .
//             $post_id .
//             '">';
//         $safes .= "Product details";
//         $safes .= "</button>";
//         $safes .= "</h2>";
//         $safes .=
//             '<div id="product_' .
//             $post_id .
//             '" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#productAttributeAccordion">';
//         $safes .= '<div class="accordion-body px-0">';
//         $safes .= '<div class="grid grid-cols-12 gap-x-2 divide-y">';
//         $safes .= $attribute_output;
//         $safes .= "</div></div></div></div></div>";
//     }
//     // Dimension attributes (legacy)
//     else {
//         $attribute_array = get_formatted_product_attributes(
//             $post_id,
//             $attributes
//         );

//         $safe_attributes = [
//             ["2022/11/hsl-weigh.svg", "post_product_gun_weight", "lbs"],
//             ["2022/11/sl-height.svg", "post_product_gun_exterior_height", '"'],
//             ["2022/11/sl-width.svg", "post_product_gun_exterior_width", '"'],
//             ["2022/11/sl-length.svg", "post_product_gun_exterior_depth", '"'],
//         ];

//         if (is_array($attribute_array)) {
//             $icon_path = get_home_url() . "/wp-content/uploads/";
//             $safes .= '<ul class="list-group list-group-horizontal ps-0 ms-0">';

//             foreach ($safe_attributes as $safe_attribute) {
//                 $safes .=
//                     '<li class="list-group-item flex-fill  text-center d-flex flex-column align-items-center justify-content-center no-border">'; // code...
//                 $safes .=
//                     '<img src="' .
//                     $icon_path .
//                     $safe_attribute["0"] .
//                     '"  class="product-grid-icon mb-1" />';
//                 $attribute_value = (float) get_field(
//                     $safe_attribute[1],
//                     $post_id
//                 );
//                 $safes .=
//                     '<span class="fw-600 grid-attr-key">' .
//                     round($attribute_value, 2) .
//                     $safe_attribute[2] .
//                     "</span>";
//                 $safes .= "</li>";
//             }

//             $safes .= "</ul>";
//         }
//     }

//     $safes .=
//         '<div class="d-flex row-cols-2 justify-content-between mt-4 pt-2 gap-2 grid-btn-container">';
//     $safes .= '<div class="grid-btn-container">';
//     $safes .=
//         '<a class="btn px-3 py-1 w-100 small btn-outline-secondary" href="' .
//         get_permalink($post_id) .
//         '">View</a>';
//     $safes .= "</div>";
//     $safes .= '<div class="grid-btn-container text-end">';
//     $safes .= get_product_inquiry_btn(
//         $post_id,
//         "Inquiry",
//         null,
//         "btn px-2 py-1 w-100 small btn-outline-primary"
//     );
//     $safes .= "</div>";
//     $safes .= "</div>";
//     $safes .= "</div></div></div>";

//     return $safes ?: null;
// }
