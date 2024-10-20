<!-- Blog Article -->
<div class="max-w-3xl px-4 pt-6 lg:pt-10 py-12 sm:px-6 lg:px-8 mx-auto">
   <div class="max-w-2xl">

      <!-- Content -->
      <div class="space-y-5 md:space-y-8">

         <div class="space-y-3">
            <!-- Post Title -->
            <h2 class="text-2xl font-bold md:text-3xl">
               <?php the_title(); ?>
            </h2>

            <!-- Post Excerpt -->
            <p class="text-lg text-gray-800 italic">
               <?php echo strip_tags(get_the_excerpt()); ?>
            </p>
         </div>

         <!-- Featured Image -->
         <?php if (has_post_thumbnail()) : ?>
            <figure>
               <?php the_post_thumbnail('large', ['class' => 'w-full object-cover rounded-xl']); ?>
               <figcaption class="mt-3 text-sm text-center text-gray-500">
                  <?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
               </figcaption>
            </figure>
         <?php endif; ?>

         <!-- Post Content -->
         <div class="text-lg text-gray-800">
            <?php echo remove_tw_prefix_from_classes(get_the_content()); ?>
         </div>
      </div>
   </div>
</div>
<!-- End Blog Article -->

