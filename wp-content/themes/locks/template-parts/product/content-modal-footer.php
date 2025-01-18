    <div class="flex-1 hidden">
        <p class="relative text-sm text-pretty sm:text-base antialiased !leading-tight text-gray-500 tracking-tight">Our team will review your information & respond <span class="underline font-semibold">today</span> with everything you need to order this safe</p>
        <!-- <p class=" relative bottom-5 text-sm sm:text-base antialiased text-center !leading-tight tracking-tight">Our team will review your information & respond <span class="underline font-semibold">today</span> with everything you need to order this safe</p> -->
        <span class="text-xs sm:text-sm font-medium italic text-gray-600">Avg. response time less than 1 hour</span>
    </div>
    <div class="grid grid-cols-2 sticky items-center bottom-0 bg-brand-500 text-white py-2.5 px-4 sm:px-8 border-t mt-auto md:mt-0">
        <!-- <div class="grid grid-cols-2 items-center bg-brand-500 text-white py-2.5 px-4 sm:px-8 border-t mt-auto md:mt-0"> -->
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