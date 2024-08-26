<?php $product = wc_get_product(get_the_id()); ?>

<section aria-labelledby="details-heading" class="tw-mt-12">
   <h2 id="details-heading" class="tw-sr-only">Additional details</h2>

   <div class="" id="accordion">
      <div class="accordion-item tw-border-x-0 tw-border-t-0">
         <h3>
            <button type="button" class="tw-pl-4 tw-accordion-button tw-group  tw-relative tw-flex tw-w-full tw-items-center tw-justify-between tw-py-6 tw-text-left" aria-expanded="true" aria-controls="features-content">
               <span class="tw-font-semibold tw-tracking-tight tw-text-gray-900 tw-text-xl">Features</span>
               <span class="tw-ml-6 tw-flex tw-items-center">
                  <svg class="plus-icon tw-hidden tw-h-6 tw-w-6 tw-text-gray-400 group-hover:tw-text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                  <svg class="minus-icon tw-block tw-h-6 tw-w-6 tw-text-indigo-400 group-hover:tw-text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                  </svg>
               </span>
            </button>
         </h3>
         <div class="accordion-content tw-block tw-prose tw-prose-sm tw-pb-6" id="features-content">
            <?php get_template_part('template-parts/tw/content', 'product-attributes', $args); ?>
            <?php //get_template_part('template-parts/tw/content', 'product-accordion-features'); ?>
         </div>
      </div>
      <div class="accordion-item tw-border-x-0">
         <h3>
            <button type="button" class=" tw-pl-4 tw-accordion-button tw-border-0 tw-group  tw-relative tw-flex tw-w-full tw-items-center tw-justify-between tw-py-6 tw-text-left" aria-expanded="false" aria-controls="specs-content">
               <span class="tw-font-semibold tw-tracking-tight tw-text-gray-900 tw-text-xl">Specs</span>
               <span class="tw-ml-6 tw-flex tw-items-center">
                  <svg class="plus-icon tw-block tw-h-6 tw-w-6 tw-text-gray-400 group-hover:tw-text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                  <svg class="minus-icon tw-hidden tw-h-6 tw-w-6 tw-text-indigo-400 group-hover:tw-text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                  </svg>
               </span>
            </button>
         </h3>
         <div class="accordion-content tw-hidden tw-prose tw-prose-sm tw-pb-6" id="specs-content">
            <?php echo get_the_content(); ?>
         </div>
      </div>

      <!-- Details -->
      <?php if (isset($product) && !empty($product->get_description())) { ?>

         <div class="accordion-item tw-border-x-0 tw-border-b-0">
            <h3>
               <button type="button" class=" tw-pl-4 tw-accordion-button tw-border-0 tw-group  tw-relative tw-flex tw-w-full tw-items-center tw-justify-between tw-py-6 tw-text-left" aria-expanded="false" aria-controls="details-content">
                  <span class="tw-font-semibold tw-tracking-tight tw-text-gray-900 tw-text-xl">Details</span>
                  <span class="tw-ml-6 tw-flex tw-items-center">
                     <svg class="plus-icon tw-block tw-h-6 tw-w-6 tw-text-gray-400 group-hover:tw-text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                     </svg>
                     <svg class="minus-icon tw-hidden tw-h-6 tw-w-6 tw-text-indigo-400 group-hover:tw-text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                     </svg>
                  </span>
               </button>
            </h3>
            <div class="accordion-content tw-hidden tw-prose tw-prose-sm tw-pb-6" id="details-content">
               <?php the_field('post_product_gun_long_description'); ?>
               <?php echo $post->post_excerpt; ?>
            </div>
         </div> 

      <?php } ?>

      <!-- More sections... -->
   </div>
</section>
