<?php
$callout = empty($args) || empty($args['callout'])
    ? 'Contact our team to order today'
    : 'Get same-day information on the <span data-type="title"></span> from our team';
?>
<!-- Title -->
<div class="relative">
    <div class="text-center">
        <div class="pt-2 sm:py-3 mt-3 flex items-center text-sm text-gray-800 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
            <h3 class="font-bold text-gray-800 font-source text-xl sm:text-2xl" data-type="title">
                AMSEC NF6030E5
            </h3>
            <img src="https://houstonsafeandlock.test/wp-content/uploads/2022/08/NF6030-open.webp" class="hidden size-10 inline-block object-contain object-center" data-type="image">
        </div>
        <p class="text-sm font-medium lg:text-xl mb-4 sm:mb-6" data-type="callout">
            <?php echo $callout; ?>
        </p>

        <?php $modal_callouts  = get_gf_header_callouts(); ?>

        <ul class="text-[.9rem] text-gray-600 grid grid-cols-3 justify-center px-4 sm:px-0 gap-x-3 sm:gap-x-6 w-full sm:w-[85%] mx-auto divide-x">

            <?php foreach ($modal_callouts as $callout): ?>

                <li class="flex flex-col sm:flex-row gap-x-3 leading-tight font-medium text-xs sm:text-base [&:not(:first-of-type)]:pl-5 sm:pl-10 w-full text-left">
                    <svg class="shrink-0 size-3 sm:size-4 mt-0.5 text-secondary-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span class="leading-tight pt-1 sm:pt-0">
                        <?php echo $callout; ?>
                    </span>
                </li>

            <?php endforeach; ?>

        </ul>

    </div>
    <!-- Image -->
    <div class="mx-auto text-center hidden">
        <img src="https://houstonsafeandlock.test/wp-content/uploads/2022/08/NF6030-open.webp" class="size-10 inline-block object-contain object-center" data-type="image">
    </div>
</div>