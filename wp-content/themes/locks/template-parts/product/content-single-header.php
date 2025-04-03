<?php if (! isset($args)) return; ?>

<?php
$title_data = get_product_attribute_brand_and_model($args);
$callout = $title_data['brand'] ?? null;
$title = $title_data['title'] ?? null;
$product_title = output_hero([
   'callout' => $callout,
   'heading' => $title
]);
echo $product_title;;

 ?>

<!-- <div class="flex flex-col justify-between"> -->
   <?php //echo get_product_title($args); ?>
   <?php echo output_product_description($args); ?>
<!-- </div> -->