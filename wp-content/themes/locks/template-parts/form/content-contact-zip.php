<div class="py-3" id="contact">

   <?php echo form_section_heading('Contact'); ?>

   <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">

      <div>
         <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
         <div class="mt-1">
            <input type="text" id="first-name" name="first-name" autocomplete="given-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
         </div>
      </div>

      <div>
         <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
         <div class="mt-1">
            <input type="text" id="last-name" name="last-name" autocomplete="family-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
         </div>
      </div>
   </div>

   <div class="mt-4 grid grid-cols-1 gap-y-6 sm:gap-x-4">

      <div>
         <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
         <div class="">
            <input type="email" id="email-address" name="email-address" autocomplete="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
         </div>
      </div>

      <div>
         <label for="postal-code" class="block text-sm font-medium text-gray-700">Zip code</label>
         <div class="">
            <input
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               type="text"
               inputmode="numeric"
               pattern="[0-9]*"
               maxlength="5"
               autocomplete="postal-code">
         </div>
      </div>

   </div>

</div>