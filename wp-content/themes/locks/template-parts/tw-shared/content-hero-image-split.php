<?php if (!isset($args) || empty($args)) return; ?>

<div class="relative bg-white">
   <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8">
      <div class="px-6 pb-24 pt-10 sm:pb-32 lg:col-span-7 lg:px-0 lg:pb-56 lg:pt-48 xl:col-span-6">
         <div class="mx-auto max-w-2xl lg:mx-0">

            <?php if ($args['callout']) : ?>
               <div class="hidden sm:mt-32 sm:flex lg:mt-16">
                  <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-500 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                     <span>
                        <?php echo $args['callout']; ?>
                     </span>
                  </div>
               </div>
            <?php endif; ?>

            <?php if ($args['heading']) : ?>
               <h1 class="mt-24 text-4xl font-bold tracking-tight text-gray-900 sm:mt-10 sm:text-6xl">
                  <?php echo $args['heading']; ?>
               </h1>
            <?php endif; ?>

            <?php if ($args['description']) : ?>
               <p class="mt-6 text-lg leading-8 text-gray-600">
                  <?php echo $args['description']; ?>
               </p>
            <?php endif; ?>

            <dl class="mt-10 space-y-4 text-base leading-7 text-gray-700  antialiased font-semibold">
               <div class="flex gap-x-4">
                  <dt class="flex-none">
                     <span class="sr-only">Address</span>
                     <svg class="h-7 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                     </svg>
                  </dt>
                  <dd>
                     <?php echo $args['address']; ?>
                  </dd>
               </div>
               <div class="flex gap-x-4">
                  <dt class="flex-none">
                     <span class="sr-only">Telephone</span>
                     <svg class="h-7 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                     </svg>
                  </dt>
                  <dd>
                     <a class="text-gray-700  antialiased hover:text-brand-400 font-semibold" href="tel:+<?php echo $args['phone']; ?>">+1
                        <?php echo $args['phone']; ?>
                     </a>
                  </dd>
               </div>
               <div class="flex gap-x-4">
                  <dt class="flex-none">
                     <span class="sr-only">Email</span>
                     <svg class="h-7 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                     </svg>
                  </dt>
                  <dd><a class="text-gray-700  antialiased hover:text-brand-400 font-semibold" href="mailto:<?php echo $args['email']; ?>"><?php echo $args['email']; ?></a></dd>
               </div>
            </dl>
            <div class="mt-10 flex items-center gap-x-6">
               <a href="#" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                  Get Store Directions
               </a>
               <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Learn more <span aria-hidden="true">→</span></a>
            </div>
         </div>
      </div>

      <?php if ($args['image']) : ?>
         <div class="relative lg:col-span-5 lg:-mr-8 xl:absolute xl:inset-0 xl:left-1/2 xl:mr-0">
            <img class="aspect-[3/2] w-full bg-gray-50 object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-[90%]" src="<?php echo $args['image']; ?>" alt="">
         </div>
      <?php endif; ?>

   </div>
</div>