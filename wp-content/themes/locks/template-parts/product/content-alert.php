<div id="dismiss-alert" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-teal-50 border border-teal-200 text-sm text-teal-800 rounded-b-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-dismiss-button-label">
	<div class="flex mx-auto container px-3 lg:px-8">
		<div class="shrink-0">
			🎉
		</div>
		<div class="ms-4">
			<h3 id="hs-with-description-label" class="text-sm sm:text-base font-bold antialiased">
				<?php echo get_sale_title(); ?>
			</h3>
			<div class="mt-0 text-sm sm:text-base text-yellow-700">
				<?php echo get_sale_alert_description(); ?>	
			</div>
		</div>
		<div class="ps-3 ms-auto inline-flex items-center">
			<div class="-mx-1.5 -my-1.5">
				<button type="button" class="inline-flex bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-none focus:bg-teal-100" data-hs-remove-element="#dismiss-alert">
					<span class="sr-only">Dismiss</span>
					<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M18 6 6 18"></path>
						<path d="m6 6 12 12"></path>
					</svg>
				</button>
			</div>
		</div>
	</div>
	<!-- 	<div class="flex">
		<div class="shrink-0">
			<svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
				<path d="m9 12 2 2 4-4"></path>
			</svg>
		</div>
		<div class="ms-2">
			<h3 id="hs-dismiss-button-label" class="text-sm font-medium">
				File has been successfully uploaded.
			</h3>
		</div>
		<div class="ps-3 ms-auto">
			<div class="-mx-1.5 -my-1.5">
				<button type="button" class="inline-flex bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-none focus:bg-teal-100" data-hs-remove-element="#dismiss-alert">
					<span class="sr-only">Dismiss</span>
					<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M18 6 6 18"></path>
						<path d="m6 6 12 12"></path>
					</svg>
				</button>
			</div>
		</div>
	</div> -->
</div>