<?php
/* region Filters & Sorts */
function get_product_sliders() {}

function get_product_filters($attributes_collection)
{
    if (empty($attributes_collection)) {
        return;
    }

    $filters = '<form class="mt-4 border-t border-gray-200" id="filters">';

    $slider_filters = array_filter($attributes_collection, function ($attribute) {
        return isset($attribute['input']) && $attribute['input'] === 'slider';
    });

    if (! empty($slider_filters)) {
        $filters .= output_filter_slider($slider_filters);
    }

    $checkbox_filters = array_filter($attributes_collection, function ($attribute) {
        return isset($attribute['input']) && $attribute['input'] === 'checkbox';
    });

    if (! empty($checkbox_filters)) {
        $filters .= output_filter_checkbox($checkbox_filters);
    }

    $filters .= '</form>';

    return $filters;
}

function get_product_sorts_by_tax() {}

function set_product_filter_array() {}
/* endregion */

/* region Attributes */
function get_product_attribute_post_id($post_id)
{
    return $post_id ?? null;
}

function get_product_attribute_image_url($post_id)
{
    return get_the_post_thumbnail_url($post_id, 'medium') ?? null;
}

function get_product_attribute_image_srcset($post_id)
{
    return wp_get_attachment_image_srcset(get_post_thumbnail_id($post_id), 'medium') ?? null;
}

function get_product_attribute_image_sizes($post_id)
{
    return wp_get_attachment_image_sizes(get_post_thumbnail_id($post_id), 'medium') ?? null;
}

function get_product_attribute_description_long($post_id)
{
    return get_field("post_product_gun_long_description", $post_id) ?? null;
}

function get_product_attribute_brand($post_id)
{
    return get_field('post_product_manufacturer', $post_id) ?? null;
}

function get_product_attribute_terms($post_id)
{
    $terms = get_the_terms($post_id, 'product_cat');

    if (! empty($terms)) {
        $attribute_terms = [];

        foreach ($terms as $term) {
            $attribute_terms[] = $term->name;
        }
    }

    return $attribute_terms;
}

function get_product_attribute_list_price($post_id)
{
    return get_product_attribute_discount_price($post_id);
}

function get_product_attribute_price($post_id)
{
    return get_product_list_price($post_id) ?? null;
}

function get_product_attribute_discount_price($post_id)
{
    return get_product_discount_price($post_id) ?? null;
}

function get_product_attribute_discount_amount($post_id)
{
    return get_product_discount_amount($post_id) ?? null;
}

function get_product_attribute_fire_rating($post_id)
{
    return get_field('post_product_fire_rating', $post_id) ?? null;
}

function get_product_attribute_weight($post_id)
{
    return get_field('post_product_gun_weight', $post_id) ?? null;
}

function get_product_attribute_security_rating($post_id)
{
    return get_field('post_product_security_rating', $post_id) ?? null;
}

function get_product_attribute_width($post_id)
{
    return get_field('post_product_gun_exterior_width', $post_id) ?? null;
}

function get_product_attribute_depth($post_id)
{
    return get_field('post_product_gun_exterior_depth', $post_id) ?? null;
}

function get_product_attribute_height($post_id)
{
    return get_field('post_product_gun_exterior_height', $post_id) ?? null;
}

function get_product_attribute_keys_filters()
{
    return [
        'brand',
        'terms',
        'price',
        'list_price',
        'discount_price',
        'discount_amount',
        'fire_rating',
        'weight',
        'security_rating',
        'width',
        'depth',
        'height',
    ];
}

function get_product_attribute_keys_post()
{
    return [
        'post_id',
        'image_url',
        'image_srcset',
        'image_sizes',
        'description_long',
    ];
}

function get_product_attributes($post_id)
{
    $attributes             = [];
    $attribute_keys_filters = get_product_attribute_keys_filters();
    $attribute_keys_post    = get_product_attribute_keys_post();
    $product_attributes     = array_merge($attribute_keys_filters, $attribute_keys_post);

    foreach ($product_attributes as $key) {
        $function_name = 'get_product_attribute_' . $key;

        if (function_exists($function_name)) {
            $attributes[$key] = call_user_func($function_name, $post_id);
        } else {
            $attributes[$key] = null;
        }
    }

    return $attributes;
}

