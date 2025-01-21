<?php
function get_store_status()
{
    $hours_data = get_field('store_hours', 'option');

    if (empty($hours_data)) return null;

    // Set timezone to Central
    date_default_timezone_set('America/Chicago');

    // Get current time info
    $current_time = new DateTime('now');
    $current_day = $current_time->format('l'); // Full day name

    // Initialize return array
    $return = [
        'current_day' => $current_day,
        'is_open' => false,
        'time_until_closed' => null,
        'next_open_day' => null,
        'next_open_time' => null,
        'closes_at' => null
    ];

    // Find today's hours
    $today_hours = null;
    $current_day_index = null;
    foreach ($hours_data['hours'] as $index => $day_hours) {
        if ($day_hours['day'] === $current_day) {
            $today_hours = $day_hours;
            $current_day_index = $index;
            break;
        }
    }

    // Process current day status
    if ($today_hours && !empty($today_hours['open']) && !empty($today_hours['close'])) {
        $open_time = DateTime::createFromFormat('g:i a', $today_hours['open']);
        $close_time = DateTime::createFromFormat('g:i a', $today_hours['close']);

        // Set closes_at regardless of whether we're open or not
        $return['closes_at'] = $today_hours['close'];

        // Check if store is currently open
        if ($current_time >= $open_time && $current_time <= $close_time) {
            $return['is_open'] = true;

            // Calculate time until closing
            $interval = $current_time->diff($close_time);
            $hours = $interval->h;
            $minutes = $interval->i;

            // Format the time until closed
            if ($hours > 0) {
                $return['time_until_closed'] = $hours . ' hour' . ($hours > 1 ? 's' : '') .
                    ($minutes > 0 ? ' ' . $minutes . ' min' : '');
            } else {
                $return['time_until_closed'] = $minutes . ' min';
            }

            return $return; // Return early if store is currently open
        }
    }

    // Find next open day and time
    $days_checked = 0;
    $check_index = $current_day_index;
    $total_days = count($hours_data['hours']);

    while ($days_checked < 7) { // Check up to 7 days to prevent infinite loop
        // Move to next day, wrapping around to 0 if we reach the end
        $check_index = ($check_index + 1) % $total_days;
        $days_checked++;

        $check_day = $hours_data['hours'][$check_index];

        // Skip if no hours set for this day
        if (empty($check_day['open']) || empty($check_day['close'])) {
            continue;
        }

        // If we're checking today, make sure the opening time hasn't passed
        if ($check_day['day'] === $current_day) {
            $today_open_time = DateTime::createFromFormat('g:i a', $check_day['open']);
            if ($current_time > $today_open_time) {
                continue;
            }
        }

        // We found the next open day
        $return['next_open_day'] = $check_day['day'];
        $return['next_open_time'] = $check_day['open'];
        break;
    }

    return $return;
}

function get_store_status_message()
{
    $status = get_store_status();

    if (empty($status)) return null;

    if ($status['is_open']) {
        return sprintf(
            '<span class="block status-primary !leading-tight text-base font-bold antialiased">Need help fast?</span>' .
                '<span class="block status-secondary text-xs antialiased !leading-tight sm:text-base">We\'re open until %s today</span>',
            $status['closes_at']
        );
    } else {
        return sprintf(
            '<span class="block status-primary !leading-tight text-base font-bold antialiased">Leave us a message</span>' .
                '<span class="block status-secondary text-xs antialiased !leading-tight sm:text-base">We open %s at %s</span>',
            $status['next_open_day'],
            $status['next_open_time']
        );
    }
}

function get_current_object_id()
{
    return get_queried_object_id();
}
function remove_tw_prefix_from_classes($content)
{
    // Use a regular expression to find all class attributes
    return preg_replace_callback('/class\s*=\s*"([^"]*)"/', function ($matches) {
        // Get the class list and split by spaces
        $class_list = explode(' ', $matches[1]);

        // Remove the 'tw-' prefix from each class name if it exists
        $updated_class_list = array_map(function ($class) {
            return preg_replace('/^tw-/', '', $class);
        }, $class_list);

        // Join the updated class list back into a string
        return 'class="' . implode(' ', $updated_class_list) . '"';
    }, $content);
}

