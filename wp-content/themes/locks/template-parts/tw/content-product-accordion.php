<?php $product = wc_get_product(get_the_id()); ?>

<section aria-labelledby="details-heading" class="mt-12">
   <h2 id="details-heading" class="sr-only">Additional details</h2>

   <div class="" id="accordion">
      <div class="accordion-item border-x-0 border-t-0">
         <h3>
            <button type="button" class="bg-white shadow-none pl-4 accordion-button group relative flex w-full items-center justify-between py-6 text-left" aria-expanded="true" aria-controls="features-content">
               <span class="font-semibold tracking-tight text-gray-900 text-xl">Features</span>
               <span class="ml-6 flex items-center !:after-content-none">
                  <svg class="plus-icon hidden h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                  <svg class="minus-icon h-6 w-6 text-indigo-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                  </svg>
               </span>
            </button>
         </h3>
         <div class="accordion-content prose prose-sm pb-6" id="features-content">
            <?php get_template_part('template-parts/tw/content', 'product-attributes', $args); ?>
            <?php //get_template_part('template-parts/tw/content', 'product-accordion-features'); ?>
         </div>
      </div>
      <div class="accordion-item border-x-0">
         <h3>
            <button type="button" class="bg-white shadow-none  pl-4 accordion-button border-0 group  relative flex w-full items-center justify-between py-6 text-left" aria-expanded="false" aria-controls="specs-content">
               <span class="font-semibold tracking-tight text-gray-900 text-xl">Specs</span>
               <span class="ml-6 flex items-center after:content-['']">
                  <svg class="plus-icon  h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                  <svg class="minus-icon hidden h-6 w-6 text-indigo-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                  </svg>
               </span>
            </button>
         </h3>
         <div class="accordion-content hidden prose prose-sm pb-6" id="specs-content">
            <?php echo get_the_content(); ?>
         </div>
      </div>

      <!-- Details -->
      <?php if (isset($product) && !empty($product->get_description())) { ?>

         <div class="accordion-item border-x-0 border-b-0">
            <h3>
               <button type="button" class="bg-white shadow-none  pl-4 accordion-button border-0 group  relative flex w-full items-center justify-between py-6 text-left" aria-expanded="false" aria-controls="details-content">
                  <span class="font-semibold tracking-tight text-gray-900 text-xl after:content-['']">Details</span>
                  <span class="ml-6 flex items-center  ">
                     <svg class="plus-icon h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                     </svg>
                     <svg class="minus-icon hidden h-6 w-6 text-indigo-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                     </svg>
                  </span>
               </button>
            </h3>
            <div class="accordion-content hidden prose prose-sm pb-6" id="details-content">
               <?php the_field('post_product_gun_long_description'); ?>
               <?php echo $post->post_excerpt; ?>
            </div>
         </div> 

      <?php } ?>

      <!-- More sections... -->
   </div>
</section>
