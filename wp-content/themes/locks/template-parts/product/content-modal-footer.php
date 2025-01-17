<div class="grid grid-cols-2 sticky items-center bottom-0 bg-brand-500 text-white py-2.5 px-4 border-t mt-auto md:mt-0">
    <div>
        <?php
        $store_status = get_store_status_message();
        if ($store_status) {
            echo $store_status;
        }
        ?>
    </div>
    <div class="text-right">
        <a class="text-white font-semibold !no-underline text-[1.1rem]" href="tel:713-909-7881">713-909-7881</a>
    </div>
</div>