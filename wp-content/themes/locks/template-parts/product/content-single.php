<?php
// New product-single template
$product_data = get_product_attributes(get_the_ID(), false);

if ($product_data) {
	set_query_var('product_data', $product_data);
}

$terms = get_the_terms(get_the_ID(), 'product_cat');
$attr = get_product_attributes(get_the_ID());
$product = wc_get_product(get_the_ID());

if (! $product) {
	return;
}
?>

<div class="bg-white">

	<!-- Container -->
	<div class="mx-auto container px-4 py-8 md:py-10 sm:px-6 sm:pt-10 sm:pb-24 lg:px-8">

		<!-- Breadcrumbs -->
		<nav aria-label="Breadcrumb" class="md:gap-x-8 lg:gap-x-16 pb-8 sm:pb-6">
			<?php echo output_breadcrumbs(get_queried_object()); ?>
		</nav>

		<!-- Content -->
		<div class="lg:grid lg:grid-cols-2 lg:items-stretch md:gap-x-8 lg:gap-x-16">

			<!-- Image gallery -->
			<?php
			$gallery_ids = !empty($product->get_gallery_image_ids())
				? $product->get_gallery_image_ids()
				: [get_post_thumbnail_id(get_queried_object_id())];

			get_template_part(
				'template-parts/product/content',
				'single-carousel-vertical',
				$gallery_ids
			);
			?>

			<!-- Product info -->
			<div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">

				<div class="flex flex-col gap-y-4 sm:gap-y-6 mb-4 sm:mb-6">
					<div id="product-header">
						<!-- Title & description -->
						<?php
						get_template_part(
							"template-parts/product/content",
							"single-header",
							$product_data
						);
						?>
					</div>
					<div id="product-pricing">
						<!-- Price -->
						<?php
						// get_template_part(
						// 	"template-parts/product/content",
						// 	"single-price",
						// 	$product_data
						// );
						?>
					</div>
				</div>

				<div class="flex flex-col gap-y-4 sm:gap-y-6 mb-4 sm:mb-6">
					<div class="order-last sm:order-first" id="product-callouts">
						<!-- Callouts -->
						<?php
						get_template_part(
							"template-parts/product/content",
							"callouts",
							get_formatted_product_attribute_callouts($product_data['callouts'])
						);
						?>
					</div>
					<div id="product-btns">
						<!-- Btns -->
						<?php
						get_template_part("template-parts/product/content", "cta-button", $product_data);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Callouts -->
	<?php
	get_template_part(
		"template-parts/tw/content",
		"product-callouts"
	);
	?>

	<!-- Delivery & Installation -->
	<?php
	get_template_part(
		"template-parts/tw/content",
		"product-delivery"
	);
	?>

	<!-- Delivery (zip codes) -->
	<?php
	get_template_part(
		"template-parts/product/content",
		"cities"
	);
	?>

	<!-- Related -->
	<?php
	get_template_part(
		"template-parts/product/content",
		"related-products"
	);
	?>

	<!-- Locations -->
	<?php
	get_template_part(
		"template-parts/tw/content",
		"product-locations"
	);
	?>

</div>