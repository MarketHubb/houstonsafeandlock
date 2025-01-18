<div class="">
   <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
         <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full">
               <tbody class="bg-white">
                  <?php
                  $breadcrumb_array = get_breadcrumbs_from_queried_object(get_queried_object());

                  $type_val = (isset($breadcrumb_array) && !empty($breadcrumb_array['1']['page'])) ? '<a href="' . $breadcrumb_array['1']['url'] . '">' . $breadcrumb_array['1']['page'] . '</a>' : null;

                  $attribute_rows = '';
                  foreach ($attributes as $key => $type) {
                     $attribute_rows .= '<tr class="">';
                     $attribute_rows .= '<th colspan="5" scope="colgroup" class="hidden bg-gray-50 py-2 pl-6 lg:pl-8 pr-3 text-left text-lg font-semibold text-gray-900">';
                     $attribute_rows .= strtoupper($key);
                     $attribute_rows .= '</th></tr>';

                     $i = 1;
                     foreach ($type as $val => $val_array) {
                        $border_class = $i === 1 ? ' ' : ' ';
                        $attribute_rows .= '<tr class="' . $border_class . '">';
                        $attribute_rows .= '<td class="inline-flex items-center whitespace-nowrap py-0 pl-4 pr-3 text-base font-medium text-gray-900 sm:pl-3">';

                        if (!empty($val_array['icon'])) {
                           $attribute_rows .= '<img src="' . get_home_url() . $val_array['icon'] . '" class="w-8 max-h-4 object-contain pr-3 opacity-80" />';
                        }

                        $attribute_rows .= ucfirst($val);
                        $attribute_rows .= '</td>';
                        $attribute_rows .= '<td class=" whitespace-nowrap px-3 py-1 text-base text-gray-500">';

                        if (!empty($val_array['val'])) {
                           $attribute_rows .= $val_array['val'];
                        } else {
                           $attribute_rows .= $val_array['prefix'] . get_field($val_array['field'], get_the_id()) . $val_array['postfix'];
                        }

                        $attribute_rows .= '</td>';
                        $attribute_rows .= '</tr>';

                        $i++;
                     }
                  }
                  echo $attribute_rows;
                  ?>

               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>