<?php
function replace_placeholders_in_string($string)
{
    // Check if the string contains any placeholders
    if (strpos($string, '{') === false) {
        return $string;
    }

    // Define a mapping of placeholders to functions
    $placeholderFunctions = [
        'discount' => 'get_sale_discount',
        'end_date' => 'get_sale_end_date'
    ];

    // Use a callback function to replace placeholders
    $result = preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($placeholderFunctions) {
        $placeholder = $matches[1];

        // Check if the function exists for the given placeholder
        if (isset($placeholderFunctions[$placeholder]) && function_exists($placeholderFunctions[$placeholder])) {
            return call_user_func($placeholderFunctions[$placeholder]);
        }

        // Return the original placeholder if no function is found
        return $matches[0];
    }, $string);

    return $result;
}

function strip_trailing_s($string)
{
    return substr($string, -1) === 's' ? substr($string, 0, -1) : $string;
}


function get_attribute_badges_for_safes($post_id)
{
    $attribute_fields = [
        ['Capacity' => 'post_product_gun_gun_capacity'],
        ['Manufacturer' => 'post_product_manufacturer'],
        ['Fire Rating' => 'post_product_fire_rating'],
        ['Security Rating' => 'post_product_security_rating'],
    ];
    return array_map(function ($item) use ($post_id) {
        $key        = key($item);
        $field_name = current($item);

        return [
            $key => get_field($field_name, $post_id) ?: null,
        ];
    }, $attribute_fields);
}
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

        $class     = ($menu_item_index === 0) ? 'block px-4 py-2 text-sm font-medium text-gray-900' : 'block px-4 py-2 text-sm text-gray-500';
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
    $output                = '';
    $product_post_ids      = []; // keep track for products in duplicate categories
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
    $parentZeroIds   = [];
    $childItem       = null;
    $indexToRemove   = null;

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
    $terms       = get_the_terms($queried_object, "product_cat");
    $breadcrumbs = [];

    $breadcrumbs[] = [
        "page" => "All Safes",
        "url"  => get_permalink(3901),
        "is_link" => true
    ];

    if ($terms && !is_wp_error($terms)) {
        usort($terms, function ($a, $b) {
            if ($a->parent == 0) return -1;
            if ($b->parent == 0) return 1;
            return $a->term_order <=> $b->term_order;
        });

        foreach ($terms as $term) {
            if ($term->term_id !== 75 && !$term->parent) {
                $breadcrumbs[] = [
                    "page"   => $term->name,
                    "url"    => get_term_link($term),
                    "id"     => $term->term_id,
                    "parent" => $term->parent,
                    "is_link" => true
                ];
            }
        }
    }

    // Append the current product title as the last breadcrumb
    if (is_singular('product')) {
        $breadcrumbs[] = [
            "page" => get_the_title($queried_object),
            "is_link" => false
        ];
    }

    $breadcrumbs = remove_extra_parent_term_from_breadcrumbs($breadcrumbs);

    return $breadcrumbs;
}

function clean_breadcrumb_link_text($text)
{
    $remove_array = ['American Security', 'Series', 'by AMSEC', 'By AMSEC'];
    $replace_array = [
        ['Minute' => 'Min'],
        ['American Security' => 'AMSEC']
    ];

    // First remove all words from remove_array
    foreach ($remove_array as $word) {
        $text = str_replace($word, '', $text);
    }

    // Then replace words based on replace_array
    foreach ($replace_array as $pair) {
        foreach ($pair as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
    }

    // Clean up extra spaces and trim
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);

    return $text;
}

