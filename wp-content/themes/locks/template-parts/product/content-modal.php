<div id="hs-full-screen-modal-below-md" class="hs-overlay hidden size-full fixed top-0 start-0 z-[99999001] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-scroll-inside-body-modal-label">
    <div class="sm:hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg md:max-w-3xl sm:w-full sm:m-3 h-full sm:h-[calc(100%-3.5rem)] sm:mx-auto">
        <div class="max-h-full overflow-hidden flex flex-col bg-white border shadow-sm sm:rounded-xl pointer-events-auto">

            <?php get_template_part('template-parts/product/content', 'modal-close'); ?>

            <div class="px-4 sm:px-0 overflow-y-auto" id="product-lead-modal">

                <?php get_template_part('template-parts/product/content', 'modal-header'); ?>

                <?php get_template_part('template-parts/product/content', 'modal-lead', $args); ?>

            </div>

            <?php get_template_part('template-parts/product/content', 'modal-footer'); ?>

        </div>
    </div>
</div>