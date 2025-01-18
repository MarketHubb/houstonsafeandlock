<?php
if (empty($args)) return;
$product_collection = $args;
$filters_sorts = get_product_filters_sorts($product_collection);
?>

<!-- Sorts -->
<?php get_template_part('template-parts/product/content', 'sort', $filters_sorts); ?>

<section aria-labelledby="products-heading" class="pb-24 pt-0 md:pt-6" id="product-list">
	<h2 id="products-heading" class="sr-only">Products</h2>
	<div class="grid grid-cols-1 gap-x-8 lg:grid-cols-4">

		<!-- Filters -->
		<?php get_template_part('template-parts/product/content', 'filter-sidebar', $filters_sorts); ?>

		<!-- Products -->
		<div class="lg:col-span-3 lg:pl-12">
			<div class="grid grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-4 lg:gap-x-5 lg:gap-y-6 product-grid">

				<?php
				$products = '';
				$products_sorted = sort_products_by_price($product_collection['data']);

				foreach ($products_sorted as $product_data) {
					if ($product_data['brand']) {
						$products .= get_product_grid_item($product_data);
					}
				}
				echo $products;
				?>

			</div>
		</div>

	</div>
</section>

<?php //get_template_part('template-parts/preline/content', 'toast'); 
?>