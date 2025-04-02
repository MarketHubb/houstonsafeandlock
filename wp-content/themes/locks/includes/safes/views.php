<?php
// function output_products(array $safe_ids, bool $hidden = false, bool $featured = false)
// {
//     if (! is_array($safe_ids) || empty($safe_ids)) {
//         return null;
//     }

//     $products = '';

//     foreach ($safe_ids as $safe_id) {
//         $data_attributes    = get_formatted_data_attributes($safe_id, $featured);
//         $product_attributes = get_product_attributes($safe_id);
//         $hidden             =  ! $hidden
//             ? ''
//             : ' hidden';

//         if ($product_attributes['brand']) {

//             // Open + data attributes
//             $products .= '<a ' . $data_attributes . ' href="' . get_permalink($safe_id) . '" class="relative group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white rounded-lg ring-1 shadow-sm hover:shadow-none ring-gray-200 hover:ring-gray-300 border-gray-200 group/card ' . $hidden . '">';
//             $products .= '<div class="flex justify-center h-48 w-full overflow-hidden rounded-xl group-hover:opacity-75 lg:h-56 xl:h-64 px-4 pt-4 mx-auto">';
//             // end Open + data attributes

//             if ($product_attributes['image_url']) {
//                 $products .= '<img class="!h-[90%] sm:!h-[95%] !w-auto max-w-full inline-block object-cover transition-transform duration-300 ease-in-out group-hover:scale-105" ';
//                 $products .= ' src="' . esc_url($product_attributes['image_url']) . '" ';
//                 $products .= 'loading="lazy"';

//                 if ($product_attributes['image_srcset']) {
//                     $products .= 'srcset=" ' . $product_attributes['image_srcset'] . '" ';
//                 }

//                 if ($product_attributes['image_sizes']) {
//                     $products .= 'sizes="' . $product_attributes['image_sizes'] . '" />';
//                 }
//             }
//             $products .= '</div>';

//             $products .= '<div class="bg-gray-50 sm:!bg-transparent opacity-100 sm:opacity-95 px-2 pt-5 pb-2 sm:px-3 lg:px-4 xl:px-6 h-full sm:h-auto sm:pb-6">';

//             // Price / Discount
//             // if (! empty($product_attributes['discount_price'])) {
//             //     $price = safes_output_discount_tag($product_attributes['post_id'], false);
//             // } else {            //     $price = 'Call for pricing';
//             // }
//             // end Price / Discount

//             // $product_card .= '<div class="flex justify-center gap-x-2 items-center mb-3">' . $price . '</div>';

//             // Title & category
//             $products .= '<div class="p-2 flex flex-col justify-center">';

//             if (get_product_attribute_series($safe_id)) {
//                 $products .= get_product_series($product_attributes);
//             }

//             $products .= '<h3 class="text-base md:text-base lg:text-lg xl:text-[1.35rem] font-bold antialiased tracking-tight sm:tracking-normal !leading-snug text-gray-900 text-center">';
//             $products .= get_the_title($product_attributes['post_id']) . '</h3>';

//             if (get_product_parent_tax_name($safe_id)) {
//                 $products .= get_product_parent_tax_name($safe_id);
//             }

//             $products .= '</div>';
//             // end Title & category

//             $products .= output_featured_attributes($product_attributes['post_id']);

//             // Description
//             $description = get_product_attribute_description_long($safe_id);
//             if ($description && ! empty($description)) {
//                 $products .= '<p class="mt-1 mb-6 text-gray-800 text-sm sm:text-base line-clamp-3 sm:line-clamp-2">';
//                 $products .= $description . '</p>';
//             }
//             // End Description

//             // Ratings badges
//             $products .= product_rating_badges($product_attributes);
//             // End Rating badges

//             if (is_sale_active()) {
//                 $products .= get_product_sale_callout($product_attributes['post_id'], 'grid');
//             }

//             $products .= '</div></a>';
//         }
//     }

//     return $products;
// }
