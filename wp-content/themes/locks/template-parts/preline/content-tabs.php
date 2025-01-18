<?php if (empty($args)) return; ?>

<?php
$tab_btns = '<nav class="relative z-0 flex border rounded-xl overflow-hidden !border-[1px solid #e5e7eb]" aria-label="Tabs" role="tablist" aria-orientation="horizontal">';
$tab_content = '<div class="mt-3">';
$i = 1;

foreach ($args as $tab) {
   $active = $i === 1 ? 'active' : '';
   $hidden = $i === 1 ? '' : 'hidden';
   $selected = $active ?? false;
   $id = strtolower(str_replace(" ", "_", $tab['name']));
   $label = $id . '-label';
   
   // Button markup remains the same
   $tab_btns .= '<button type="button"'
      . ' class="border-b-[2px solid #e5e7eb] hs-tab-active:border-b-blue-600 hs-tab-active:border-b-2 border-solid border-t-0 border-x-0 hs-tab-active:text-gray-900 relative min-w-0 flex-1 bg-white first:border-s-0 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-semibold text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-gray-900 disabled:opacity-50 disabled:pointer-events-none ' . $active . '"'
      . ' id="' . $id . '"'
      . ' aria-selected="' . $selected . '"'
      . ' data-hs-tab="#' . $label . '"'
      . ' aria-controls="' . $label . '"'
      . ' role="tab">'
      . '<span class="flex gap-x-2 items-end justify-center">'
      . '<svg class="shrink-0 size-3 sm:size-5 text-gray-400 sm:text-gray-500 antialiased relative bottom-1 sm:bottom-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'
      . $tab['icon']
      . '</svg>'
      . $tab['name']
      . '</span>'
      . '</button>';

   // Process shortcode here instead of outputting content directly
   $processed_content = (strpos($tab['content'], '[gravityform') !== false) 
      ? do_shortcode($tab['content']) 
      : $tab['content'];

   $tab_content .= '<div id="' . $label . '" role="tabpanel" aria-labelledby="' . $id . '" class="' . $hidden . '">'
      . $processed_content
      . '</div>';

   $i++;
}

$tab_btns .= '</nav>';
$tab_content .= '</div>';

echo $tab_btns . $tab_content;
?>
