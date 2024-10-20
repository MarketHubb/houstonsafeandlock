<?php

/* Template Name: All Safes (New) */

get_header();

?>

<?php get_template_part('template-parts/tw-shared/content', 'grid'); ?>

<?php
$safe_parent_categories = get_product_cat_tax_terms();
$output = '';
$attributes = [];


foreach ($safe_parent_categories as $parent_category) {
    $products_by_parent_term = get_product_posts_by_tax($parent_category->term_id);
    $output .= $products_by_parent_term['output'];
    
    if (empty($attributes)) {
        $attributes = $products_by_parent_term['attributes'];
    } else {
        foreach ($products_by_parent_term['attributes'] as $key => $attribute) {
            if (isset($attribute['values'])) {
                $attributes[$key]['values'] = array_unique(
                    array_merge(
                        $attributes[$key]['values'],
                        $attribute['values']
                    )
                );
            }
        }
    }
}

$products = [
    'output' => $output,
    'attributes' => $attributes,
];

$grid_args = [
    'heading' => 'Safes for Sale',
    'description' => 'We carry the largest selection of in-stock, ready-to-ship safes in HoustonHave questions? Our team of safe & security experts can help.',
    'products' => $products,
];

get_template_part('template-parts/tw-shared/content', 'grid', $grid_args); ?>

</section>
<?php get_footer(); ?>