<div class="tw-mt-4">
   <h1 class="tw-text-3xl tw-font-bold tw-tracking-tight tw-text-gray-900 sm:tw-text-4xl tw-inline-block">
      <?php echo get_the_title(); ?>
   </h1>

   <?php if (!empty($args['discount_percentage'])) { ?>

      <span class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-red-100 tw-px-2 tw-py-1 tw-text-small tw-font-medium tw-text-red-700 tw-ml-5 tw-relative tw-bottom-4 tw-rotate-[-6deg]">
         <?php echo $args['discount_percentage']; ?>% Off Sale
      </span>

   <?php } ?>

</div>