<?php if (empty($args)) return; ?>

<?php get_template_part('template-parts/preline/content', 'modal-fullscreen'); ?>

<div class="bg-white pt-12 md:pt-0">
	<div>
		<main class="mx-auto container px-6 lg:px-8">
			<div class="flex flex-col items-baseline justify-between border-b border-gray-200 pb-6 pt-24">
				<div class="md:max-w-[50%]">
					<h1 class="text-4xl font-bold tracking-tight text-gray-900">
						<?php echo $args['heading']; ?>
					</h1>
					<p class="inline text-sm md:text-base">
						<?php echo $args['description']; ?>
					</p>
				</div>
				<div class="w-full grid justify-end" id="sorts">
					<div class="items-center w-full flex">
						<?php echo tw_sort_dropdown($args['products']['attributes']); ?>
					</div>
				</div>
			</div>

			<section aria-labelledby="products-heading" class="pb-24 pt-6" id="product-list">
				<h2 id="products-heading" class="sr-only">Products</h2>

				<div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
					<!-- Filters -->
					<?php echo output_filters_safes($args['products']['attributes']); ?>
					<!-- Product grid -->
					<div class="lg:col-span-3 lg:pl-12">
						<div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 sm:gap-0 gap-y-8 lg:gap-y-16 product-grid">
							<?php echo $args['products']['output']; ?>
						</div>
					</div>
				</div>
			</section>
		</main>
	</div>
</div>

<?php get_template_part('template-parts/preline/content', 'toast'); ?>