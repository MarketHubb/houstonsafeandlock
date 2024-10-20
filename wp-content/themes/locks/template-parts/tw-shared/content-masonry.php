  <!-- Content section -->
  <?php if (!isset($args) || empty($args)) return; ?>
  <div class="mt-32 overflow-hidden sm:mt-40">
     <div class="mx-auto max-w-7xl px-6 lg:flex lg:px-8">
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-12 gap-y-16 lg:mx-0 lg:min-w-full lg:max-w-none lg:flex-none lg:gap-y-8">
           <div class="lg:col-end-1 lg:w-full lg:max-w-lg lg:pb-8">
              <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Our location</h2>
              <p class="mt-6 text-xl leading-8 text-gray-600">Quasi est quaerat. Sit molestiae et. Provident ad dolorem occaecati eos iste. Soluta rerum quidem minus ut molestiae velit error quod. Excepturi quidem expedita molestias quas.</p>

              <div class="mt-10">
                 <p class="fs-large mb-3">
                    <strong class="mb-2 d-block">Monday-Friday</strong>
                    8:00am - 5:00pm
                 </p>
                 <p class="fs-large mb-3">
                    <strong class="mb-2 d-block">Saturday</strong>
                    9:00am - 4:00pm
                 </p>
                 <p class="fs-large mb-3">
                    <strong class="mb-2 d-block">Sunday</strong>
                    Closed
                 </p>
              </div>
           </div>

           <div class="flex flex-wrap items-start justify-end gap-6 sm:gap-8 lg:contents">
              <div class="w-0 flex-auto lg:ml-auto lg:w-auto lg:flex-none lg:self-end">
                 <img src="<?php echo $args[0]['image']; ?>" alt="" class="aspect-[7/5] w-[37rem] max-w-none rounded-2xl bg-gray-50 object-cover">
              </div>
              <div class="contents lg:col-span-2 lg:col-end-2 lg:ml-auto lg:flex lg:w-[37rem] lg:items-start lg:justify-end lg:gap-x-8">
                 <div class="order-first flex w-64 flex-none justify-end self-end lg:w-auto">
                    <img src="<?php echo $args[1]['image']; ?>" alt="" class="aspect-[4/3] w-[24rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover">
                 </div>
                 <div class="flex w-96 flex-auto justify-end lg:w-auto lg:flex-none">
                    <img src="<?php echo $args[2]['image']; ?>" alt="" class="aspect-[7/5] w-[37rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover object-top ">
                 </div>
                 <div class="hidden sm:block sm:w-0 sm:flex-auto lg:w-auto lg:flex-none">
                    <img src="<?php echo $args[3]['image']; ?>" alt="" class="aspect-[4/3] w-[24rem] max-w-none rounded-2xl bg-gray-50 object-cover">
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>