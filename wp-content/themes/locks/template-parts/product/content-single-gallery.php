<?php if (!isset($args)) return; ?>

<?php 
$attachment_ids = $args;

   if (! empty($attachment_ids)) {
      foreach ($attachment_ids as $attachment_id) {
         $image_url = wp_get_attachment_image_url($attachment_id, "full");
      }
   }
?>
<div class="flex flex-col-reverse">

	<!-- Image selector -->
	<?php if (! empty($attachment_ids)): ?>

		<div class="mx-auto mt-6 hidden w-full max-w-2xl sm:block lg:max-w-none">
			<div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">

				<?php foreach ($attachment_ids as $attachment_id): ?>

					<button id="tabs-1-tab-1" class="relative flex h-24 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium uppercase text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4" aria-controls="tabs-1-panel-1" role="tab" type="button">
						<?php if (! empty($attachment_ids[0])): ?>
							<span class="absolute inset-0 overflow-hidden rounded-md">
								<img src="<?php echo wp_get_attachment_image_url($attachment_id, 'full'); ?>" alt="" class="h-full w-full object-cover object-center">
							</span>
						<?php endif ?>
						<!-- Selected: "ring-indigo-500", Not Selected: "ring-transparent" -->
						<span class="pointer-events-none absolute inset-0 rounded-md ring-2 ring-transparent ring-offset-2" aria-hidden="true"></span>
					</button>

				<?php endforeach ?>

				<!-- More images... -->
			</div>
		</div>

	<?php endif ?>


	<div class="aspect-h-1 aspect-w-1 w-full">
		<!-- Tab panel, show/hide based on tab state. -->
		<?php if (! empty($attachment_ids[0])): ?>
			<div id="tabs-1-panel-1" aria-labelledby="tabs-1-tab-1" role="tabpanel" tabindex="0">
				<img src="<?php echo wp_get_attachment_image_url($attachment_ids[0], 'full'); ?>" alt="<?php echo get_the_title(); ?>" class="max-h-[700px] w-auto object-cover object-center sm:rounded-lg">
			</div>
		<?php endif ?>

		<!-- More images... -->
	</div>
</div>