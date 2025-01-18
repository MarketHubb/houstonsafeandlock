<?php if (!isset($args)) return; ?>


<?php if (!empty($args['price']) && $args['quantity'] > 0): ?>

    <div class="flex flex-col sm:flex-row items-start gap-x-12 mt-8">

        <?php if ($args['quantity'] > 1): ?>

            <select id="location" name="location" class="h-full py-3 rounded-md border-0 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-base/6">
                <option disabled>Qty:</option>

                <?php for ($i = 1; $i <= $args['quantity']; ++$i): ?>
                    <?php $selected = $i === 1 ? ' selected' : ''; ?>
                    <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                <?php endfor ?>

            </select>

        <?php endif ?>

        <div class="mx-auto w-full">
            <?php echo get_shopify_buy_button(); ?>
            <button type="button" class="flex w-full items-center justify-center rounded-md border border-transparent bg-brandBlue-500 hover:bg-brandBlue-400 px-8 py-3 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-large-modal" data-hs-overlay="#hs-large-modal">
                ADD TO CART
            </button>
            <div class="flex shrink items-center gap-6 text-gray-500 text-sm justify-center mt-5 px-0 sm:px-4 md:px-6 lg:px-8">
                <div class="text-center sm:text-left flex-1 sm:flex-auto">
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mb-2 sm:mb-0 inline-block size-[1rem] sm:size-[.875rem] text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                    </span>
                    <span class="block sm:inline font-semibold !leading-none sm:leading-normal antialiased pl-1">Delivery:</span> 7-10 days
                </div>
                <div class="text-center sm:text-left flex-1 sm:flex-auto">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mb-2 sm:mb-0 inline-block size-[1rem] sm:size-[.875rem] text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                        </svg>
                    </span>
                    <span class="block sm:inline font-semibold !leading-none sm:leading-normal antialiased pl-1">Condition:</span> New
                </div>
                <div class="text-center sm:text-left flex-1 sm:flex-auto">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mb-2 sm:mb-0 inline-block size-[1rem] sm:size-[.875rem] text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                    </span>
                    <span class="block sm:inline font-semibold !leading-none sm:leading-normal antialiased pl-1">Warranty:</span> Limited
                </div>
            </div>
        </div>
    </div>

<?php elseif (false): ?>

<?php endif ?>