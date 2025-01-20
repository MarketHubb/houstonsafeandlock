<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto flex flex-col md:flex-row justify-between gap-8">
            <div class="md:w-1/3">
                <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg bg-gray-100">
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2024/08/Delivery.webp'; ?>"
                        alt="Delivery van"
                        class="object-cover">
                </div>
            </div>

            <div class="md:w-7/12">
                <p class="text-base tracking-wide text-primary font-semibold uppercase mb-3">Delivery to your location</p>
                <h2 class="text-4xl font-semibold tracking-tight text-gray-900 mt-4 md:mt-0">Delivery &amp; installation to more cities in Texas</h2>
                <p class="text-lg text-gray-600 mb-6">We deliver up to 100 miles from our location in Houston</p>

                <dl class="grid grid-cols-1 gap-x-6 gap-y-2 text-base text-gray-600 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-8">
                    <?php
                    $cities = [
                        // Column 1
                        [
                            'Galveston, TX',
                            'Southside Place, TX',
                            'Museum District, TX',
                            'Pasadena, TX',
                            'Friendswood, TX',
                            'Fresno, TX',
                            'League City, TX',
                            'Deer Park, TX',
                            'South Houston, TX',
                            'Clear Lake, TX'
                        ],
                        // Column 2
                        [
                            'Bellaire, TX',
                            'West University Place, TX',
                            'Sugar Land, TX',
                            'Missouri City, TX',
                            'Pearland, TX',
                            'Tomball, TX',
                            'Spring, TX',
                            'Magnolia, TX',
                            'The Woodlands, TX',
                            'Hockley, TX'
                        ],
                        // Column 3
                        [
                            'Cypress, TX',
                            'Houston, TX',
                            'Humble, TX',
                            'Pinehurst, TX',
                            'Jersey Village, TX',
                            'Atascosita, TX',
                            'Conroe, TX',
                            'Waller, TX',
                            'Klein, TX',
                            'Katy, TX'
                        ]
                    ];

                    foreach ($cities as $column) {
                        foreach ($column as $city) {
                            echo '<div class="relative pl-9">
                          <dt class="inline font-semibold text-gray-900">
                            <svg class="absolute left-1 top-1 size-5 text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                            ' . $city . '
                          </dt>
                        </div>';
                        }
                    }
                    ?>
                </dl>
            </div>
        </div>
    </div>
</div>