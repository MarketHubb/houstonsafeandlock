<?php if (!isset($args)) return; ?>

<section id="hero">
	<!-- <div class="bg-white py-24 sm:py-32"> -->
	<div class="bg-white py-10">
		<div class="mx-auto container pl-0">
			<div class="mx-auto sm:max-w-2xl lg:mx-0">

				<?php if (!empty($args['callout'])) { ?>
					<p class="text-[.9rem] sm:text-base font-normal text-gray-500 uppercase tracking-widest">
						<?php echo $args['callout']; ?>
					</p>
				<?php } ?>

				<?php if (!empty($args['heading'])) { ?>
					<h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold tracking-normal text-gray-800">
						<?php echo $args['heading']; ?>
					</h2>
				<?php } ?>

				<?php if (!empty($args['description'])) { ?>
					<p class="mt-5 sm:mt-8 text-pretty !leading-normal text-base font-medium text-gray-500 sm:text-xl/8">
						<?php echo $args['description']; ?>
					</p>
				<?php } ?>
			</div>
		</div>
	</div>
</section>