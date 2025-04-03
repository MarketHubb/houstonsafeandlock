<div class="px-3 pb-4 sm:px-8 md:px-12 lg:px-20 sm:pb-7 bg-white">

    <div class="">
        <?php
        if (is_array($args) && !empty($args['form_id'])) {
            $form_id = $args['form_id'];
            echo gravity_form($form_id, $display_title = false, $display_description = false, $display_inactive = false, $field_values = null, $ajax = true, $tabindex);
        }
        ?>

        <?php
        // $args = get_product_modal_tabs_data();
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

        // echo $tab_btns . $tab_content;
        ?>
    </div>
</div>