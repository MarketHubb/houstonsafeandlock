<div class="px-3 py-4 sm:p-7">

    <?php //get_template_part('template-parts/preline/content', 'tabs', get_product_modal_tabs_data());  
    ?>

    <?php
    $args = get_product_modal_tabs_data();
    $tab_btns = '<nav class="relative z-0 flex rounded-t-lg overflow-hidden shadow-[0 -3px 10px -2px rgb(0 0 0 / 0.1), 0 -2px 0px -2px rgb(0 0 0 / 0.1)]" aria-label="Tabs" role="tablist" aria-orientation="horizontal">';
    $tab_content = '<div class=" rounded-b-lg bg-white shadow-md p-8">';
    $i = 1;

    foreach ($args as $tab) {
        $active = $i === 1 ? 'active' : '';
        $hidden = $i === 1 ? '' : 'hidden';
        $selected = $active ?? false;
        $id = strtolower(str_replace(" ", "_", $tab['name']));
        $label = $id . '-label';
        $tab_btns .= <<<BUTTONS
                               <button 
                                  type="button" 
                                  class=" border-b border-b-gray-200 hs-tab-active:bg-white hs-tab-active:border-b-brand-300 hs-tab-active:border-b border-solid border-t-0 border-x-0 hs-tab-active:text-brand-300 relative min-w-0 flex-1 bg-white first:border-s-0 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-semibold text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-gray-900 disabled:opacity-50 disabled:pointer-events-none {$active}" 
                                  id="{$id}" 
                                  aria-selected="{$selected}" 
                                  data-hs-tab="#{$label}" 
                                  aria-controls="{$label}" 
                                  role="tab">
                                  <span class="flex gap-x-2 items-center justify-center">
                                     {$tab['icon']}
                                     {$tab['name']}
                                  </span>
                                  </span>
                               </button>
                               BUTTONS;

        $tab_content .= <<<CONTENT
                                   <div id="{$label}" role="tabpanel" aria-labelledby="{$id}" class="{$hidden}">
                                         {$tab['content']}
                                   </div>
                                   CONTENT;

        $i++;
    }

    $tab_btns .= '</nav>';
    $tab_content .= '</div>';

    echo $tab_btns . $tab_content;
    ?>



    <!-- Nav -->
    <!-- <nav class="relative z-0 flex border rounded-xl gap-y-4 gap-x-4 divide-x divide-gray-200 overflow-hidden"> -->
    <nav class="relative z-0 flex rounded-xl gap-y-4 gap-x-[1px] sm:gap-x-4 overflow-hidden mt-6">
        <?php

        $tabs = '';
        $output = '';

        // foreach ($tab_data as $tab) {
        //     $output .= <<<STRING
        //         <a class=" !group !relative !min-w-0 !flex-1 !bg-white !no-underline py-5 sm:py-8 px-3 sm:px-4 !border !border-2 !border-gray-100 !shadow-sm !rounded-xl !border-b-blue-600 !text-gray-800 !overflow-hidden !focus:z-10 !focus:outline-none !focus:text-blue-600" aria-current="page">
        //         <span class="flex flex-col sm:flex-row gap-x-5">
        //         <svg class="shrink-0 mt-1 size-4 sm:size-5 text-gray-400 sm:text-gray-500 antialiased relative bottom-1 sm:bottom-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        //         {$tab['icon']}
        //         </svg>
        //         <span class="grow text-left">
        //           <span class="block mb-2 sm:mb-0 text-base sm:text-lg font-semibold text-gray-800 dark:text-neutral-200 uppercase">{$tab['name']}</span>
        //           <span class="block text-sm sm:text-base leading-tight text-gray-500 dark:text-neutral-500">{$tab['description']}</span>
        //         </span>
        //       </span>
        //       </a>
        //     STRING;
        // }

        // echo $output;

        ?>
    </nav>
    <div class="p-4 overflow-y-auto">
        <p class="mt-1 text-gray-800">
            This is a wider card with supporting text below as a natural lead-in to additional content.
        </p>
    </div>
</div>