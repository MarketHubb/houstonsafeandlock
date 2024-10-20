<?php
if (isset($args)) { ?>

   <?php if (!empty($args)) { ?>
      <div>
         <p class=" inline-block leading-none text-lg text-gray-900 sm:text-xl md:text-2xl">
            $<?php echo $args['discounted_price']; ?>
            <span class="hidden text-base text-gray-800 relative right-1.5">.<?php echo $args['discounted_price_cents']; ?></span>
         </p>
         <p class=" ml-2 inline-block leading-none text-base text-gray-500 line-through sm:text-lg">
            $<?php echo $args['msrp_price']; ?>
         </p>
         <p class=" ml-2 text-green-700 inline-block leading-none text-base sm:text-lg">
            Save $<?php echo $args['discount_amount']; ?>
         </p>
      </div>
   <?php } ?>

<?php } ?>