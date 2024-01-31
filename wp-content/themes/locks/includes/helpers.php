<?php
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
        if (!$number) { // zero
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
    $rows = get_field($repeater_field, $post_id);
    $row_index = $row_index - 1;

    if ($rows) {
        $repeater_field_row = $rows[$row_index];
        $repeater_field = $repeater_field_row[$sub_field];
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
    $percentChange =  (1 - ($new / $old)) * 100;

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
    $now_timestamp = time();
    $end_date = date_create($end_date);
    $day_after = date_add($end_date, date_interval_create_from_date_string("1 day"));
    $day_after_timestamp = strtotime(date_format($end_date, "Y-m-d"));

    return ($now_timestamp < $day_after_timestamp) ? true : false;
}
function featured_safes($location)
{
    $featured_safes = get_posts(array(
        'post_type' => 'product',
        'posts_per_page'    => -1,
        'meta_key' => 'featured',
        'meta_value' => true
    ));

    $featured = [];

    foreach ($featured_safes as $featured_safe) {
        $featured_fields = get_field('featured_safe', $featured_safe->ID);
        $is_active = is_featured_safe_active($featured_fields['end_date']);

        if ($featured_fields[$location] && $is_active) {
            $featured[] = $featured_safe->ID;
        }
    }

    return $featured;
}
function get_product_cat_image($cat)
{
    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
    return  wp_get_attachment_url($thumbnail_id);
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
    $nav = '';
    $dropdown = '<div class="d-flex justify-content-center" id="dropdown-product-cats">';
    $dropdown_links = '';

    if ($term_parent_id) {
        $parent = get_term($term_parent_id);
        $nav .= '<p class="text-center mb-1 fw-600">Models of ' . strtolower($parent->name) . ' we carry:</p>';
    }
    $nav  .= '<nav id="navbar-product-cats" class="navbar bg-transparent d-none d-md-block">';
    $nav  .= '<ul class="nav nav-pills ms-0 padding-start-0 nav-fill w-100">';

    foreach ($cats_array as $cat) {
        $term_link = ($cat->term_id === $current_term_id) ? "#" : get_term_link($cat);
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

    $current_term = get_term($current_term_id);
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
    $month = date('F');
    $percentage_off = (get_field('percentage_off', 'option')) ? get_field('percentage_off', 'option') : 20;

    if (get_field('sale_active', 'option')) {
        $copy = get_field('sale_discount_copy', 'option');
    } else {
        $copy = get_field('default_discount_copy', 'option');
        $msrp = get_field('post_product_gun_msrp', $post_id);

        if (isset($msrp) && !empty(trim($msrp))) {
            $price = get_price($msrp, $percentage_off);
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
    $oems = ['AMSEC', 'ORIGINAL', 'JEWEL'];

    foreach ($oems as $oem) {
        $model = str_replace($oem, '', $model);
    }

    return $model;
}
function get_warranty_information($post_id)
{
    $series_model = str_replace('AMSEC', '', get_the_title($post_id));
    $series_only = trim(preg_replace('/[0-9]+/', '', $series_model));
    $safe_height = get_field('post_product_gun_exterior_height', $post_id);

    $warranty = [
        'Parts & labor' => "1 year"
    ];

    if ($safe_height >= 55) {
        $warranty['Fire'] = "Lifetime";
        $warranty['Forced Entry'] = "Lifetime";
    }
    if ($series_only == 'BFX') {
        $warranty['Parts & labor'] = "5 years";
        $warranty['Fire'] = "Lifetime";
        $warranty['Forced Entry'] = "Lifetime";
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

    $msrp = clean_price(str_replace('$', '', $msrp));
    $price['msrp'] = intval($msrp);

    if ($discount && $type === 'percentage') {
        $price['discount_amount'] = intval($price['msrp'] * ($discount / 100));
        $price['sale_price'] = $price['msrp'] - $price['discount_amount'];
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
            $attribute['postfix'] =  '"';
            break;
    }

    return $attribute;
}
function return_manufacturer_attributes_logo($post_id)
{
    $oem = trim(strtolower(get_field('post_product_gun_manufacturer', $post_id)));

    if (have_rows('logos', 'option')) :
        while (have_rows('logos', 'option')) : the_row();
            $oem = trim(strtolower(get_field('post_product_gun_manufacturer', $post_id)));
            $oem_field_name = trim(strtolower(get_sub_field('name', 'option')));
            if ($oem_field_name === $oem) {
                $logo =  get_sub_field('grey', 'option');
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
            $attributes['safe_type'] = return_name_singular(get_term($term->parent, 'product_cat')->name);
            $attributes['safe_name'] = get_the_title($post_id);
            $attributes['safe_category'] = $term->name;

            break;
        }
    }

    return $attributes;
}

function get_safe_attribute_values($post_id, $attribute)
{
    $val = get_field('post_product_gun_' . str_replace('-', '_', $attribute), $post_id);
    $output_val = [];

    if ($attribute === 'msrp') {
        $val_clean = get_price($val, 20);
        $output_val['formatted'] = '$' . $val_clean['msrp_no_cents'];
        $output_val['clean'] = $val_clean['msrp'];
    } else if ($attribute === 'burglary_rating' || $attribute === 'manufacturer') {
        $output_val['formatted'] = str_replace(' Burglary Protection', '', $val);
        $output_val['clean'] = $val;
    } else {
        if (!empty($val) && is_numeric($val)) {
            $output_val['formatted'] = $val . get_formatted_attributes($attribute)['postfix'];
            $output_val['clean'] =  $val;
        } else {
            $output_val['formatted'] = "N/A";
            $output_val['clean'] =  0;
        }
    }

    return $output_val;
}

function get_product_inquiry_btn($post_id, $btn_text, $stretched = null, $custom_classes = null)
{
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
    $attr = get_safe_attributes($post_id);
    $stretched_class = $stretched ? 'stretched-link' : '';
    $classes = $custom_classes ?: 'btn btn-primary bg-orange d-block d-md-inline-block border-0';

    $btn  = '<button type="button" class="' . $classes . ' ';
    $btn .= $stretched_class . '" ';
    $btn .= 'data-bs-toggle="modal" data-bs-target="#productModal" ';
    $btn .= 'data-safeimage="' . $image[0] . '" ';
    $btn .= 'data-safetype="' . $attr['safe_type'] . '" ';
    $btn .= 'data-safename="' . get_the_title($post_id) . '">';
    $btn .= $btn_text . '</button>';

    return $btn;
}
//endregion
