<div class="py-3" id="contact">

   <?php echo form_section_heading('1. Enter Zip', 'Enter your zip to get real-time delivery cost & timeframe'); ?>

   <div class="mt-4 grid grid-cols-1 gap-y-6 sm:gap-x-4">
      <div>
         <label for="postal-code" class="block text-sm font-medium text-gray-700">Zip code</label>
         <div class="">
            <input id="zip" type="text" pattern="[0-9]{5}" maxlength="5" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" inputmode="numeric" autocomplete="postal-code">
         </div>
      </div>
   </div>

   <?php //echo form_continue_btn('Select Delivery Options'); ?>

   <div id="distance-result" class="mt-4 text-center font-medium text-black"></div>

</div>