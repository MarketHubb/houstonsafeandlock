<?php
$modal_field = get_field('modal', 'option');
if (!get_field('modal_active', 'option') || empty($modal_field)) return;
?>

<div class="text-center opacity-0">
    <button type="button" class="opacity-0 p-0 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-modal-global" data-hs-overlay="#hs-modal-global">
        Open modal
    </button>
</div>

<div id="hs-modal-global" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1" aria-labelledby="hs-modal-global-label">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
        <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-900">
            <div class="absolute top-2 z-[10] end-2">
                <button type="button" class="inline-flex justify-center items-center size-8 text-sm font-semibold rounded-lg border border-transparent bg-white/10 text-white hover:bg-white/20 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#hs-modal-global">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <!-- Image -->
            <?php if ($modal_field['image']): ?>
                <div class="aspect-w-16 aspect-h-10">
                    <img class="w-full object-cover rounded-t-xl" src="<?php echo $modal_field['image']; ?>" alt="Modal Hero Image">
                </div>
            <?php endif; ?>

            <?php if ($modal_field['heading']): ?>
                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    <h3 id="modal-global-label" class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200">
                        <?php echo $modal_field['heading']; ?> 🎉
                    </h3>
                <?php endif; ?>

                <?php if ($modal_field['body']): ?>
                    <p class="!text-gray-500 dark:text-neutral-500">
                        <?php echo $modal_field['body']; ?>
                    </p>
                <?php endif; ?>

                <?php if ($modal_field['link_text'] && $modal_field['link_url']): ?>
                    <div class="mt-6 flex justify-center gap-x-4">
                        <a href="<?php echo get_permalink($modal_field['link_url']->ID); ?>" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#hs-modal-global">
                            <?php echo $modal_field['link_text']; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($modal_field['secondary_link_text'] && $modal_field['secondary_link_url']): ?>
                        <a href="<?php echo get_permalink($modal_field['secondary_link_url']->ID); ?>" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400" href="#">
                            <?php echo $modal_field['secondary_link_text']; ?>
                        </a>
                    </div>
                <?php endif; ?>
                </div>
        </div>
    </div>
</div>