<?php
if (empty($args)) return;
$product_data = $args;
$filters_sorts = get_product_range_filter_data($product_data);
$product_collection = init_safes();
$product_ids = $product_collection['safe_ids'];
$filter_data = product_filters_sorts($product_collection);
?>

<!-- Sorts -->
<div class="flex justify-between flex-row-reverse gap-x-8">

	<?php
	$search = $filter_data['search'];
	get_template_part('template-parts/product/content', 'sort', $search);
	?>

</div>

<section aria-labelledby="products-heading" class="pb-24 pt-0 md:pt-6" id="product-list">
	<h2 id="products-heading" class="sr-only">Products</h2>

	<div class="grid grid-cols-1 gap-x-8 lg:grid-cols-4">
		<!-- Filters -->
		<?php get_template_part('template-parts/product/content', 'filter-sidebar', $filter_data); ?>

		<!-- Products -->
		<div class="lg:col-span-3">
			<div class="grid grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-4 lg:gap-x-5 lg:gap-y-6 product-grid">

				<?php
				$products = output_products($product_collection['safe_ids']['init']);
				echo $products;
				// $products = '';
				// $product_ids = [];
				// $products_sorted = sort_products_by_price($product_data['data']);

				// foreach ($products_sorted as $product_data) {
				// 	$product_ids[] = $product_data['post_id'];
				// 	$product_data['featured'] = true;

				// 	if ($product_data['brand']) {
				// 		$products .= get_product_grid_item($product_data);
				// 	}
				// }
				// echo $products;
				?>

			</div>
		</div>

	</div>
</section>

<script type="text/javascript">
	// The safeProductIds variable now holds an array of product IDs rendered on this page.
	var safeProductIds = <?php echo json_encode($product_ids); ?>;
	console.log('Safe Product IDs:', safeProductIds);
</script>