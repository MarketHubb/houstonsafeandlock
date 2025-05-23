<?php
function get_range_filters($range_data)
{
    $sliders = [];

    foreach ($range_data as $range_name => $range_values) {
        $range_name_formatted = data_attribute_group_name($range_name);
        $range_name_label     = ucfirst($range_name);
        $min_value            = round($range_values['min']);
        $max_value            = round($range_values['max']);
        $mean_value           = $min_value + $max_value / 2;
        $mean_value           = round($mean_value);

        $output_prepend = '';
        $output_append  = '';

        if ($range_name === 'Width' || $range_name === 'Depth' || $range_name === 'Height') {
            $output_append = '"';
        } elseif ($range_name === 'Weight') {
            $output_append = 'lbs';
        } elseif ($range_name === 'Price') {
            $output_prepend = '$';
        }

        // Create the JSON configuration separately
        $slider_config = json_encode([
            'start'      => $max_value,
            'connect'    => 'lower',
            'range'      => [
                'min' => $min_value,
                'max' => $max_value,
            ],
            'tooltips'   => true,
            'formatter'  => 'integer',
            'step'       => 1,
            'cssClasses' => [
                'target'    => 'relative h-2 rounded-full bg-gray-100',
                'base'      => 'w-full h-full relative z-1',
                'origin'    => 'absolute top-0 end-0 w-full h-full origin-[0_0] rounded-full',
                'handle'    => 'absolute before:hidden after:hidden !top-1/2 !end-0 !w-[1.125rem] !h-[1.125rem] bg-white border-4 border-blue-600 rounded-full cursor-pointer translate-x-2/4 -translate-y-[38%]',
                'connects'  => 'relative z-0 w-full h-full rounded-full overflow-hidden',
                'connect'   => 'absolute top-0 end-0 z-1 w-full h-full bg-blue-600 origin-[0_0]',
                'touchArea' => 'absolute -top-1 -bottom-1 -start-1 -end-1',
                'tooltip'   => 'hidden bg-white border border-gray-200 text-sm text-gray-800 py-1 px-2 rounded-lg mb-3 absolute bottom-full start-2/4 -translate-x-2/4',
            ],
        ], JSON_NUMERIC_CHECK); // Added JSON_NUMERIC_CHECK flag

        $slider_html = <<<STRING
        <div data-filter-group="{$range_name_formatted}">
        <label for="min-and-max-range-slider-usage" class="font-semibold mb-2">{$range_name_label}</label>
        <div
            id="hs-{$range_name_formatted}-filter"
            class="relative h-2 rounded-full bg-gray-100 filter-range-slider"
            data-type="{$range_name}"
            data-start-val="{$max_value}"
            data-hs-range-slider='{$slider_config}'
        >
        </div>
        <div class="text-gray-500 mt-1"><span id="hs-{$range_name_formatted}-filter-target" class="font-normal">{$output_prepend}{$max_value}</span><span>{$output_append}</span></div>
        </div>

        STRING;

        $sliders[$range_name] = $slider_html;
    }

    return $sliders;
}

function get_checkbox_filter_labels(string $filter_key)
{
    if ($filter_key === 'terms') {
        $filter_key = "Categories";
    }

    return [
        'text' => ucfirst(str_replace('_', ' ', $filter_key)),
        'name' => strtolower(str_replace('_', '-', $filter_key)),
    ];
}

function get_checkbox_filter_input_attributes(array $labels, string $value)
{
    $attributes = [];

    if ($labels['text'] !== 'Categories') {
        $value = str_replace('_', ' ', $value);
    } else {
        $values = explode(',', $value);
        $value  = $values[0];
    }

    $id = "checkbox-{$labels['name']}-" . sanitize_title($value);

    return  ! empty($value) && ! empty($id)
        ? ['id' => $id, 'value' => $value]
        : null;
}

function add_select_all_input_to_checkbox_filters($label_text, $filter_values)
{

    if ($label_text === 'Categories') {
        if (get_queried_object_id() === 3901) {
            array_unshift($filter_values, 'Featured Safes,1');
        }

        array_unshift($filter_values, 'All Safes,0');

        // array_unshift($filter_values, 'All Safes,0', 'Featured Safes,1');
    }

    if ($label_text === 'Fire Rating') {
        array_unshift($filter_values, 'All Fire Ratings');
    }

    if ($label_text === 'Security Rating') {
        array_unshift($filter_values, 'All Security Ratings');
    }

    return $filter_values;
}

