<?php

//if (is_archive() && !is_shop()) {
//
//    $term = get_terms( array (
//        'taxonomy' => 'product_cat',
//        'name' => woocommerce_page_title( false )
//    ));
//
//
//} else if (is_singular('product')) {
//
//    $term = get_the_terms( $post->ID, 'product_cat' );
//    $parent_term = ri_get_product_parent_tax( $term );
//
//}
//
//if (is_shop()) {
//
//    $alerts['desktop'] = get_field('field_5dea85d0f82c7', 'option');
//    $alerts['mobile'] = get_field('field_5defc058afe02', 'option');
//
//
//} else {
//
//    $parent_term = ri_get_product_parent_tax( $term );
//    $alerts  = ri_get_product_alert($parent_term->term_id);
//}
?>

<?php
$alerts = [];

if (is_shop() || is_archive() || is_singular('product')) {
    $alerts['desktop'] = get_field('field_5dea85d0f82c7', 'option');
    $alerts['mobile'] = get_field('field_5defc058afe02', 'option');
} else if (is_page(get_sem_locksmith_pages())) {
    $alerts['desktop'] = get_field('field_5e3051eaaf4fb', 'option');
    $alerts['mobile'] = get_field('field_5e305205af4fc', 'option');
}
?>

<div class="alert alert-primary text-center" role="alert">

    <span class="safe-alert-message d-none d-lg-block"><?php echo $alerts['desktop']; ?></span>
    <span class="safe-alert-message d-lg-none"><?php echo $alerts['mobile']; ?></span>

</div>