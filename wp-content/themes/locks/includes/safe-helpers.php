<?php
function get_safe_attribute_data() {}

function get_safe_fire_rating($post_id)
{
    $fire_rating = get_field('post_product_fire_rating', $post_id);
    if (empty($fire_rating)) {
        return false;
    }
    return $fire_rating;
}
