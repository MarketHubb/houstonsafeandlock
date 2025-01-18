<?php
if (!isset($args)) return;
$filters_sorts = $args;
?>

<div id="filter-container">
	<form class="mt-4" id="filters">
		<!-- Sliders -->
		<div class="grid grid-cols-1 gap-y-4" id="filter-sliders">
			<?php
			if (isset($filters_sorts['sliders']) && is_array($filters_sorts['sliders'])) {
				foreach ($filters_sorts['sliders'] as $slider_name => $slider_html) {
					$slider_html = str_replace(
						'data-hs-range-slider=',
						'class="--prevent-auto-init" data-hs-range-slider=',
						$slider_html
					);
					echo $slider_html;
				}
			}
			?>
		</div>

		<!-- Checkboxes -->
		<div class="grid grid-cols-1 gap-y-4 mt-4" id="filter-checkbox">
			<?php
			if (isset($filters_sorts['filters']) && is_array($filters_sorts['filters'])) {
				foreach (array_reverse($filters_sorts['filters'], true) as $name => $html) {
					echo $html;
				}
			}
			?>

		</div>
	</form>
</div>