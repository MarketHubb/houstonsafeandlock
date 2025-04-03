 <dl class="mt-16 grid grid-cols-1 gap-x-8 gap-y-12 sm:mt-20 sm:grid-cols-2 sm:gap-y-16 lg:mt-28 lg:grid-cols-4">
     <?php if (get_product_attribute_fire_rating(get_the_ID())): ?>
         <div class="flex flex-col-reverse gap-y-2 border-l border-black">
             <dt class="text-base/7 text-gray-300 font-medium">
                 Fire Rating
             </dt>
             <dd class="text-xl font-semibold tracking-tight text-black">
                 <?php echo get_product_attribute_fire_rating(get_the_ID()); ?>
             </dd>
         </div>
     <?php endif; ?>
     <div class="flex flex-col-reverse gap-y-3 border-l border-black/20 pl-6">
         <dt class="text-base/7 text-gray-300">Employees</dt>
         <dd class="text-3xl font-semibold tracking-tight text-black">37</dd>
     </div>
     <div class="flex flex-col-reverse gap-y-3 border-l border-black/20 pl-6">
         <dt class="text-base/7 text-gray-300">Countries</dt>
         <dd class="text-3xl font-semibold tracking-tight text-black">12</dd>
     </div>
     <div class="flex flex-col-reverse gap-y-3 border-l border-black/20 pl-6">
         <dt class="text-base/7 text-gray-300">Raised</dt>
         <dd class="text-3xl font-semibold tracking-tight text-black">$25M</dd>
     </div>
 </dl>