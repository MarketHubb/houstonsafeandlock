<div class="mx-auto max-w-2xl px-4 py-24 sm:px-6 sm:py-32 lg:max-w-7xl lg:px-8">
   <!-- Details section -->
   <section aria-labelledby="details-heading">
      <div class="flex flex-col items-center text-center">
         <p class="text-base tracking-wide text-primary font-semibold uppercase mb-3">See before you buy</p>
         <h2 id="details-heading" class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl text-center">
            Experience the <?php echo get_the_title(); ?> today
         </h2>
         <p class="mt-3 max-w-3xl text-lg text-gray-600">
            Want to see the <?php echo get_the_title(); ?> before you buy? We have it on our showroom floor at both of our convienent Houston locations.
         </p>
      </div>

      <div class="mt-16 grid grid-cols-1 gap-y-16 lg:grid-cols-2 lg:gap-x-8">
         <div>
            <div class="aspect-h-2 aspect-w-3 w-full overflow-hidden rounded-lg mb-10">
               <img src="<?php echo get_home_url() . '/wp-content/uploads/2024/08/HSL-West.webp'; ?>" alt="Drawstring top with elastic loop closure and textured interior padding." class="h-full w-full object-cover object-center">
            </div>
            <h3 class="text-2xl font-semibold">
               Houston Safe & Lock - Westheimer
            </h3>
            <p class=" text-lg text-gray-500">
               <span class="block">10210 Westheimer Rd.</span>
               <span class="block">Houston, Texas - 77042</span>
               <span class="block font-semibold"><a href="tel:713-522-5555">713-522-5555</a></span>
            </p>
         </div>
         <div>
            <div class="aspect-h-2 aspect-w-3 w-full overflow-hidden rounded-lg mb-10">
               <img src="<?php echo get_home_url() . '/wp-content/uploads/2024/08/HSL-Mem.webp'; ?>" alt="Front zipper pouch with included key ring." class="h-full w-full object-cover object-center">
            </div>
            <h3 class="text-2xl font-semibold">
               Houston Safe & Lock - Memorial
            </h3>
            <p class=" text-lg text-gray-500">
               <span class="block">8429 Katy Fwy</span>
               <span class="block">Houston, Texas 77024</span>
               <span class="block font-semibold"><a href="tel:713-465-0055">713-465-0055</a></span>
            </p>
         </div>
      </div>
   </section>

   <!-- Policies section -->
   <section aria-labelledby="policy-heading" class="hidden mt-16 lg:mt-24">
      <h2 id="policy-heading" class="sr-only">Our policies</h2>
      <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 lg:gap-x-8">
         <div>
            <img src="https://tailwindui.com/img/ecommerce/icons/icon-delivery-light.svg" alt="" class="h-24 w-auto">
            <h3 class="mt-6 text-base font-medium text-gray-900">Free delivery all year long</h3>
            <p class="mt-3 text-base text-gray-500">Name another place that offers year long free
               delivery? We’ll be waiting. Order now and you’ll get delivery absolutely free.</p>
         </div>
         <div>
            <img src="https://tailwindui.com/img/ecommerce/icons/icon-chat-light.svg" alt="" class="h-24 w-auto">
            <h3 class="mt-6 text-base font-medium text-gray-900">24/7 Customer Support</h3>
            <p class="mt-3 text-base text-gray-500">Or so we want you to believe. In reality our chat
               widget is powered by a naive series of if/else statements that churn out canned responses.
               Guaranteed to irritate.</p>
         </div>
         <div>
            <img src="https://tailwindui.com/img/ecommerce/icons/icon-fast-checkout-light.svg" alt="" class="h-24 w-auto">
            <h3 class="mt-6 text-base font-medium text-gray-900">Fast Shopping Cart</h3>
            <p class="mt-3 text-base text-gray-500">Look at the cart in that icon, there&#039;s never
               been a faster cart. What does this mean for the actual checkout experience? I don&#039;t know.</p>
         </div>
         <div>
            <img src="https://tailwindui.com/img/ecommerce/icons/icon-gift-card-light.svg" alt="" class="h-24 w-auto">
            <h3 class="mt-6 text-base font-medium text-gray-900">Gift Cards</h3>
            <p class="mt-3 text-base text-gray-500">We sell these hoping that you will buy them for your
               friends and they will never actually use it. Free money for us, it&#039;s great.</p>
         </div>
      </div>
   </section>
</div>