<?php
if (isset($args)) { ?>

   <?php if (!empty($args)) { ?>
      <div>
         <p class=" tw-inline-block tw-leading-none tw-text-lg tw-text-gray-900 sm:tw-text-xl md:tw-text-2xl">
            $<?php echo $args['discounted_price']; ?>
            <span class="tw-hidden tw-text-base tw-text-gray-800 tw-relative tw-right-1.5">.<?php echo $args['discounted_price_cents']; ?></span>
         </p>
         <p class=" tw-ml-2 tw-inline-block tw-leading-none tw-text-base tw-text-gray-500 tw-line-through sm:tw-text-lg">
            $<?php echo $args['msrp_price']; ?>
         </p>
         <p class=" tw-ml-2 tw-text-green-700 tw-inline-block tw-leading-none tw-text-base sm:tw-text-lg">
            Save $<?php echo $args['discount_amount']; ?>
         </p>
      </div>
   <?php } ?>

<?php } ?>