function display_contact_info($post_id)
{
    // Set timezone
    date_default_timezone_set('America/Chicago');

    // Get current time and day
    $current_time   = new DateTime();
    $current_day    = strtolower($current_time->format('l'));
    $current_hour   = (int) $current_time->format('G');
    $current_minute = (int) $current_time->format('i');

    // Define business hours
    $business_hours = [
        'monday'    => ['start' => 8, 'end' => 17],
        'tuesday'   => ['start' => 8, 'end' => 17],
        'wednesday' => ['start' => 8, 'end' => 17],
        'thursday'  => ['start' => 8, 'end' => 17],
        'friday'    => ['start' => 8, 'end' => 17],
        'saturday'  => ['start' => 9, 'end' => 16],
        'sunday'    => ['start' => 0, 'end' => 0], // Closed on Sunday
    ];

    // Check if current time is within business hours
    $is_business_hours = false;
    if (isset($business_hours[$current_day])) {
        $start = $business_hours[$current_day]['start'];
        $end   = $business_hours[$current_day]['end'];

        if ($current_hour > $start || ($current_hour == $start && $current_minute >= 0)) {
            if ($current_hour < $end || ($current_hour == $end && $current_minute == 0)) {
                $is_business_hours = true;
            }
        }
    }

    // Display appropriate contact info
    if ($is_business_hours) {
        // Phone number during business hours
        $phone           = '713-522-5555'; // Replace with actual phone number
        $contact_callout = "<a href='tel:$phone'>Call us: $phone</a>";
    } else {
        // Email outside business hours
        $email           = 'sales@houstonsafeandlock.com'; // Replace with actual email
        $location        = get_the_title($post_id);
        $contact_callout = "<a href='mailto:$email'>Email Houston Safe & Lock - ' . $location . '</a>";
    }

    return $contact_callout;
}

function standardize_pricing_data($pricing_data)
{
    // Initialize standardized array
    $standardized = array(
        'discount' => '',
        'price' => 0,
        'discount_amount' => 0,
        'discounted_price' => 0
    );

    // Standardize discount (ensure it ends with %)
    if (isset($pricing_data['discount'])) {
        $discount = trim($pricing_data['discount'], '% ');
        $standardized['discount'] = $discount . '%';
    }

    // Standardize price (convert to int, remove commas and cents)
    if (isset($pricing_data['price'])) {
        // $price = str_replace(',', '', $pricing_data['price']);
        // $price = str_replace(',', '', $pricing_data['price']);
        // $standardized['price'] = (int)round(floatval($price));
        $standardized['price'] = $pricing_data['price'];
    }

    // Standardize discount_amount
    if (isset($pricing_data['discount_amount'])) {
        $discount_amount = str_replace(',', '', $pricing_data['discount_amount']);
        // $standardized['discount_amount'] = (int)round(floatval($discount_amount));
        $standardized['discount_amount'] = $discount_amount;
    }

    // Standardize discounted_price
    if (isset($pricing_data['discounted_price'])) {
        if ($pricing_data['discounted_price'] !== NULL) {
            // $discounted_price = str_replace(',', '', $pricing_data['discounted_price']);
            $discounted_price = $pricing_data['discounted_price'];
            // $standardized['discounted_price'] = (int)round(floatval($discounted_price));
            $standardized['discounted_price'] = $pricing_data['discounted_price'];
        } else {
            // Calculate discounted_price if NULL
            $standardized['discounted_price'] = $standardized['price'] - $standardized['discount_amount'];
        }
    }

    return $standardized;
}


function get_product_pricing($post_id)
{
    $discount         = get_field('global_safes_discount_percentage', 'option') ?? null;
    $price            = get_field('post_product_gun_price', $post_id) ?? null;
    $discount_amount  = isset($price) ? $price * ($discount / 100) : null;
    $discounted_price = isset($discount_amount) ? $price - $discount_amount : null;

    $pricing_data = [
        'price'            => $price,
        'discount_amount'  => $discount_amount,
        'discounted_price' => $discounted_price,
        'discount'         => $discount,
    ];

    return standardize_pricing_data($pricing_data) ?? null;
}

function get_product_pricing_details($post_id)
{
    // Get the global discount percentage
    $discount_percentage = intval(get_field('global_safes_discount_percentage', 'option'));

    // Get the product price
    $msrp_price = floatval(get_field('post_product_gun_price', $post_id));

    // Calculate the discounted price
    $discount_amount  = $msrp_price * ($discount_percentage / 100);
    $discounted_price = $msrp_price - $discount_amount;

    // Round the prices to 2 decimal places
    $msrp_price       = round($msrp_price, 2);
    $discounted_price = round($discounted_price, 2);

    // Return the array with pricing details
    return [
        'msrp_price'          => $msrp_price,
        'discounted_price'    => $discounted_price,
        'discount_percentage' => $discount_percentage,
    ];
}

