<?php
function get_parent_link_with_dropdown($args = [])
{
    if (empty($args)) return;

    foreach ($args as $parent => $children) {
    }

    $output = '<div class="hs-dropdown-menu transition-[opacity,margin] ease-in-out duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 z-10 bg-white sm:shadow-md rounded-lg p-1 space-y-1 dark:bg-neutral-800 sm:dark:border dark:border-neutral-700 dark:divide-neutral-700 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden"';

    foreach ($args as $link) {
    }
}

function get_header_nav_open()
{
    $output  = '<header class="relative flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-4 dark:bg-neutral-800 shadow-lg">';
    $output .= '<nav class="container px-4 sm:px-6 lg:px-8 w-full mx-auto px-4 sm:flex  sm:justify-between sm:items-center">';
    $output .= '<div class="flex items-center justify-between">';
    $output .= '<a href="' . esc_url(home_url('/')) . '">';
    $output .= '<img class="!max-w-24 !sm:max-w-32 !h-auto" src="' . get_home_url() . '/wp-content/uploads/2022/10/HSL-Logo-Brand.svg' . '" alt="Houston Safe And Lock Logo" />';
    $output .= '</a>';
    $output .= '<div class="sm:hidden">';
    $output .= '<button type="button" class="hs-collapse-toggle relative size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" id="hs-navbar-example-collapse" aria-expanded="false" aria-controls="hs-navbar-example" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-example">';
    $output .= '<svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6" /><line x1="3" x2="21" y1="12" y2="12" /><line x1="3" x2="21" y1="18" y2="18" /></svg>';
    $output .= '<svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18" /><path d="m6 6 12 12" /></svg>';
    $output .= '<span class="sr-only">Toggle navigation</span>';
    $output .= '</button></div></div>';
    $output .= '<div id="hs-navbar-example" class="hidden hs-collapse overflow-hidden transition-all duration-300 basis-full grow sm:block" aria-labelledby="hs-navbar-example-collapse">';
    $output .= '<div class="flex flex-col divide-y divide-x-0 divide-solid divide-gray-200 sm:flex-row sm:items-center sm:justify-end sm:ps-5 mt-8 mb-4 sm:mt-0 sm:mb-0 sm:divide-y-0 gap-y-6 sm:gap-5">';

    return $output;
}

function get_header_nav_close()
{
    return '</div></div></nav></header>';
}

function get_sublinks_parent_container_open()
{
    return '<div class="pt-3 sm:pt-0 hs-dropdown sm:[--offset:0] [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover] [--auto-close:inside]">';
}

function get_navbar_sublinks_container_close()
{
    return '</div>';
}

function get_sublinks_parent_button($title)
{
    $output  = '<button id="hs-navbar-example-dropdown" type="button" class="' . navbar_parent_link_classes() . '" ';
    $output .= 'aria-haspopup="menu" aria-expanded="false" aria-label="Mega Menu">';
    $output .= $title;
    $output .= '<svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 duration-300 ms-1 shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6" /></svg>';
    $output .= '</button>';

    return $output;
}

function get_sublinks_children_container_open()
{
    $output  = '<div class="hs-dropdown-menu transition-[opacity,margin] ease-in-out duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-fit z-10 bg-white sm:shadow-lg rounded-lg p-2 space-y-1 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden" ';
    $output .= 'role="menu" aria-orientation="vertical" aria-labelledby="hs-navbar-example-dropdown">';

    return $output;
}

function get_sublink_containers_close()
{
    return '</div></div>';
}


function format_menu_items($menu_items)
{
    if ($menu_items) {
        $menu_items_formatted = [];

        foreach ($menu_items as $item) {
            // Parent
            if ($item->menu_item_parent == 0 && empty($menu_items_formatted[$item->ID])) {
                $menu_items_formatted[$item->ID] = [
                    'title' => $item->title,
                    'url' => $item->url,
                    'children' => []
                ];
            }

            if ($item->menu_item_parent != 0 && empty($menu_items_formatted[$item->menu_item_parent][$item->ID])) {
                $menu_items_formatted[$item->menu_item_parent]['children'][] = [
                    'title' => $item->title,
                    'url' => $item->url,
                ];
            }
        }
    }

    return $menu_items_formatted;
}

function navbar_base_link_classes()
{
    return 'text-lg sm:text-[15px] font-semibold text-brand-600 visited:text-gray-700 hover:text-blue-500 focus:outline-none';
}

function navbar_parent_link_classes()
{
    return ' hs-dropdown-toggle p-0 flex items-center w-full text-lg sm:text-[15px] font-semibold text-brand-600 hover:text-gray-400 focus:outline-none focus:text-gray-400 font-medium ';
}

function navbar_children_link_classes()
{
    return ' flex items-center gap-x-3.5 py-2 px-3 rounded-lg hover:bg-gray-100 hover:text-brand-600 ' . navbar_base_link_classes();
}

function construct_navbar($items = [])
{
    $parent_count = 0;
    $child_count = 0;

    $output = get_header_nav_open();

    foreach ($items as $link => $attributes) {

        if (!empty($attributes['children'])) {
            $output .= get_sublinks_parent_container_open();
            $output .= get_sublinks_parent_button($attributes['title']);
            $output .= get_sublinks_children_container_open();

            foreach ($attributes['children'] as $children) {
                $output .= '<a class="' . navbar_children_link_classes() . '" ';
                $output .= 'href="' . $children['url'] . '">';
                $output .= $children['title'];

                if ($children['title'] === 'Memorial' || str_contains($children['url'], '/memorial')) {
                    $output .= '<span class="relative inline-flex items-center py-1 px-3 rounded-full text-xs tracking-tight font-semibold antialiased border border-[#F6D4DF] text-[#7A193A] bg-[#fefbfc] shadow-sm">
                    Formally King Safe & Lock
                    </span>';
                }


                $output .= '</a>';
            }

            $output .= get_sublink_containers_close();
        }

        if (empty($attributes['children'])) {
            $output .= '<a class="' . navbar_base_link_classes() . '" href="' . $attributes['url'] . '" aria-current="page">';
            $output .= $attributes['title'] . '</a>';
        }
    }

    $output .= get_header_nav_close();

    return $output;
}

function get_header_navbar($menu_items)
{
    $menu_items_formatted = format_menu_items($menu_items);

    if (!empty($menu_items_formatted)) {
        return construct_navbar($menu_items_formatted);
    }
}
