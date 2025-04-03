<?php if (! isset($args)) return; ?>

<?php
$sale = get_sale_discount();
$active = is_sale_active();
 ?>

<!-- Price -->
<div class="mt-0 flex items-center gap-x-3">
    <h2 class="sr-only">Product information</h2>
    <div class="flex items-center justify-center gap-x-2">

        <?php if (is_sale_enabled()) { ?>
            <!-- MSRP -->
            <?php if (!empty($args['price'])) { ?>
                <p class="line-through decoration-1 text-gray-500 text-sm">
                    $<?php echo $args['price']; ?>
                </p>
            <?php } ?>
        <?php } ?>

        <!-- Discounted Price -->
        <?php if (!empty($args['discount_price'])) { ?>
            <?php echo get_product_price_format($args['discount_price']); ?>
        <?php } else { ?>
            Call for pricing
        <?php } ?>

        <!-- Sale -->
        <?php if (get_sale_discount()) { ?>
            <span class="inline items-center rounded-md bg-red-50 border border-1 border-red-100  px-2 py-[2px] text-xs sm:text-sm md:text-[.9rem] font-semibold antialiased text-red-600 relative bottom-2 left-1 rotate-[-7deg]">
                <?php echo get_sale_discount(); ?>% Off
            </span>
        <?php } ?>

    </div>
</div>

<!-- Sale Ribbon -->
<?php if (!empty($args['discount_amount'])) { ?>
    <!-- <p class="text-gray-800 bg-yellow-100 px-2 pt-[1px] pb-[2px] rounded-lg mt-3 inline-block leading-none text-sm sm:text-base font-medium"> -->
    <!-- <p class="text-blue-500 mt-1 inline-block leading-none text-xs sm:text-sm bg-blue-50 rounded-md px-2 py-[1px] shadow-sm"> -->
    <p class="text-gray-500 mt-1 inline-block leading-none text-xs sm:text-sm">
        Save
        <span class="font-bold antialiased">
            $<?php echo number_format_i18n(floatval($args['discount_amount']), 2); ?>
        </span>
        <span class="">
            during our <?php echo get_sale_title(); ?> sale!
        </span>
    </p>
<?php } ?>