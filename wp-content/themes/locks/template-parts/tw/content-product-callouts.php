<div class="bg-gray-50">
   <div class="mx-auto max-w-7xl py-24 sm:px-2 sm:py-32 lg:px-4">
      <div class="mx-auto max-w-2xl px-4 lg:max-w-none">

         <!-- Section Title -->
         <div class="grid grid-cols-1 items-center gap-x-16 gap-y-10 lg:grid-cols-2">
            <div>
               <p class="text-base tracking-widest text-primary font-semibold uppercase mb-3">For over 30 years</p>
               <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Houston's largest safe dealer</h2>
               <p class="mt-4 md:pr-8 text-gray-700">For over 30 years, Houston Safe & Lock has been the most trusted name in Houston for safes and security products.</p>
            </div>
            <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg bg-gray-100">
               <img src="<?php echo get_home_url() . '/wp-content/uploads/2024/08/Callouts.webp'; ?>" alt="" class="object-cover object-center">
            </div>
         </div>

         <!-- Section body -->
         <div class="mt-16 grid grid-cols-1 gap-10 lg:grid-cols-3">

            <?php 
            $features = [
               [
                  'title' => "Largest selection of safes",
                  'description' => "Visit one of our two convenient Houston-area locations to experience one of Texas's largest new and used safes selections",
                  'callouts' =>
                  [
                     'Hundreds of in-stock models',
                     'Top brands including AMSEC',
                     'Two convenient Houston stores'
                  ]
               ],
               [
                  'title' => "Fast delivery & installation",
                  'description' => "We never drop off your new safe on a pallet at the top of your driveway like those big online brands from California",
                  'callouts' =>
                  [
                     'In-house delivery team',
                     'Delivered inside your home or office',
                     'Professional installation + bolt-down'
                  ]
               ],
               [
                  'title' => "Authorized distributor",
                  'description' => "Not all safe sellers are created equal. Houston Safe & Lock is an authorized safe dealer with manufacturer-backed warranties",
                  'callouts' =>
                  [
                     'Full manufacturer warranties',
                     'Safe customizations & add-ons',
                     'Platinum-dealer pricing'
                  ]
               ],
            ];

            $callouts = '';

            foreach ($features as $feature) {
               $callouts .= '<div class="sm:flex lg:block">';
               $callouts .= '<div class="sm:flex-shrink-0">';
               // $callouts .= //icon
               $callouts .= '</div>';
               $callouts .= '<div class="mt-4 sm:ml-6 sm:mt-0 lg:ml-0 lg:mt-6">';
               $callouts .= '<h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900">' . $feature['title'] . '</h3>';
               $callouts .= '<p class="mt-2 text-base text-pretty sm:text-lg text-gray-600">' . $feature['description'] . '</p>';

               if (is_array($feature['callouts']) && !empty($feature['callouts'])) {
                $callouts .= '<ul class="space-y-3 text-sm mt-10">';  

                foreach ($feature['callouts'] as $callout) {
                   $callouts .= '<li class="flex gap-x-2">';
                   $callouts .= '<svg class="shrink-0 size-4 mt-0.5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                   $callouts .= '<span class="text-sm sm:text-base text-gray-800">';
                   $callouts .= $callout;
                   $callouts .= '</span>';
                   $callouts .= '</li>';
                }
                
                $callouts .= '</ul>';  
               }

               $callouts .= '</div></div>';
            }

            echo $callouts;

             ?>
         </div>
      </div>
   </div>
</div>