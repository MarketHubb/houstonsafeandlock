<div class="">
   <div class="tw-mt-8 tw-flow-root">
      <div class="tw--mx-4 tw--my-2 tw-overflow-x-auto sm:tw--mx-6 lg:tw--mx-8">
         <div class="tw-inline-block tw-min-w-full tw-py-2 tw-align-middle sm:tw-px-6 lg:tw-px-8">
            <table class="tw-min-w-full">
               <tbody class="tw-bg-white">
                  <?php
                  $breadcrumb_array = get_breadcrumbs_from_queried_object(get_queried_object());

                  $type_val = (isset($breadcrumb_array) && !empty($breadcrumb_array['1']['page'])) ? '<a href="' . $breadcrumb_array['1']['url'] . '">' . $breadcrumb_array['1']['page'] . '</a>' : null;

                  $attributes = [
                     'details' => [
                        'price' => [
                           'field' => 'post_product_gun_price',
                           'val' => '$' . $args['discounted_price'] . ' (' . $args['discount_percentage'] . '% off)',
                           'prefix' => '$',
                           'postfix' => null,
                           'icon' => '/wp-content/uploads/2024/08/noun-price-tag-7101751.svg'
                        ],
                        'brand' => [
                           'field' => 'post_product_manufacturer',
                           'prefix' => null,
                           'postfix' => null,
                           'icon' => '/wp-content/uploads/2024/08/AMSEC-Wings.png'
                        ],
                        'type' => [
                           'field' => 'post_product_gun_type',
                           'val' => $type_val,
                           'prefix' => null,
                           'postfix' => null,
                           'icon' => '/wp-content/uploads/2022/10/type-gun-4.svg'
                        ],
                     ],
                     'rating' => [
                        'fire rating' => [
                           'field' => 'post_product_fire_rating',
                           'prefix' => null,
                           'postfix' => null,
                           'icon' => '/wp-content/uploads/2022/11/hsl-fire.svg'
                        ],
                        'security rating' => [
                           'field' => 'post_product_security_rating',
                           'prefix' => null,
                           'postfix' => null,
                           'icon' => '/wp-content/uploads/2022/11/rating.svg'
                        ],
                     ],
                     'size' => [
                        'weight' => [
                           'field' => 'post_product_gun_weight',
                           'prefix' => null,
                           'postfix' => 'lbs',
                           'icon' => '/wp-content/uploads/2022/11/hsl-weigh.svg',
                        ],
                        'width' => [
                           'field' => 'post_product_gun_exterior_width',
                           'prefix' => null,
                           'postfix' => '"',
                           'icon' => '/wp-content/uploads/2022/11/sl-width.svg'
                        ],
                        'depth' => [
                           'field' => 'post_product_gun_exterior_depth',
                           'prefix' => null,
                           'postfix' => '"',
                           'icon' => '/wp-content/uploads/2022/11/sl-length.svg'
                        ],
                        'height' => [
                           'field' => 'post_product_gun_exterior_height',
                           'prefix' => null,
                           'postfix' => '"',
                           'icon' => '/wp-content/uploads/2022/11/sl-height.svg'
                        ],
                     ]
                  ];

                  $attribute_rows = '';
                  foreach ($attributes as $key => $type) {
                     $attribute_rows .= '<tr class="">';
                     $attribute_rows .= '<th colspan="5" scope="colgroup" class=" tw-bg-gray-50 tw-py-2 tw-pl-6 lg:tw-pl-8 tw-pr-3 tw-text-left tw-text-lg tw-font-semibold tw-text-gray-900">';
                     $attribute_rows .= strtoupper($key);
                     $attribute_rows .= '</th></tr>';

                     $i = 1;
                     foreach ($type as $val => $val_array) {
                        $border_class = $i === 1 ? ' ' : ' tw-border-t tw-border-gray-300 ';
                        $attribute_rows .= '<tr class="' . $border_class . '">';
                        $attribute_rows .= '<td class="tw-inline-flex tw-items-center tw-whitespace-nowrap tw-py-4 tw-pl-4 tw-pr-3 tw-text-base tw-font-medium tw-text-gray-900 sm:tw-pl-3">';

                        if (!empty($val_array['icon'])) {
                           $attribute_rows .= '<img src="' . get_home_url() . $val_array['icon'] . '" class="tw-w-8 tw-max-h-4 tw-object-contain tw-pr-3 tw-opacity-80" />';
                        }

                        $attribute_rows .= ucfirst($val);
                        $attribute_rows .= '</td>';
                        $attribute_rows .= '<td class=" tw-whitespace-nowrap tw-px-3 tw-py-4 tw-text-base tw-text-gray-500">';

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