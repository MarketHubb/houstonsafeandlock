<?php
// Predicates
function is_safe_parent_page()
{
    return get_queried_object_id() === 3901;
}

function is_safe_tax_page()
{
    return is_tax('product_cat');
}

function is_safe_rated(string $attribute_value)
{
    if (empty($attribute_value)) return null;

    if (!str_contains('not rated', strtolower($attribute_value))) {
        return $attribute_value;
    }

    return false;
}
// endregion

// Price & Discounts
function get_pricing_source()
{
    return get_field('safe_price_source', 'option');
}

function get_global_discount()
{
    return get_field('safe_discount', 'option');
}

function split_price($price)
{
    // Convert to float and format to ensure 2 decimal places
    $formatted = number_format((float)$price, 2, '.', '');

    // Split at decimal point
    $parts = explode('.', $formatted);

    return [
        'dollars' => $parts[0],
        'cents' => $parts[1]
    ];
}
// region Content
function remove_safes_from_string($string)
{
    return trim(str_replace("Safes", "", $string));
}

function get_product_attribute_brand_and_model($product_attributes)
{
    if (empty($product_attributes['post_id'])) return null;

    $title = get_the_title($product_attributes['post_id']);
    $brand = $product_attributes['brand'] ?? null;
    $model = str_replace($brand, '', $title);

    if (str_contains($title, 'Second Amendment') && $brand === 'Blue Dot') {
        $brand = 'Second Amendment';
        $title = str_replace('Second Amendment', '', $title);
    } elseif ($brand === 'AMSEC') {
        $brand = !str_contains($brand, 'AMSEC') ? $brand : 'American Security';
    } elseif ($brand !== 'AMSEC') {
        $title = $model;
    }

    return [
        'title' => $title,
        'brand' => $brand,
        'model' => $model
    ];
}

function get_icon_for_attribute($attribute)
{
    $attributes = [
        'price' =>
        [
            'icon' => '/wp-content/uploads/2024/08/noun-price-tag-7101751.svg'
        ],
        'brand' => [
            'icon' => '/wp-content/uploads/2024/08/AMSEC-Wings.png'
        ],
        'type' => [
            'icon' => '/wp-content/uploads/2022/10/type-gun-4.svg'
        ],
        'fire rating' => [
            'icon' => '/wp-content/uploads/2022/11/hsl-fire.svg'
        ],
        'security rating' => [
            'icon' => '/wp-content/uploads/2022/11/rating.svg'
        ],
        'weight' => [
            'icon' => '/wp-content/uploads/2022/11/hsl-weigh.svg',
        ],
        'width' => [
            'icon' => '/wp-content/uploads/2022/11/sl-width.svg'
        ],
        'depth' => [
            'icon' => '/wp-content/uploads/2022/11/sl-length.svg'
        ],
        'height' => [
            'icon' => '/wp-content/uploads/2022/11/sl-height.svg'
        ]
    ];
}
// endregion

// region Attributes
function get_product_title($product_attributes)
{
    $product_name = get_product_attribute_brand_and_model($product_attributes);
    $product_title  = '<div class="">';
    $product_title .= '<h1 class="text-2xl md:text-4xl lg:text-5xl text-gray-800 !leading-none">';

    if (isset($product_name['brand'])) {
        $product_title .= '<span class="block font-normal tracking-[.25rem] text-gray-400 text-base uppercase">' . $product_name['brand'] . '</span>';
    }

    $product_title .= $product_name['title'];
    $product_title .= '</h1>';
    $product_title .= '</div>';

    return $product_title;
}

function data_attribute_group_name(string $filter_name)
{
    if (empty($filter_name)) return null;

    if ($filter_name === 'categories' || $filter_name === 'Categories') {
        $filter_name = 'category';
    }

    return replace_space_with_underscore($filter_name);
}

function data_attribute_input_value(mixed $input_value)
{
    if (empty($input_value)) return null;

    if (str_contains($input_value, 'All ')) {
        $input_value = 'all';
    }

    if (str_contains($input_value, 'Featured ')) {
        $input_value = 'featured';
    }

    return replace_space_with_underscore($input_value);
}

function get_formatted_product_attribute_callouts($callouts)
{
    // Suppress warnings due to invalid HTML structures
    libxml_use_internal_errors(true);

    $dom = new DOMDocument();
    // Load the HTML. Adding a UTF-8 meta can help avoid encoding issues.
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $callouts);

    // Clear any errors collected during loadHTML
    libxml_clear_errors();

    // Create an XPath to query DOM nodes
    $xpath = new DOMXPath($dom);

    // Query all <li> elements (you could refine with "//ul/li" if needed)
    $liNodes = $xpath->query('//li');

    $items = [];
    foreach ($liNodes as $li) {
        // textContent automatically excludes any inner <i> tags' text
        // (if those <i> tags contained text).
        // Usually icon <i> tags are empty, so you'll just get the textual part.
        $text = trim($li->textContent);

        // Add to the results array if it's not empty
        if (!empty($text)) {
            $items[] = $text;
        }
    }

    return $items;
}
// endregion

// region Strings
function replace_space_with_underscore(string $string, bool $lower_case = true)
{
    return $lower_case
        ? trim(strtolower(str_replace(' ', '_', $string)))
        : trim(str_replace(' ', '_', $string));
}
// endregion