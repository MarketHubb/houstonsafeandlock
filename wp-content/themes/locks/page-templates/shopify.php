<?php /* Template Name: Shopify */

get_header(); ?>

<div class="container mx-auto">
	<div class="grid grid-cols-1">
		<?php
		debug_inventory();

		// $output = '';
		// $products = [];
		// foreach ($products as $product) {
		// 	if (isset($product['variants'])) {
		// 		foreach ($product['variants'] as $variant) {
		// 			if ($variant['inventory_quantity'] > 0) {
		// 				$output .= '<h3>' . $product['title'] . '</h3>';				
		// 			}
		// 		}
		// 	}
		// }

		// echo $output;

		?>
	</div>
</div>

<?php get_footer(); ?>