//region Global Helpers
function returnIntegerFromString($string)
{
    return intval(str_replace(",", "", str_replace(".00", "", str_replace("$", "", $string))));
}
function get_referring_url()
{
    $ref_url = null;

    if (isset($_SERVER['HTTP_REFERER'])) {
        $ref_url = $_SERVER['HTTP_REFERER'];
    }

    return $ref_url;
}
function formatMoney($number, $cents = 1)
{ // cents: 0=never, 1=if needed, 2=always
    if (is_numeric($number)) { // a number
        if (! $number) { // zero
            $money = ($cents == 2 ? '0.00' : '0'); // output zero
        } else { // value
            if (floor($number) == $number) { // whole number
                $money = number_format($number, ($cents == 2 ? 2 : 0)); // format
            } else { // cents
                $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
            } // integer or decimal
        } // value
        return '$' . $money;
    } // numeric
} // formatMoney
function get_repeater_field_row($repeater_field, $row_index, $sub_field, $post_id)
{
    $rows      = get_field($repeater_field, $post_id);
    $row_index = $row_index - 1;

    if ($rows) {
        $repeater_field_row = $rows[$row_index];
        $repeater_field     = $repeater_field_row[$sub_field];
    }

    return $repeater_field;
}
function discounted_price($starting_price, $discount_type, $discount_amount)
{
    if ($discount_type === "percentage") {
        $new_price = $starting_price - ($starting_price * ($discount_amount / 100));
        return formatMoney($new_price);
    }
}
function return_discount($old, $new)
{
    $percentChange = (1 - ($new / $old)) * 100;

    return round($percentChange, 0);
    // return $percentChange;
}
function return_phone_lead($post_id)
{
    // Category gun safes
    if ($post_id === 3857) {
        return "Call for Pricing";
    }

    return $post_id;
}
function return_name_singular($name)
{
    if (substr($name, -1) === 's') {
        return substr($name, 0, -1);
    } else {
        return $name;
    }
}
//endregion

//region Safes
function is_featured_safe_active($end_date)
{
    $now_timestamp       = time();
    $end_date            = date_create($end_date);
    $day_after           = date_add($end_date, date_interval_create_from_date_string("1 day"));
    $day_after_timestamp = strtotime(date_format($end_date, "Y-m-d"));

    return ($now_timestamp < $day_after_timestamp) ? true : false;
}
function featured_safes($location)
{
    $featured_safes = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'meta_key'       => 'featured',
        'meta_value'     => true,
    ]);

    $featured = [];

    foreach ($featured_safes as $featured_safe) {
        $featured_fields = get_field('featured_safe', $featured_safe->ID);
        $is_active       = is_featured_safe_active($featured_fields['end_date']);

        if ($featured_fields[$location] && $is_active) {
            $featured[] = $featured_safe->ID;
        }
    }

    return $featured;
}
function get_product_cat_image($cat)
{
    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
    return wp_get_attachment_url($thumbnail_id);
}

function get_formatted_product_attributes($post_id, $attributes)
{
    //    $attributes=['weight', 'fire-rating', 'exterior-depth', 'exterior-width', 'exterior-height'];
    $attribute_array = [];

    if (is_array($attributes)) {
        foreach ($attributes as $attribute) {
            $attribute_array[$attribute] = get_field('post_product_gun_' . str_replace('-', '_', $attribute), $post_id);
        }
    }

    return $attribute_array;
}

function remove_manufacturer_from_category_name($string)
{
    return preg_replace('/\sseries\s.*$/i', '', $string);
}

function get_sticky_sub_category_nav($cats_array, $current_term_id = null, $term_parent_id = null)
{
    $links_container = '<div class="mt-3 mt-md-0k mb-5">';
    $nav             = '';
    $dropdown        = '<div class="d-flex justify-content-center" id="dropdown-product-cats">';
    $dropdown_links  = '';

    if ($term_parent_id) {
        $parent = get_term($term_parent_id);
        $nav .= '<p class="text-center mb-1 fw-600">Models of ' . strtolower($parent->name) . ' we carry:</p>';
    }
    $nav .= '<nav id="navbar-product-cats" class="navbar bg-transparent d-none d-md-block">';
    $nav .= '<ul class="nav nav-pills ms-0 padding-start-0 nav-fill w-100">';

    foreach ($cats_array as $cat) {
        $term_link  = ($cat->term_id === $current_term_id) ? "#" : get_term_link($cat);
        $link_class = ($cat->term_id === $current_term_id) ? "active" : "";

        if ($cat->term_id !== $current_term_id) {
            $dropdown_links .= '<li class="py-1' . $link_class . '"><a class="dropdown-item" href="' . $term_link . '">' . $cat->name . '</a></li>';
        }

        $nav .= '<li class="nav-item ' . $link_class . '">';
        $nav .= '<a class="nav-link" href="' . $term_link . '">';
        $nav .= remove_manufacturer_from_category_name(get_term($cat)->name) . ' <span class="d-none d-lg-inline">Series</span></a>';
        $nav .= '</li>';
    }

    $nav .= '</ul></nav>';

    $dropdown .= '<div class="dropdown d-block d-md-none">';
    $dropdown .= '<a class="btn btn-brand btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">';

    $current_term  = get_term($current_term_id);
    $dropdown_text = $current_term ? $current_term->name : "Browse Categories";

    $dropdown .= $dropdown_text . '</a>';
    $dropdown .= '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
    $dropdown .= $dropdown_links;
    $dropdown .= '</ul></div></div>';

    $links_container .= $nav . $dropdown . '</div>';

    return $links_container;
}

