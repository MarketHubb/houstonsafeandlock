<?php

$shopify_data = get_shopify_data(get_the_ID());

if ($shopify_data && ! empty($shopify_data['price'])) {
   get_template_part(
      "template-parts/shopify/content",
      "price",
      $shopify_data
   );
}
?>


<?php
get_template_part(
   "template-parts/shopify/content",
   "description",
);
?>

<?php
get_template_part(
   "template-parts/shopify/content",
   "button",
   $shopify_data
);
?>
<!-- Callouts -->
<?php
$callouts = get_callout_attributes(get_the_ID());

get_template_part(
   "template-parts/shopify/content",
   "callouts",
   $callouts
);
?>