function set_attributes_collection($attributes_collection, $post_attributes)
{
    foreach ($post_attributes as $key => $value) {

        if (! isset($attributes_collection[$key]) || ! $post_attributes[$key]) {
            continue;
        }

        if ($key === 'terms' && is_array($value)) {
            foreach ($value as $term) {
                if (! in_array($term, $attributes_collection['terms'])) {
                    $attributes_collection[$key][] = $term;
                }
            }
            continue;
        }

        if (! in_array($value, $attributes_collection[$key])) {
            $attributes_collection[$key][] = $value;
        }
    }

    return $attributes_collection;
}
/* endregion */

/* region Products */
function get_products_by_tax($queried_object)
{
    $term_id = $queried_object->term_id ?? null;

    if (! $term_id) {
        return;
    }

    $child_terms    = get_product_cat_child_terms($queried_object);
    $attribute_keys = get_product_attribute_keys_filters();
    $post_ids = [];
    $attributes_collection = array_combine($attribute_keys, array_fill(0, count($attribute_keys), []));
    $products_collection   = [];

    foreach ($child_terms as $child_term) {
        $product_posts_by_child_term = query_products_by_tax_term($child_term);

        if (! empty($product_posts_by_child_term)) {
            foreach ($product_posts_by_child_term as $product_post) {
                $product_attributes    = get_product_attributes($product_post->ID);
                $products_collection[] = get_product_grid_item($product_attributes);
                $attributes_collection = set_attributes_collection($attributes_collection, $product_attributes);
            }
        }
    }
    return [
        'products'   => $products_collection,
        'attributes' => $attributes_collection,
    ];
}

function get_product_post_data_attributes($data_attributes, $product_attributes, $filter)
{
    if (! $product_attributes[$filter]) {
        return $data_attributes;
    }

    if (is_array($product_attributes[$filter])) {
        $values = '';

        foreach ($product_attributes[$filter] as $value) {
            $values = implode(',', $product_attributes[$filter]);
        }

        return $data_attributes .= ' data-' . sanitize_title(str_replace('_', '-', $filter)) . '="' . $values . '"';
    }

    return $data_attributes .= ' data-' . sanitize_title(str_replace('_', '-', $filter)) . '="' . esc_attr($product_attributes[$filter]) . '"';
}

function product_grid_item($product_attributes)
{

    $product_card = '<a ' . $product_attributes['data_attributes'] . ' href="' . get_permalink($product_attributes['post_id']) . '" class="group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white border-gray-200 rounded-xl group/card">';
    $product_card .= '<div class="overflow-hidden h-48 w-full mx-auto">';

    if ($product_attributes['image_url']) {
        $product_card .= '<img class="!h-full w-auto  object-cover object-center rounded-t-xl transition-transform duration-300 ease-in-out group-hover:scale-105" ';
        $product_card .= ' src="' . esc_url($product_attributes['image_url']) . '" ';
        $product_card .= 'loading="lazy "';

        if ($product_attributes['image_srcset']) {
            $product_card .= 'srcset=" ' . $product_attributes['image_srcset'] . '" ';
        }

        if ($product_attributes['image_sizes']) {
            $product_card .= 'sizes="' . $product_attributes['image_sizes'] . '" />';
        }
    }

    $product_card .= '</div>';
    $product_card .= '<div class="p-4 md:p-5">';

    $price = $product_attributes['discount_price'] ?? 'Call for pricing';
    $product_card .= '<p class="text-base font-medium">$ ' . $price . '</p>';

    $product_card .= '<h3 class="text-lg font-bold text-gray-800">';
    $product_card .= get_the_title($product_attributes['post_id']) . '</h3>';

    $product_card .= output_featured_attributes($product_attributes['post_id']);

    $product_card .= '<p class="mt-1 mb-6 text-gray-500 text-base line-clamp-2">';
    $product_card .= $product_attributes['description_long'];
    $product_card .= '</p></div></a>';

    return $product_card;
}
function get_product_grid_item($product_attributes)
{
    $data_attributes        = '';
    $attribute_keys_filters = get_product_attribute_keys_filters();

    foreach ($attribute_keys_filters as $filter) {
        $data_attributes = get_product_post_data_attributes($data_attributes, $product_attributes, $filter);
    }

    $product_attributes['data_attributes'] = $data_attributes;

    return product_grid_item($product_attributes);
}
