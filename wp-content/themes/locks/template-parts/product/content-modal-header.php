<?php
// 'Contact our team to order today'
// $default_subheading = "Contact our team to place an order today";
$default_subheading = "Get product information or place an order today";
// $default_subheading = "Place an order, or get answers from Houston's certified safe experts";
$callout = empty($args) || empty($args['callout'])
    ? $default_subheading
    : 'Get same-day information on the <span data-type="title"></span> from our team';
?>
<!-- Title -->
<div class="relative">
    <div class="text-center">

        <div class="mx-4 sm:mx-8 md:mx-14 lg:mx-20 pt-6">
            <div class="flex flex-row items-baseline justify-between">
                <div class="product-modal-heading text-left border-b border-gray-200 flex-1 pb-6">
                    <h3 class="font-bold text-brand-600 font-source text-xl sm:text-2xl lg:text-3xl" data-type="title">
                        AMSEC NF6030E5
                    </h3>
                    <p class="text-sm font-medium lg:text-base text-gray-600" data-type="callout">
                        <?php echo $callout; ?>
                    </p>
                </div>
                <div class="product-modal-image">
                    <img src="" class="size-14 sm:size-20 lg:w-[5.5rem] lg:h-[5.5rem] inline-block object-contain object-center" data-type="image">
                </div>
            </div>
        </div>

        <?php $modal_callouts  = get_gf_header_callouts(); ?>

        <ul class="text-[.9rem] text-gray-600 grid grid-cols-3 justify-center px-4 sm:px-0 gap-x-3 sm:gap-x-6 w-full sm:w-[85%] mx-auto my-5 sm:my-9">

            <?php foreach ($modal_callouts as $callout): ?>

                <!-- <li class="flex flex-col sm:flex-row gap-x-3 leading-tight font-medium text-xs sm:text-[.95rem] [&:not(:first-of-type)]:pl-5 sm:pl-10 w-full text-left"> -->
                <li class="flex flex-col sm:flex-row gap-x-3 leading-tight font-semibold antialiased text-xs sm:text-[.95rem]  w-full justify-center text-center sm:text-left">
                    <svg class="hidden shrink-0 size-3 sm:size-4 mt-0.5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span class="inline-block opacity-60 text-brand-500">
                        <?php echo $callout['icon']; ?>
                    </span>
                    <span class="hidden sm:inline-block leading-tight pt-1 sm:pt-0 text-pretty">
                        <?php echo $callout['desktop']; ?>
                    </span>
                    <span class="inline-block sm:hidden leading-tight pt-1 sm:pt-0 text-pretty">
                        <?php echo $callout['mobile']; ?>
                    </span>
                </li>

            <?php endforeach; ?>

        </ul>

    </div>
    <!-- Image -->
    <div class="mx-auto text-center hidden">
        <img src="https://houstonsafeandlock.test/wp-content/uploads/2022/08/NF6030-open.webp" class="size-10 inline-block object-contain object-center">
    </div>
</div>