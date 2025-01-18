<div class="py-3" id="delivery">

   <?php echo form_section_heading('2. Select Delivery', 'Choose how you want to receive your safe'); ?>

   <fieldset aria-label="Server size">
      <div class="space-y-4">
         <!-- Active: "border-indigo-600 ring-2 ring-indigo-600", Not Active: "border-gray-300" -->
         <label aria-label="Pickup" aria-description="Pickup your safe at our store" class="relative block cursor-pointer rounded-lg border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between">
            <input type="radio" name="delivery" value="Pickup" class="sr-only">
            <span class="flex items-center">
               <span class="flex flex-col text-[.9rem]">
                  <span class="font-semibold text-gray-900 !tracking-normal">Pickup</span>
                  <span class="text-gray-500 text-sm">
                     <span class="block sm:inline">10210 Westheimer Rd</span>
                     <span class="hidden sm:mx-1 sm:inline" aria-hidden="true">&middot;</span>
                     <span class="block sm:inline">Houston, TX 77042</span>
                  </span>
               </span>
            </span>
            <span class="mt-2 flex text-sm sm:ml-4 sm:mt-0 sm:flex-col sm:text-right justify-center">
               <span class="font-semibold text-gray-900">Free</span>
            </span>
            <!--
        Active: "border", Not Active: "border-2"
        Checked: "border-indigo-600", Not Checked: "border-transparent"
      -->
            <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
         </label>
         <!-- Active: "border-indigo-600 ring-2 ring-indigo-600", Not Active: "border-gray-300" -->
         <label aria-label="Pickup" aria-description="Pickup your safe at our store" class="relative block cursor-pointer rounded-lg border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between">
            <input type="radio" name="delivery" value="Pickup" class="sr-only">
            <span class="flex items-center">
               <span class="flex flex-col text-[.9rem]">
                  <span class="font-semibold text-gray-900 !tracking-normal">Delivery</span>
                  <span class="text-gray-500 text-sm">
                     <span class="block sm:inline">Est. delivery time</span>
                     <span class="hidden sm:mx-1 sm:inline" aria-hidden="true">&middot;</span>
                     <span class="block sm:inline">7-10 days</span>
                  </span>
               </span>
            </span>
            <span class="mt-2 flex text-sm sm:ml-4 sm:mt-0 sm:flex-col sm:text-right justify-center">
               <span class="font-semibold text-gray-900">$</span>
            </span>
            <!--
        Active: "border", Not Active: "border-2"
        Checked: "border-indigo-600", Not Checked: "border-transparent"
      -->
            <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
         </label>
      </div>
   </fieldset>

   <?php echo form_continue_btn('Checkout'); ?>

</div>