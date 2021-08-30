<?php
//region Global
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

function get_product_inquiry_btn($post_id, $btn_text)
{
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
    $attr = get_safe_attributes($post_id);

    $btn  = '<button type="button" class="btn btn-primary inline-block" ';
    $btn .= 'data-toggle="modal" data-target="#productModal" ';
    $btn .= 'data-safeimage="' . $image[0] . '" ';
    $btn .= 'data-safetype="' . $attr['safe_type'] . '" ';
    $btn .= 'data-safename="' . get_the_title($post_id) . '">';
    $btn .= $btn_text . '</button>';

    return $btn;
}
//endregion
