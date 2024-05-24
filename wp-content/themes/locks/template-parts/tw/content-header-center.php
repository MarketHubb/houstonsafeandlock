<?php if (isset($args)) { ?>
   <div class="tw-bg-white tw-px-6 tw-py-12 sm:tw-py-12 lg:tw-px-8">
      <div class="tw-mx-auto tw-max-w-2xl tw-text-center">
         
         <?php if (isset($args['callout'])) { ?>
            <p class="tw-text-base tw-font-semibold tw-leading-7 tw-text-indigo-600"><?php echo $args['callout']; ?></p>
         <?php } ?>
         
         <h2 class="tw-mt-2 tw-text-4xl tw-font-bold tw-tracking-tight tw-text-gray-900 sm:tw-text-6xl"><?php echo $args['heading']; ?></h2>

         <?php if (isset($args['description'])) { ?>
            <p class="tw-mt-6 lead fw-normal tw-leading-8 tw-text-gray-600"><?php echo $args['description']; ?></p>
         <?php } ?>

      </div>
   </div>
<?php } ?>