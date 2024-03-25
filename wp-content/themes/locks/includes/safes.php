<?php
function all_safes()
{
	return get_posts(array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	));
}

function safe_filters()
{
	$filters_array = [
		[
			'name' => 'Brand',
			'field' => 'filter_brand',
			'type' => 'checkbox'
		],
		[
			'name' => 'Type',
			'field' => 'filter_type',
			'type' => 'checkbox',
		],
		[
			'name' => 'Fire Rating',
			'field' => 'filter_fire_ratings',
			'type' => 'checkbox'
		],
		[
			'name' => 'Security Rating',
			'field' => 'filter_security_ratings',
			'type' => 'checkbox'
		],
	];

	return $filters_array;
}

function output_safe_sorts()
{
	$filters = safe_attribute_array();
	$sorts  = '<ul id="sort-filter-nav" class="nav nav-pills d-inline-flex mb-2 pe-0 pe-md-3" data-sort-order="desc">';
	$sorts .= '<li class="nav-item dropdown bg-transparent">';
	$sorts .= '<a class="nav-link dropdown-toggle border-0 filter-sort-type" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">';
	$sorts .= 'Sort by:</a>';
	$sorts .= '<div class="dropdown-menu">';

	$asc_icon = get_template_directory_uri() . '/images/asc.svg';
	$desc_icon = get_template_directory_uri() . '/images/desc.svg';


	foreach ($filters as $filter) {

		if ($filter['type'] === 'sort') {

			$sort_label = $filter['label'];
			$sorts .= '<a class="dropdown-item" data-mixitup-control data-sort="';
			$sorts .= sanitize_attribute_value($filter['label']) . ':desc">';
			$sorts .= $filter['label'];
			$sorts .= '</a>';
		}
	}

	$sorts .= '</div></li></ul>';

	$order_array = [
		['DESC', 'fa-arrow-down-wide-short'],
		['ASC', 'fa-arrow-down-short-wide']
	];

	foreach ($order_array as $order) {
		$sort_color_class = ($order[0] === 'DESC') ? 'active-sort-order' : '';
		$sorts .= '<span id="grid-sort-' . $order[0] . '" class="grid-sort-order px-2 ms-1 ' . $sort_color_class . '" ';
		$sorts .= 'data-type="' . strtolower($order[0]) . '" >';
		$sorts .= '<i class="fa-regular ' . $order[1] . '"></i>';
		$sorts .= '<span class="d-none d-md-inline text-sm ps-2 text-secondary">' . $order[0] . '</span>';
		$sorts .= '</span>';
	}

	return $sorts;
}

function output_safe_filters()
{
	$filters = safe_attribute_array();
	$output = '';

	foreach ($filters as $filter) {

		if ($filter['type'] === 'filter' && isset($filter['global_field'])) {
			$filter_options = get_field($filter['global_field'], 'option');
			$filter_options = explode("\n", $filter_options);
			$filter_options = array_map('trim', $filter_options);

			if (is_array($filter_options)) {
				$filter_icon = get_field($filter['global_field'] . '_icon', 'option');
				$output .= '<div class="my-3 pt-3 pb-4 border-bottom filter-group ' . sanitize_attribute_value($filter['label']) . '"';

				if ($filter_icon) {
					$output .= 'data-icon="' . urlencode(trim($filter_icon['url'])) . '" ';
				}

				$output .= 'data-filter-type="' . sanitize_attribute_value($filter['label']) . '" ';
				$output .= '>';
				$output .= '<p class="fw-600">' . $filter['label'] . '</p>';
				$output .= '<div class="d-grid grid-cols-2 gap-y-2 d-md-block">';

				foreach ($filter_options as $filter_option) {
					$input_id = sanitize_attribute_value($filter['label']) . '--' . sanitize_attribute_value($filter_option);
					$checkbox_id = strtolower(str_replace(' ', '_', $filter_option));

					$output .= '<div class="form-check">';
					$output .= '<input class="form-check-input" type="checkbox" value="' . $input_id . '" id="' . $input_id . '" ';
					$output .= 'data-filter-type="' . strtolower(str_replace(" ", "_", $filter['label'])) . '"">';
					$output .= '<label class="form-check-label" for="' . $input_id . '">';
					$output .= $filter_option;
					$output .= '</label>';
					$output .= '</div>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}
		}
	}

	return $output;
}
