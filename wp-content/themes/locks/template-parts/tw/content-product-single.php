<?php $pricing = get_product_pricing(get_the_id()); ?>


<div class="bg-gray-50">
   <main>
      <!-- Product -->
      <div class="bg-white">
         <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 sm:pb-32 sm:pt-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
             <!-- Product details -->
            <div class="lg:max-w-lg lg:self-end">
               <nav aria-label="Breadcrumb" class="mb-10">
                  <?php echo output_breadcrumbs(get_queried_object()); ?>
               </nav>

               <!-- Title -->

               <?php get_template_part(
                   "template-parts/tw/content",
                   "product-title",
                   $pricing
               ); ?>

               <section aria-labelledby="information-heading" class="mt-4">
                  <h2 id="information-heading" class="sr-only">Product information</h2>


                  <!-- <div class="hidden flex items-center"> -->
                  <div class="grid grid-cols-2 auto-cols-min">
                     <!-- Price -->
                     <?php get_template_part(
                         "template-parts/tw/content",
                         "product-price",
                         $pricing
                     ); ?>
                     <!-- Reviews -->
                     <?php get_template_part(
                         "template-parts/tw/content",
                         "product-reviews"
                     ); ?>

                  </div>

                  <!-- Description -->
                  <?php if (
                      !empty(get_field("post_product_gun_long_description"))
                  ) { ?>
                     <div class="mt-4 space-y-6">
                        <p class="text-base text-gray-500">
                           <?php echo get_field(
                               "post_product_gun_long_description"
                           ); ?>
                        </p>
                     </div>
                  <?php } ?>

                  <!-- In stock -->
                  <div class="mt-6 flex items-center">
                     <svg class="h-5 w-5 flex-shrink-0 text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                     </svg>
                     <p class="ml-2 text-sm text-gray-500">In stock</p>
                  </div>

                  <!-- CTA Button  -->
                  <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
                     <section aria-labelledby="options-heading">

                        <div class="mt-10">
                           <?php echo get_tw_product_btn(
                               $post->ID,
                               "Inquire about the " . get_the_title()
                           ); ?>
                           <button type="submit" class=" hidden flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Add
                              to bag</button>
                        </div>
                        <div class="mt-6 text-center">
                           <a href="#" class="group inline-flex text-base font-medium">
                              <svg class="mr-2 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                              </svg>
                              <span class="text-gray-500 hover:text-gray-700">Lifetime Guarantee</span>
                           </a>
                        </div>
                     </section>
                  </div>

                  <!-- Accordion -->
                  <?php get_template_part(
                      "template-parts/tw/content",
                      "product-accordion",
                      $pricing
                  ); ?>

               </section>
            </div>

            <!-- Product image -->
            <?php $image_id = get_product_featured_image_id(get_the_id()); ?>
            <?php if (isset($image_id)) { ?>
               <div class="h-full mt-10 lg:col-start-2 lg:row-span-2 lg:mt-16 lg:self-center">
                  <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg">
                     <img src="<?php echo wp_get_attachment_image_url(
                         $image_id,
                         "full"
                     ); ?>" alt="Light green canvas bag with black straps, handle, front zipper pouch, and drawstring top." class="h-full w-full object-cover object-center">
                  </div>
               </div>
            <?php } ?>

         </div>
      </div>

      <!-- Callouts -->
      <?php get_template_part(
          "template-parts/tw/content",
          "product-callouts"
      ); ?>

      <!-- Delivery & Installation -->
      <?php get_template_part(
          "template-parts/tw/content",
          "product-delivery"
      ); ?>

      <!-- Delivery (zip codes) -->
      <?php get_template_part(
          "template-parts/safes/content",
          "delivery-cities"
      ); ?>
      <?php
//get_template_part('template-parts/tw/content', 'product-zips');
?>

      <!-- Locations -->
      <?php get_template_part(
          "template-parts/tw/content",
          "product-locations"
      ); ?>

   </main>
</div>
