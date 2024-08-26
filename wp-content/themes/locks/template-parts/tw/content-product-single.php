<?php $pricing = get_product_pricing(get_the_id()); ?>
<div class="tw-bg-gray-50">
   <main>
      <!-- Product -->
      <div class="tw-bg-white">
         <div class="tw-mx-auto tw-max-w-2xl tw-px-4 tw-pb-24 tw-pt-16 sm:tw-px-6 sm:tw-pb-32 sm:tw-pt-24 lg:tw-grid lg:tw-max-w-7xl lg:tw-grid-cols-2 lg:tw-gap-x-8 lg:tw-px-8">
            <!-- Product details -->
            <div class="lg:tw-max-w-lg lg:tw-self-end">
               <nav aria-label="Breadcrumb" class="mb-10">
                  <?php echo output_breadcrumbs(get_queried_object()); ?>
               </nav>

               <!-- Title -->
               <?php get_template_part('template-parts/tw/content', 'product-title', $pricing); ?>

               <section aria-labelledby="information-heading" class="tw-mt-4">
                  <h2 id="information-heading" class="tw-sr-only">Product information</h2>


                  <!-- <div class="tw-hidden tw-flex tw-items-center"> -->
                  <div class="tw-grid tw-grid-cols-2 tw-auto-cols-min">
                     <!-- Price -->
                     <?php get_template_part('template-parts/tw/content', 'product-price', $pricing); ?>
                     <!-- Reviews -->
                     <?php get_template_part('template-parts/tw/content', 'product-reviews'); ?>

                  </div>

                  <!-- Description -->
                  <?php if (!empty(get_field('post_product_gun_long_description'))) { ?>
                     <div class="tw-mt-4 tw-space-y-6">
                        <p class="tw-text-base tw-text-gray-500">
                           <?php echo get_field('post_product_gun_long_description'); ?>
                        </p>
                     </div>
                  <?php } ?>

                  <!-- In stock -->
                  <div class="tw-mt-6 tw-flex tw-items-center">
                     <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                     </svg>
                     <p class="tw-ml-2 tw-text-sm tw-text-gray-500">In stock</p>
                  </div>

                  <!-- CTA Button  -->
                  <div class="tw-mt-10 lg:tw-col-start-1 lg:tw-row-start-2 lg:tw-max-w-lg lg:tw-self-start">
                     <section aria-labelledby="options-heading">

                        <div class="tw-mt-10">
                           <?php echo get_tw_product_btn($post->ID, 'Inquire about the ' . get_the_title()); ?>
                           <button type="submit" class=" tw-hidden tw-flex tw-w-full tw-items-center tw-justify-center tw-rounded-md tw-border tw-border-transparent tw-bg-indigo-600 tw-px-8 tw-py-3 tw-text-base tw-font-medium tw-text-white hover:tw-bg-indigo-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 focus:tw-ring-offset-gray-50">Add
                              to bag</button>
                        </div>
                        <div class="tw-mt-6 tw-text-center">
                           <div class='tw-has-tooltip'>
                              <span class='tw-tooltip tw-rounded tw-shadow-lg tw-p-1 tw-bg-gray-100 tw-text-red-500 tw--mt-8'>Some Nice Tooltip Text</span>
                              Custom Position (above)
                           </div>

                           <a href="#" class="tw-group tw-inline-flex tw-text-base tw-font-medium">
                              <svg class="tw-mr-2 tw-h-6 tw-w-6 tw-flex-shrink-0 tw-text-gray-400 group-hover:tw-text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                              </svg>
                              <span class="tw-text-gray-500 hover:tw-text-gray-700">Lifetime Guarantee</span>
                           </a>
                        </div>
                     </section>
                  </div>

                  <!-- Accordion -->
                  <?php get_template_part('template-parts/tw/content', 'product-accordion', $pricing); ?>

               </section>
            </div>

            <!-- Product image -->
            <?php $image_id = get_product_featured_image_id(get_the_id()); ?>
            <?php if (isset($image_id)) { ?>
               <div class="tw-h-full tw-mt-10 lg:tw-col-start-2 lg:tw-row-span-2 lg:tw-mt-16 lg:tw-self-center">
                  <div class="tw-aspect-h-1 tw-aspect-w-1 tw-overflow-hidden tw-rounded-lg">
                     <img src="<?php echo wp_get_attachment_image_url($image_id, 'full'); ?>" alt="Light green canvas bag with black straps, handle, front zipper pouch, and drawstring top." class="tw-h-full tw-w-full tw-object-cover tw-object-center">
                  </div>
               </div>
            <?php } ?>

         </div>
      </div>

      <!-- Callouts -->
      <?php get_template_part('template-parts/tw/content', 'product-callouts'); ?>

      <!-- Delivery & Installation -->
      <?php get_template_part('template-parts/tw/content', 'product-delivery'); ?>

      <!-- Delivery (zip codes) -->
      <?php get_template_part('template-parts/safes/content', 'delivery-cities'); ?>
      <?php //get_template_part('template-parts/tw/content', 'product-zips'); 
      ?>

      <!-- Locations -->
      <?php get_template_part('template-parts/tw/content', 'product-locations'); ?>

   </main>
</div>