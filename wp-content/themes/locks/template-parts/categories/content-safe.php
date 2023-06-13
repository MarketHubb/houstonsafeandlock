<?php
$cat = $args;

$product_cats = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
) );

$child_terms_array = [];

if ($cat->parent === 0) {

    foreach ($product_cats as $product_cat) {

        if ($product_cat->parent === $cat->term_id && !get_field('hide', $product_cat)) {
            $child_terms_array[] = $product_cat->term_id;
        }

    }

    get_template_part('template-parts/categories/content', 'grid', $child_terms_array);

} elseif ( !get_field('hide', $cat) ) {

    get_template_part('template-parts/categories/content', 'grid-child', $cat->term_id);

}


?>
