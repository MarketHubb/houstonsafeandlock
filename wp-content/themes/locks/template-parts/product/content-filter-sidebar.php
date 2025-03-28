<?php
if (!isset($args)) return;
$filters_sorts = $args;
?>

<div id="filter-container" class="flex flex-col gap-y-10 justify-start items-start">

	<?php
	if ($args['multi']) {
		echo $args['multi'];
	}
	?>

	<form class="w-full" id="filters">
		<!-- Sliders -->
		<div class="grid grid-cols-1 gap-y-4" id="filter-sliders">
			<?php
			if (isset($filters_sorts['range']) && is_array($filters_sorts['range'])) {
				foreach ($filters_sorts['range'] as $range_input_name => $range_html) {
					// $range_html = str_replace(
					// 	'data-hs-range-slider=',
					// 	'class="--prevent-auto-init" data-hs-range-slider=',
					// 	$range_html
					// );
					echo $range_html;
				}
			}

			// if (isset($filters_sorts['range']['sliders']) && is_array($filters_sorts['range']['sliders'])) {
			// 	foreach ($filters_sorts['range']['sliders'] as $slider_name => $slider_html) {
			// 		$slider_html = str_replace(
			// 			'data-hs-range-slider=',
			// 			'class="--prevent-auto-init" data-hs-range-slider=',
			// 			$slider_html
			// 		);
			// 		echo $slider_html;
			// 	}
			// }
			?>
		</div>

		<!-- Checkboxes -->
		<div class="grid grid-cols-1 gap-y-4 mt-4" id="filter-checkbox">
			<?php
			if (isset($filters_sorts['checkbox']) && is_array($filters_sorts['checkbox'])) {
				foreach (array_reverse($filters_sorts['checkbox'], true) as $name => $html) {
					echo $html;
				}
			}
			?>

		</div>
	</form>
</div>