<div class="bg-brand-500 text-white py-5">
    <div class="container mx-auto px-4 py-4 my-2">
        <div class="flex flex-wrap">

            <?php
            $top_pages = [
                'Locksmith' => [
                    'icon' => 'fa-light fa-key',
                    'page_ids' => [6624, 6839, 6448]
                ],
                'Safes' => [
                    'icon' => 'fa-light fa-vault',
                    'page_ids' => [37, 27, 28, 42, 33]
                ],
                'Top Pages' => [
                    'icon' => 'fa-light fa-link',
                    'page_ids' => [266, 66, 4, 68]
                ],
            ];

            $page_links = '';
            foreach ($top_pages as $key => $val) {
                $page_links .= '<div class="w-full md:w-1/4 md:pr-4 mb-5 md:mb-0 pl-4 md:pl-0">';
                $page_links .= '<h5 class="font-bold text-base text-[1.15rem] antialiased mb-3 md:mb-4 !text-white">';
                $page_links .= '<i class="' . $val['icon'] . '  inline md:block !text-gray-50 mr-2"></i>';
                $page_links .= $key . '</h5>';
                $page_links .= '<ul class=" list-disc ps-2 sm:ps-4 ">';

                foreach ($val['page_ids'] as $page_id) {
                    $page_links .= '<li class="bg-transparent !text-gray-50">';

                    if ($key === 'Safes') {
                        $cat = get_term($page_id, 'product_cat');
                        $link_text = $cat->name;
                        $link = get_category_link($page_id);
                    } else {
                        $link_text = get_the_title($page_id);
                        $link = get_permalink($page_id);
                    }

                    $page_links .= '<a href="' . $link . '" class=" text-xs sm:text-sm !text-gray-50 hover:text-white">';
                    $page_links .= $link_text;
                    $page_links .= '</a></li>';
                }

                if ($key === 'Locksmith Services') {
                    $page_links .= '<li class="pl-4 ml-2 md:ml-0 md:pl-0 bg-transparent">';
                    $page_links .= '<a href="https://www.autofobs.com/?ref=44&locid=18451" class="!text-gray-50 !hover:text-white">';
                    $page_links .= 'Auto Fob Duplication';
                    $page_links .= '</a></li>';
                }

                $page_links .= '</ul></div>';
            }

            echo $page_links;
            ?>

            <div class="w-full md:w-1/4 md:mb-0 pl-4 md:pl-0">
                <h5 class="font-bold text-base text-[1.15rem] antialiased mb-3 md:mb-4 !text-white">
                    <i class="fa-light fa-location-dot inline md:block !text-gray-50 mr-1"></i>
                    Contact
                </h5>
                <div itemscope itemtype="https://schema.org/LocalBusiness" class="pl-2 sm:pl-4">
                    <div itemprop="name" class="font-bold mt-1 mb-2">Houston Safe & Lock</div>
                    <div>Email: <span itemprop="email">
                            <a href='mailto:sales@houstonsafeandlock.com' class="hover:text-gray-300">sales@houstonsafeandlock.com</a>
                        </span></div>
                    <div>Phone: <a href="tel:713-522-5555" class="hover:text-gray-300">
                            <span itemprop="telephone">713-522-5555</span>
                        </a></div>

                    <div itemprop="paymentAccepted" class="hidden">cash, check, credit card</div>
                    <meta itemprop="openingHours" class="hidden" datetime="Mo,Tu,We,Th,Fr,Sa 08:00-05:00" />
                    <hr class="my-3 border-gray-400">
                    <div itemtype="http://schema.org/PostalAddress" itemscope="" itemprop="address">
                        <div itemprop="streetAddress">10210 Westheimer Rd.</div>
                        <div>
                            <span itemprop="addressLocality">Houston</span>,
                            <span itemprop="addressRegion">TX</span>
                            <span itemprop="postalCode">77042</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>