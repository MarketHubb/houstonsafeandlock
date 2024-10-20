<div class="mt-4">
   <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl inline-block">
      <?php echo get_the_title(); ?>
   </h1>

   <?php if (!empty($args['discount_percentage'])) { ?>

      <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-small font-medium text-red-700 ml-5 relative bottom-4 rotate-[-6deg]">
         <?php echo $args['discount_percentage']; ?>% Off Sale
      </span>

   <?php } ?>

</div>