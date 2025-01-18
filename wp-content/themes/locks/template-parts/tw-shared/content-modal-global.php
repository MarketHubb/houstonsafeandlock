<?php
$sale_popup = get_sale_popup();
if (!is_sale_active() || !$sale_popup) return;
?>

<div class="text-center opacity-0">
    <button type="button" class="opacity-0 p-0 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-modal-global" data-hs-overlay="#hs-modal-global">
        Open modal
    </button>
</div>

<div id="hs-modal-global" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1" aria-labelledby="hs-modal-global-label">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-xl sm:w-full m-3 sm:mx-auto">
        <div class="relative flex flex-col bg-white shadow-lg rounded-xl">
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
            <div class="aspect-w-16 aspect-h-10">
                <img
                    class="w-full object-cover rounded-t-xl"
                    src="<?php echo $sale_popup['image']; ?>"
                    alt="" />
            </div>

            <div class="p-4 sm:p-8 text-center overflow-y-auto">

                <!-- Heading -->
                <div class="relative">
                    <h3 id="modal-global-label" class="mb-2 text-2xl sm:text-3xl font-bold text-gray-800 !capitalize">
                        <span class="absolute left-[-5px] -rotate-[80deg] text-lg sm:text-xl">🎉</span><?php echo $sale_popup['heading']; ?><span class="absolute right-[-5px] text-lg sm:text-xl">🎉</span>
                    </h3>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <p class="!text-gray-500">
                        <?php echo replace_placeholders_in_string($sale_popup['body']); ?>
                    </p>

                    <!-- Details -->
                    <?php if (get_sale_details()) { ?>
                        <ul class="grid grid-rows-1 my-8 justify-center text-center !list-disc">
                            <?php foreach (get_sale_details() as $detail) { ?>
                                <li class="text-left py-1"><?php echo htmlspecialchars(trim($detail['heading']), ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <!-- Link List -->
                    <?php if (!empty($sale_popup['link_list'])) { ?>

                        <ul class="flex flex-row">

                            <?php foreach ($sale_popup['link_list'] as $link) { ?>

                                <li class="flex-grow text-center">
                                    <a href="<?php echo $link['link']['url']; ?>" class="hover:underline">
                                        <?php echo $link['text']; ?>
                                    </a>
                                </li>

                            <?php } ?>

                        </ul>

                    <?php } ?>



                </div>

                <?php if ($sale_popup['link_text'] && $sale_popup['link_url']): ?>
                    <div class="mt-6 flex justify-center gap-x-4">
                        <a href="<?php echo get_permalink($sale_popup['link_url']->ID); ?>" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#hs-modal-global">
                            <?php echo $sale_popup['link_text']; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($sale_popup['secondary_link_text'] && $sale_popup['secondary_link_url']): ?>
                        <a href="<?php echo get_permalink($sale_popup['secondary_link_url']->ID); ?>" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none" href="#">
                            <?php echo $sale_popup['secondary_link_text']; ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>