<?php
function is_ecommerce_enabled()
{
    return get_field('safe_enable_ecommerce', 'option');
}

function is_pricing_displayed()
{
    return get_field('safe_display_prices', 'option');
}

function is_discount_displayed()
{
    return get_field('safe_display_discount', 'option');
}

function get_pricing_source()
{
    return get_field('safe_price_source', 'option');
}

/* region Discounts */
function get_global_discount()
{
    return get_field('safe_discount', 'option');
}

function get_product_discount_percentage()
{
    if (is_sale_active() && get_sale_discount() > 0) {
        return get_sale_discount();
    }

    return get_global_discount();
}

function get_product_discount_amount($post_id)
{
    $price = get_product_list_price($post_id);
    $discount_percentage = get_product_discount_percentage();

    if (!$price) return null;

    return floatval($price) * ($discount_percentage / 100.0);
}
/* endregion */

/* region Currency & Price */
function remove_cents_from_currency($currency)
{

    if (!is_numeric($currency)) {
        return "Invalid input: not a numeric value.";
    }

    // Cast the currency to a float for processing
    $currency = (float)$currency;

    // Check if the currency has cents
    $decimalPart = fmod($currency, 1); // Get the decimal part of the number
    $roundedCurrency = ($decimalPart == 0) ? (int)$currency : round($currency);

    // Format the number with commas if greater than 999
    $formattedCurrency = ($roundedCurrency > 999) ? number_format($roundedCurrency) : $roundedCurrency;

    return $formattedCurrency;
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

function format_product_amounts($price)
{
    $price_float = floatval($price);
    $formatted_prices = [];
    $formatted_prices['currency'] = number_format($price_float, 2, '.', ',');
    $formatted_prices['rounded'] = number_format(round($price_float), 0, '.', ',');

    return $formatted_prices;
}

function get_product_price_shopify($post_id)
{
    $shopify_data = get_field('product_inventory', $post_id);

    if (isset($shopify_data) && ! empty($shopify_data[0]['price'])) {
        $price = $shopify_data[0]['price'];
    }

    return $price ?? null;
}

function get_product_price_website($post_id)
{
    $price = get_field('post_product_gun_price', $post_id);

    return $price ?? null;
}

function get_product_list_price($post_id)
{
    $list_price = get_pricing_source() === 'Shopify' ? get_product_price_shopify($post_id) : get_product_price_website($post_id);

    $list_price = $list_price ?? get_product_price_website($post_id);

    return $list_price ?? null;
}

function get_product_discount_price($post_id)
{
    $list_price = get_product_list_price($post_id);

    if (!$list_price) return;

    $discount_percentage = get_product_discount_percentage();

    if (!$discount_percentage || $discount_percentage === 0) return $list_price;

    $discount_price = floatval($list_price) * (1 - $discount_percentage / 100.0);

    return number_format($discount_price, 2, '.', '');
}
/* endregion */

/* region output */
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
/* endregion */

/* region filters & sorts */
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
/* endregion */

/* region content */

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

function get_product_price_format($price_val)
{
    $price_split = split_price($price_val);

    if (empty($price_split['dollars']) || empty($price_split['cents'])) return;

    $price  = '<div class="inline-flex justify-center items-center sm:items-start">';
    $price .= '<span class="text-xs sm:text-base font-bold antialiased tracking-tight !leading-none font-system">$</span>';
    $price .= '<span class="text-xl sm:text-[1.4rem] md:text-[1.6rem] font-semibold tracking-normal align-middle !leading-none pl-[1px] font-system relative sm:bottom-[2px]">' . $price_split['dollars'] . '</span>';
    $price .= '<span class=" inline-flex font-system pl-[.02rem]">';
    $price .= '<span class="inline-flex text-xs sm:text-base font-semibold tracking-tight align-start !leading-none relative font-system">.' . $price_split['cents'] . '</span>';
    $price .= '</span>';
    $price .= '</div>';

    return $price;
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

function get_formatted_product_attribute_specs_table($tableHtml) {
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
    $rows = $dom->getElementsByTagName('tr');
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

/* endregion */
