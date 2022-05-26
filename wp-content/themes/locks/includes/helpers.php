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