function get_checked_inputs_on_init($input_name, $input_value)
{
    if (get_queried_object_id() === 3901) {
        $target_input = 'Featured Safes';
    } else {
        $target_input = trim(get_queried_object()->name);
    }

    if ($input_name === 'categories' && $input_value === $target_input) {
        return true;
    }

    if ($input_name !== 'categories' && str_contains($input_value, 'All ')) {
        return true;
    }

    return false;
}

function get_checkbox_filters(array $checkbox_data)
{
    $filters = [];

    foreach ($checkbox_data as $filter_key => $filter_values) {
        $labels        = get_checkbox_filter_labels($filter_key);
        $label_text    = $labels['text'];
        $input_name    = $labels['name'];
        $filter_group  = data_attribute_group_name($input_name);
        $filter_values = add_select_all_input_to_checkbox_filters($label_text, $filter_values);

        // Initialize the container div for this attribute group
        $checkbox_group = <<<STRING
        <div>
        <div class="grid grid-cols-1 gap-y-2 filter-group" data-filter-group="{$filter_group}">
            <label class="font-semibold">{$label_text}</label>
        STRING;

        foreach ($filter_values as $value) {
            if ($value !== 'Not rated') {
                $attributes = get_checkbox_filter_input_attributes($labels, $value);
                $checked = get_checked_inputs_on_init($input_name, $attributes['value'])
                    ? 'checked'
                    : '';
                $filter_val = data_attribute_input_value($attributes['value']);

                $checkbox_group .= <<<STRING
                <div class="flex peer">
                    <input
                    type="checkbox"
                    class="peer shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 focus:disabled:ring-blue-500 disabled:active:ring-blue-500 disabled:focus:ring-blue-500 disabled:opacity-100  disabled:pointer-events-none"
                    id="{$attributes['id']}"
                    name="{$input_name}"
                    value="{$attributes['value']}"
                    data-filter-val="{$filter_val}"
                    {$checked}
                    >
                    <label for="{$attributes['id']}" class=" text-gray-500 ms-3 peer-checked:text-gray-900">{$attributes['value']}</label>
                </div>
            STRING;
            }
        }

        // Close the container div
        $checkbox_group .= "\n</div></div>";

        $filters[$filter_key] = $checkbox_group;
    }

    return $filters;
}

function get_tax_series_data($safe_ids)
{
    $series_data = [];

    foreach ($safe_ids as $id) {
        $series = get_field('post_product_gun_series', $id);
        $oem    = get_field('post_product_manufacturer', $id);

        if (empty($series[0]) || empty($oem)) {
            break;
        }

        $series_name = trim($series[0]);




        // if (! is_array($series_data[$oem]) || ! in_array($series_name, $series_data[$oem])) {
        if (!array_key_exists($oem, $series_data) || ! in_array($series_name, $series_data[$oem])) {
            $series_data[$oem][] = $series_name;
        }
    }

    ksort($series_data);
    foreach ($series_data as &$subarray) {
        sort($subarray);
    }
    unset($subarray);

    return $series_data;
}

function get_options_for_tax_series_filter($safe_ids)
{
    $options           = '';
    $series_collection = [];
    $series_data       = get_tax_series_data($safe_ids);

    array_walk($series_data, function ($series_data, $oem) use (&$options) {
        foreach ($series_data as $series) {
            $series_val = data_attribute_input_value($series);
            $series_name = $series . ' Series (' . $oem . ')';
            $options .= '<option data-filter-val="' . $series_val . '" value="' . $series_val . '">' . $series_name . '</option>';
        }
    });

    return $options ?? null;
}