function output_breadcrumbs($queried_object)
{
    $breadcrumb_data = get_breadcrumbs_from_queried_object($queried_object);

    if (!empty($breadcrumb_data)) {
        $breadcrumbs = '<ol role="list" class="flex items-center md:space-x-2 pl-0 ml-0 list-none" vocab="https://schema.org/" typeof="BreadcrumbList" id="breadcrumbs" aria-label="Breadcrumb">';

        $total_items = count($breadcrumb_data);

        foreach ($breadcrumb_data as $index => $breadcrumb) {
            $is_last = ($index === $total_items - 1);
            $link_text = clean_breadcrumb_link_text($breadcrumb['page']);

            // $link_text = str_replace("by AMSEC", "", $breadcrumb["page"]);

            $breadcrumbs .= '<li property="itemListElement" typeof="ListItem">';
            $breadcrumbs .= '<div class="flex items-center text-sm">';

            if ($is_last) {
                // Last item: no link, gray text
                $breadcrumbs .= '<span class="text-gray-500 tracking-wide">' . $link_text . '</span>';
            } else {
                // All other items: linked with blue color
                $breadcrumbs .= '<a href="' . $breadcrumb["url"] . '" property="item" typeof="WebPage" class="text-blue-600 tracking-wide hover:text-blue-800 hover:underline">';
                $breadcrumbs .= $link_text . '</a>';
            }

            // Add divider only if it's not the last item
            if (!$is_last) {
                $breadcrumbs .= '<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="breadcrumb-divide h-4 md:h-5 w-auto flex-shrink-0 text-gray-300"><path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" /></svg>';
            }

            $breadcrumbs .= '</div></li>';
        }

        $breadcrumbs .= '</ol>';
    }

    return $breadcrumbs;
}


function get_product_featured_image_id($product_id)
{
    $product = wc_get_product($product_id);

    if (! $product) {
        return null;
    }

    return $product->get_image_id();
}

function custom_product_image_gallery($post_id)
{
    $product = wc_get_product($post_id);

    if (! $product) {
        return;
    }

    $attachment_ids = $product->get_gallery_image_ids();
    $main_image_id  = $product->get_image_id();

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
                    "class"                   => "wp-post-image",
                    "alt"                     => $image_alt,
                    "title"                   => $image_title,
                    "data-src"                => $image_url,
                    "data-large_image"        => $image_url,
                    "data-large_image_width"  => wp_get_attachment_image_src(
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
            "label"     => "Price",
            "field"     => "post_product_gun_price",
            "value"     => "acf",
            "pre"       => '$',
            "type"      => "sort",
            "icon"      => "price.svg",
            "attribute" => "detail",
        ],
        [
            "label"     => "Weight",
            "field"     => "post_product_gun_weight",
            "value"     => "acf",
            "post"      => "lbs",
            "type"      => "sort",
            "icon"      => "weight.svg",
            "attribute" => "size",
        ],
        [
            "label"        => "Brand",
            "field"        => "post_product_manufacturer",
            "value"        => "acf",
            "global_field" => "filter_brand",
            "type"         => "filter",
            "attribute"    => "detail",
        ],
        [
            "label"        => "Fire Rating",
            "field"        => "post_product_fire_rating",
            "value"        => "acf",
            "global_field" => "filter_fire_ratings",
            "type"         => "filter",
        ],
        [
            "label"        => "Security Rating",
            "field"        => "post_product_security_rating",
            "value"        => "acf",
            "global_field" => "filter_security_ratings",
            "type"         => "filter",
            "attribute"    => "rating",
        ],
        [
            "label"        => "Type",
            "field"        => "post_product_gun_type",
            "value"        => "acf",
            "global_field" => "filter_type",
            "taxonomy"     => "safe_type",
            "type"         => "filter",
            "attribute"    => "detail",
        ],
        [
            "label"     => "Width",
            "field"     => "post_product_gun_exterior_width",
            "value"     => "acf",
            "post"      => '"',
            "type"      => "sort",
            "icon"      => "width.svg",
            "attribute" => "size",
        ],
        [
            "label"     => "Depth",
            "field"     => "post_product_gun_exterior_depth",
            "value"     => "acf",
            "post"      => '"',
            "type"      => "sort",
            "icon"      => "depth.svg",
            "attribute" => "size",
        ],
        [
            "label"     => "Height",
            "field"     => "post_product_gun_exterior_height",
            "value"     => "acf",
            "post"      => '"',
            "type"      => "sort",
            "icon"      => "height.svg",
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
            $seperator    = empty($concat_value) ? "" : "/";

            // Taxonomy
            if ($safe_attribute["taxonomy"]) {
                $field_terms = get_terms([
                    "taxonomy" => $safe_attribute["taxonomy"],
                    "include"  => array_values($field_value),
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
    $class_name    = "";
    $sanitized_val = sanitize_attribute_value($safe_attribute["value"]);
    $class_prefix  =
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
            ! empty($attribute["value"]) &&
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


