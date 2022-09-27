<?php
//region Global Helpers
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
function return_discount($old, $new)
{
    $percentChange =  (1 - ($new/$old)) * 100;

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
    if (substr($name, -1) === 's')
    {
        return substr($name, 0, -1);
    } else {
        return $name;
    }
}
//endregion

//region Safes
function get_clean_attribute_labels($attribute) {
    $label = ucwords(str_replace('-', ' ', $attribute));

    if (str_contains($label, 'Exterior')) {
        $label = str_replace('Exterior', 'Ext.', $label);
    }

    return $label;
}
function get_formatted_attributes($label) {
    $label = get_clean_attribute_labels($label);

    $attribute['name'] = $label;

    switch (true) {
        case str_contains($label, 'Weight'):
            $attribute['postfix'] = 'lbs';
            break;
        case str_contains($label, 'Capacity'):
            $attribute['postfix'] = ' Guns';
            break;
        case str_contains($label, 'Rating'):
            $attribute['postfix'] = ' Minute';
            break;
        case str_contains($label, 'Ext'):
            $attribute['postfix'] =  '"';
            break;

    }

    return $attribute;
}
function return_manufacturer_logo_for_safe($title) {
    $title = strtolower($title);

    switch(true) {
        case str_contains($title, 'jewel'):
            return '/wp-content/uploads/2016/09/jewel-safes-banner.jpg';
        case str_contains($title, 'amsec'):
            return '/wp-content/uploads/2019/11/2015-AMSEC-Logo-Stacked-CMYK-1.png';
        case str_contains($title, 'original'):
            return '/wp-content/uploads/2019/11/ORIGINAL-LOGO-black_highres-1.png';
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

function get_product_inquiry_btn($post_id, $btn_text, $stretched=null)
{
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
    $attr = get_safe_attributes($post_id);
    $stretched_class = $stretched ? 'stretched-link' : '';

    $btn  = '<button type="button" class="btn btn-primary bg-orange d-block d-md-inline-block border-0 ';
    $btn .= $stretched_class . '" ';
    $btn .= 'data-bs-toggle="modal" data-bs-target="#productModal" ';
    $btn .= 'data-safeimage="' . $image[0] . '" ';
    $btn .= 'data-safetype="' . $attr['safe_type'] . '" ';
    $btn .= 'data-safename="' . get_the_title($post_id) . '">';
    $btn .= $btn_text . '</button>';

    return $btn;
}
//endregion