function get_multi_select_filter($safe_ids)
{
    $series_options = get_options_for_tax_series_filter($safe_ids);

    if (! $series_options) {
        return null;
    }

    // "tagsInputClasses": "py-2.5 sm:py-3 px-2 min-w-20 rounded-lg order-1 border-transparent focus:ring-0 sm:text-sm outline-hidden",
    // "wrapperClasses": "relative ps-0.5 pe-9 min-h-11.5 flex items-center flex-wrap text-nowrap w-full border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500",

    $input_classes = classes_search_input();

    $select_el = <<<SELECT
    <div class="w-full" data-filter-group="series">
        <select multiple="" data-hs-select='{
        "placeholder": "Filter by series",
        "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
        "mode": "tags",
        "wrapperClasses": "relative ps-0.5 pe-9 min-h-11.5 flex items-center flex-wrap text-nowrap w-full border border-gray-200 rounded-lg text-start text-sm focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600",
        "tagsItemTemplate": "<div class=\"flex flex-nowrap items-center relative z-10 bg-white border border-gray-200 rounded-full p-1 m-1 \"><div class=\"size-6 me-1\" data-icon></div><div class=\"whitespace-nowrap text-gray-800 \" data-title></div><div class=\"inline-flex shrink-0 justify-center items-center size-5 ms-2 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-gray-400 text-sm cursor-pointer\" data-remove><svg class=\"shrink-0 size-3\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg></div></div>",
        "tagsInputId": "hs-tags-input",
        "tagsInputClasses": "py-2.5 sm:py-3 px-2 min-w-20 rounded-lg order-1 border-transparent !border-none focus:ring-0 sm:text-sm outline-hidden",
        "optionTemplate": "<div class=\"flex items-center\"><div class=\"size-8 me-2\" data-icon></div><div><div class=\"text-sm font-semibold text-gray-800 \" data-title></div><div class=\"text-xs text-gray-500 \" data-description></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
        }'
        class="hidden">
            {$series_options}
        </select>
    </div>
    SELECT;

    return $select_el;
}

function get_search_input_filter($safe_ids)
{
    if (empty($safe_ids)) {
        return;
    }

    $input_classes = classes_search_input();

    $search = <<<STRING
    <div class="w-full inline-flex relative" data-hs-combo-box="">
    <div class="relative w-full">
        <input class="{$input_classes}"
            type="text"
            role="combobox"
            aria-expanded="false"
            value=""
            placeholder="Search by model"
            data-hs-combo-box-input="">
        <!-- Toggle icon -->
        <div class="absolute top-1/2 end-12 -translate-y-1/2" data-hs-combo-box-toggle="">
            <svg class="shrink-0 size-3.5 text-gray-800" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m7 15 5 5 5-5"></path>
                <path d="m7 9 5-5 5 5"></path>
            </svg>
        </div>
        <!-- Clear icon -->
        <div class="absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer" data-hs-combo-box-close>
            <svg class="shrink-0 size-3.5 text-gray-600 hover:text-gray-700" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" y1="4" x2="16" y2="16" />
                <line x1="16" y1="4" x2="4" y2="16" />
            </svg>
        </div>
    </div>
    <div class="absolute z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto" style="display: none;" data-hs-combo-box-output="" id="search-options-list">
    STRING;

    $i = 1;
    foreach ($safe_ids as $id) {
        $i++;
        $title = get_the_title($id);

        $search .= <<<INPUTS
         <div class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800 selected" tabindex="{$i}" data-hs-combo-box-output-item="" style="display: block;">
            <div class="flex justify-between items-center w-full">
                <span data-postid="{$id}" data-hs-combo-box-search-text="{$title}" data-hs-combo-box-value="{$title}">{$title}</span>
                <span class="hidden hs-combo-box-selected:block">
                    <svg class="shrink-0 size-3.5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
            </div>
        </div>
        INPUTS;
    }

    $search .= '</div></div>';

    return $search;
}

function product_filters_sorts($product_collection)
{
    $filter_sort_data = $product_collection['filter_sort_data'];

    $filters = [];

    if (is_array($filter_sort_data['range']) && ! empty($filter_sort_data['range'])) {
        $filters['range'] = get_range_filters($filter_sort_data['range']);
    }

    if (is_array($filter_sort_data['checkbox']) && ! empty($filter_sort_data['checkbox'])) {
        $filters['checkbox'] = get_checkbox_filters($filter_sort_data['checkbox']);
    }

    if (is_array($product_collection['safe_ids']['all']) && ! empty($product_collection['safe_ids']['all'])) {
        $filters['multi']  = get_multi_select_filter($product_collection['safe_ids']['all']);
        $filters['search'] = get_search_input_filter($product_collection['safe_ids']['all']);
    }

    return $filters;
}
