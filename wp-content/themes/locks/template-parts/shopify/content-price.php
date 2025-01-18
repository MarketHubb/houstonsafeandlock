<?php if (! isset($args) || empty($args['price'])) return; ?>

<div class="mt-0 flex items-center gap-x-3">
    <h2 class="sr-only">Product information</h2>
    <div class="flex items-center gap-x-3">
        <p class="text-lg sm:text-xl md:text-3xl  text-red-600 font-semibold font-oxygen">
            $<?php echo number_format_i18n($args['price']['discounted_price'], 2); ?>
        </p>
        <span class="inline items-center rounded-full bg-red-600 px-2 py-1 text-xs font-semibold uppercase text-white">
            Save <?php echo $args['price']['discount']; ?>
        </span>
        <p class="text-base sm:text-lg md:text-xl line-through decoration-gray-400 text-gray-400 antialiased font-oxygen">
            $<?php echo number_format_i18n($args['price']['price'], 2); ?>
        </p>
    </div>
</div>
<p class="text-gray-800 bg-yellow-100 mt-1 inline-block leading-none text-sm sm:text-base font-medium">
    <span class="font-bold antialiased"> Save $<?php echo number_format_i18n($args['price']['discount_amount'], 2); ?></span> while supplies last
    <span class="">(<?php echo $args['quantity']; ?> in stock) </span>
</p>