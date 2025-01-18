<div class="">
   <div class="mx-auto max-w-2xl px-4 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">

      <div class="py-10">
         <?php get_template_part('template-parts/form/content', 'progress'); ?>
      </div>

      <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
         <input type="hidden" id="base-zip" value="77042">


         <div>
            <!-- Contact -->
            <?php get_template_part('template-parts/form/content', 'zip'); ?>
            <!-- Delivery -->
            <?php get_template_part('template-parts/form/content', 'delivery'); ?>




            <div class="mt-10 border-t border-gray-200 pt-10 hidden ">
               <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

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

                  <div class="sm:col-span-2">
                     <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                     <div class="mt-1">
                        <input type="text" name="company" id="company" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     </div>
                  </div>

                  <div class="sm:col-span-2">
                     <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                     <div class="mt-1">
                        <input type="text" name="address" id="address" autocomplete="street-address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     </div>
                  </div>

                  <div class="sm:col-span-2">
                     <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment, suite, etc.</label>
                     <div class="mt-1">
                        <input type="text" name="apartment" id="apartment" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     </div>
                  </div>

                  <div>
                     <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                     <div class="mt-1">
                        <input type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     </div>
                  </div>

                  <div>
                     <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                     <div class="mt-1">
                        <select id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                           <option>United States</option>
                           <option>Canada</option>
                           <option>Mexico</option>
                        </select>
                     </div>
                  </div>

                  <div>
                     <label for="region" class="block text-sm font-medium text-gray-700">State / Province</label>
                     <div class="mt-1">
                        <input type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     </div>
                  </div>

                  <div>
                     <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal code</label>
                     <div class="mt-1">
                        <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     </div>
                  </div>

                  <div class="sm:col-span-2">
                     <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                     <div class="mt-1">
                        <input type="text" name="phone" id="phone" autocomplete="tel" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     </div>
                  </div>
               </div>
            </div>

            <div class="mt-10 border-t border-gray-200 pt-10 hidden ">
               <fieldset>
                  <legend class="text-lg font-medium text-gray-900 hidden ">Delivery method</legend>
                  <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                     <!--
                Checked: "border-transparent", Not Checked: "border-gray-300"
                Active: "ring-2 ring-indigo-500"
              -->
                     <label aria-label="Standard" aria-description="4–10 business days for $5.00" class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                        <input type="radio" name="delivery-method" value="Standard" class="sr-only">
                        <span class="flex flex-1">
                           <span class="flex flex-col">
                              <span class="block text-sm font-medium text-gray-900">Standard</span>
                              <span class="mt-1 flex items-center text-sm text-gray-500">4–10 business days</span>
                              <span class="mt-6 text-sm font-medium text-gray-900">$5.00</span>
                           </span>
                        </span>
                        <!-- Not Checked: "hidden" -->
                        <svg class="size-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                        <!--
                  Active: "border", Not Active: "border-2"
                  Checked: "border-indigo-500", Not Checked: "border-transparent"
                -->
                        <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
                     </label>
                     <!--
                Checked: "border-transparent", Not Checked: "border-gray-300"
                Active: "ring-2 ring-indigo-500"
              -->
                     <label aria-label="Express" aria-description="2–5 business days for $16.00" class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                        <input type="radio" name="delivery-method" value="Express" class="sr-only">
                        <span class="flex flex-1">
                           <span class="flex flex-col">
                              <span class="block text-sm font-medium text-gray-900">Express</span>
                              <span class="mt-1 flex items-center text-sm text-gray-500">2–5 business days</span>
                              <span class="mt-6 text-sm font-medium text-gray-900">$16.00</span>
                           </span>
                        </span>
                        <!-- Not Checked: "hidden" -->
                        <svg class="size-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                        <!--
                  Active: "border", Not Active: "border-2"
                  Checked: "border-indigo-500", Not Checked: "border-transparent"
                -->
                        <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
                     </label>
                  </div>
               </fieldset>
            </div>

         </div>

         <!-- Order summary -->
         <div class="mt-10 lg:mt-0">
            <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

            <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
               <h3 class="sr-only">Items in your cart</h3>
               <ul role="list" class="!pl-0 !ps-0 ml-0 divide-y divide-gray-200">
                  <li class="flex px-4 py-6 sm:px-6">
                     <div class="shrink-0">
                        <img src="https://houstonsafeandlock.test/wp-content/uploads/2021/08/BFX6030-DS-Final.png" alt="Front of men&#039;s Basic Tee in black." class="w-20 rounded-md">
                     </div>

                     <div class="ml-6 flex flex-1 flex-col">
                        <div class="flex">
                           <div class="min-w-0 flex-1">
                              <h4 class="text-sm">
                                 <a href="#" class="font-medium text-gray-700 hover:text-gray-800">
                                    <?php echo get_the_title(); ?>
                                 </a>
                              </h4>
                           </div>

                           <div class="ml-4 flow-root shrink-0">
                              <button type="button" class="-m-2.5 flex items-center justify-center bg-white p-2.5 text-gray-400 hover:text-gray-500">
                                 <span class="sr-only">Remove</span>
                                 <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                 </svg>
                              </button>
                           </div>
                        </div>

                        <div class="flex flex-1 items-end justify-between pt-2">
                           <p class="hidden mt-1 text-sm font-medium text-gray-900">$32.00</p>

                           <div class="ml-4">
                              <label for="quantity" class="sr-only">Quantity</label>
                              <select id="quantity" name="quantity" class="rounded-md border border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option>
                                 <option value="4">4</option>
                                 <option value="5">5</option>
                                 <option value="6">6</option>
                                 <option value="7">7</option>
                                 <option value="8">8</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </li>

                  <!-- More products... -->
               </ul>
               <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                  <div class="flex items-center justify-between">
                     <dt class="text-sm">Subtotal</dt>
                     <dd class="text-sm font-medium text-gray-900">$5,992.50</dd>
                  </div>
                  <div class="flex items-center justify-between">
                     <dt class="text-sm">Delivery</dt>
                     <dd class="text-sm font-medium text-gray-900">$0.00</dd>
                  </div>
                  <div class="flex items-center justify-between hidden">
                     <!--                      <dt class="text-sm">Taxes</dt>
                     <dd class="text-sm font-medium text-gray-900">$5.52</dd>
 -->
                  </div>
                  <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                     <dt class="text-base font-medium">Total</dt>
                     <dd class="text-base font-medium text-gray-900">$5,992.50</dd>
                  </div>
               </dl>

               <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                  <button type="submit" class="hidden w-full rounded-md border border-transparent bg-brandBlue-500 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-brandBlue-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Checkout</button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>