function get_sale_copy_clean($post_id)
{
    $month          = date('F');
    $percentage_off = (get_field('percentage_off', 'option')) ? get_field('percentage_off', 'option') : 20;

    if (get_field('sale_active', 'option')) {
        $copy = get_field('sale_discount_copy', 'option');
    } else {
        $copy = get_field('default_discount_copy', 'option');
        $msrp = get_field('post_product_gun_msrp', $post_id);

        if (isset($msrp) && ! empty(trim($msrp))) {
            $price           = get_price($msrp, $percentage_off);
            $price_formatted = '<span class="fw-bolder">' . formatMoney($price['discount_amount']) . '</span>';
        } else {
            $price_formatted = '<span class="fw-bolder">HUNDREDS</span>';
        }

        $copy = str_replace('{AMOUNT}', $price_formatted, $copy);
    }

    return str_replace('{MONTH}', $month, $copy);
}
function get_model_name_clean($post_id)
{
    $model = strtoupper(get_the_title($post_id));
    $oems  = ['AMSEC', 'ORIGINAL', 'JEWEL'];

    foreach ($oems as $oem) {
        $model = str_replace($oem, '', $model);
    }

    return $model;
}
function get_warranty_information($post_id)
{
    $series_model = str_replace('AMSEC', '', get_the_title($post_id));
    $series_only  = trim(preg_replace('/[0-9]+/', '', $series_model));
    $safe_height  = get_field('post_product_gun_exterior_height', $post_id);

    $warranty = [
        'Parts & labor' => "1 year",
    ];

    if ($safe_height >= 55) {
        $warranty['Fire']         = "Lifetime";
        $warranty['Forced Entry'] = "Lifetime";
    }
    if ($series_only == 'BFX') {
        $warranty['Parts & labor'] = "5 years";
        $warranty['Fire']          = "Lifetime";
        $warranty['Forced Entry']  = "Lifetime";
    }

    return $warranty;
}
function clean_price($price)
{

    return str_replace(',', '', substr($price, 0, strpos($price, ".")));
}

function get_price($msrp, $discount, $type = 'percentage')
{
    $price['msrp_no_cents'] = str_replace('$', '', substr($msrp, 0, strpos($msrp, ".")));
    $price['msrp_no_comma'] = str_replace('$', '', str_replace(',', '', $msrp));

    $msrp          = clean_price(str_replace('$', '', $msrp));
    $price['msrp'] = intval($msrp);

    if ($discount && $type === 'percentage') {
        $price['discount_amount'] = intval($price['msrp'] * ($discount / 100));
        $price['sale_price']      = $price['msrp'] - $price['discount_amount'];
    }

    return $price;
}
function get_safe_type_attributes($post_id)
{
    $safe_type['attribute_label'] = "Safe Type";

    if (has_term(37, 'product_cat', $post_id)) {
        $safe_type['attribute_value'] = "Gun & Rifle";
        $safe_type['attribute_image'] = '/wp-content/uploads/2022/10/type-gun-4.svg';
    }

    return $safe_type;
}
function get_clean_attribute_labels($attribute)
{
    $label = ucwords(str_replace('-', ' ', $attribute));

    if (str_contains($label, 'Exterior')) {
        $label = str_replace('Exterior', '', $label);
    }
    if (str_contains($label, 'Capacity Total')) {
        $label = str_replace('Total', '', $label);
    }
    if (str_contains($label, 'Msrp')) {
        $label = 'MSRP';
    }

    return $label;
}
function get_formatted_attributes($label)
{
    $label = get_clean_attribute_labels($label);

    $attribute['name'] = $label;

    switch (true) {
        case str_contains($label, 'Weight'):
            $attribute['postfix'] = 'lbs';
            break;
        case str_contains($label, 'Capacity'):
            $attribute['postfix'] = ' Guns';
            break;
        case str_contains($label, 'Fire'):
            $attribute['postfix'] = ' Min';
            break;
        case str_contains($label, ''):
            $attribute['postfix'] = '"';
            break;
    }

    return $attribute;
}
function return_manufacturer_attributes_logo($post_id)
{
    $oem = trim(strtolower(get_field('post_product_gun_manufacturer', $post_id)));

    if (have_rows('logos', 'option')):
        while (have_rows('logos', 'option')): the_row();
            $oem            = trim(strtolower(get_field('post_product_gun_manufacturer', $post_id)));
            $oem_field_name = trim(strtolower(get_sub_field('name', 'option')));
            if ($oem_field_name === $oem) {
                $logo = get_sub_field('grey', 'option');
            }
        endwhile;
    endif;

    return $logo;
}
function return_manufacturer_logo_for_safe($title)
{
    $title = strtolower($title);

    switch (true) {
        case str_contains($title, 'jewel'):
            return '/wp-content/uploads/2016/09/jewel-safes-banner.jpg';
        case str_contains($title, 'amsec'):
            return '/wp-content/uploads/2019/11/2015-AMSEC-Logo-Stacked-CMYK-1.png';
        case str_contains($title, 'original'):
            return '/wp-content/uploads/2019/11/ORIGINAL-LOGO-black_highres-1.png';
        case str_contains($title, 'perma'):
            return '/wp-content/uploads/2022/09/Permavault-logo.jpg';
    }
}
function get_safe_attributes($post_id)
{
    $attributes = [];
    // type, cat, man

    $terms = get_the_terms($post_id, 'product_cat');

    foreach ($terms as $term) {
        if ($term->parent !== 0) {
            $attributes['safe_type']     = return_name_singular(get_term($term->parent, 'product_cat')->name);
            $attributes['safe_name']     = get_the_title($post_id);
            $attributes['safe_category'] = $term->name;

            break;
        }
    }

    return $attributes;
}

function get_safe_attribute_values($post_id, $attribute)
{
    $val        = get_field('post_product_gun_' . str_replace('-', '_', $attribute), $post_id);
    $output_val = [];

    if ($attribute === 'msrp') {
        $val_clean               = get_price($val, 20);
        $output_val['formatted'] = '$' . $val_clean['msrp_no_cents'];
        $output_val['clean']     = $val_clean['msrp'];
    } else if ($attribute === 'burglary_rating' || $attribute === 'manufacturer') {
        $output_val['formatted'] = str_replace(' Burglary Protection', '', $val);
        $output_val['clean']     = $val;
    } else {
        if (! empty($val) && is_numeric($val)) {
            $output_val['formatted'] = $val . get_formatted_attributes($attribute)['postfix'];
            $output_val['clean']     = $val;
        } else {
            $output_val['formatted'] = "N/A";
            $output_val['clean']     = 0;
        }
    }

    return $output_val;
}
function get_tw_product_btn($post_id, $btn_text)
{
    $image   = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
    $attr    = get_safe_attributes($post_id);
    $classes = 'flex w-full items-center justify-center rounded-md border border-transparent bg-orange px-8 py-3 text-base font-medium text-white hover:bg-orangeLight focus:outline-none focus:ring-2 focus:ring-orangeDark tracking-wide focus:ring-offset-2 focus:ring-offset-gray-50';

    $btn = '<button type="button" class="' . $classes . '" ';
    $btn .= 'data-bs-toggle="modal" data-bs-target="#productModal" ';
    $btn .= 'data-safeimage="' . $image[0] . '" ';
    $btn .= 'data-safetype="' . $attr['safe_type'] . '" ';
    $btn .= 'data-safename="' . get_the_title($post_id) . '">';
    $btn .= $btn_text . '</button>';

    return $btn;
}

function get_product_inquiry_btn($post_id, $btn_text, $stretched = null, $custom_classes = null)
{
    $image           = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
    $attr            = get_safe_attributes($post_id);
    $stretched_class = $stretched ? 'stretched-link' : '';
    $classes         = $custom_classes ?: 'btn btn-primary bg-orange d-block d-md-inline-block border-0';

    $btn = '<button type="button" class="' . $classes . ' ';
    $btn .= $stretched_class . '" ';
    $btn .= 'data-bs-toggle="modal" data-bs-target="#productModal" ';
    $btn .= 'data-safeimage="' . $image[0] . '" ';
    $btn .= 'data-safetype="' . $attr['safe_type'] . '" ';
    $btn .= 'data-safename="' . get_the_title($post_id) . '">';
    $btn .= $btn_text . '</button>';

    return $btn;
}
