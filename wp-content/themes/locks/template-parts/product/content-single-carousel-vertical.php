<?php if (empty($args)) return; ?>

<?php 
$thumbnails = '';
$gallery = '';

foreach ($args as $attachment_id) {
    $thumbnails .= '<div class="hs-carousel-pagination-item shrink-0 border-2 rounded-md overflow-hidden cursor-pointer w-8 sm:w-32 h-12 sm:h-32 hs-carousel-active:border-brand-300 hs-carousel-active:border-2">';
    $thumbnails .= '<div class="flex justify-center h-full p-[2px] sm:p-2">';
    $thumbnails .= '<img src="' . wp_get_attachment_image_url($attachment_id, 'thumbnail') .  '" class="" />';
    $thumbnails .= '</div></div>';

    $gallery .= '<div class="hs-carousel-slide">';
    $gallery .= '<div class="flex justify-center h-full">';
    $gallery .= '<img src="' . wp_get_attachment_image_url($attachment_id, 'full') .  '" class="object-cover" />';
    $gallery .= '</div></div>';
} 

?>
<div 
    data-hs-carousel='{
    "loadingClasses": "opacity-0"
  }' 
  class="relative init flex flex-col h-full">
    <div class="hs-carousel flex space-x-2 h-full">

        <!-- Thumbnails -->
        <div class="invisible w-0 md:visible md:w-auto flex-none md:min-h-full">
            <div class="hs-carousel-pagination flex-col max-w-24 sm:max-w-none gap-y-2 space-y-4 sm:space-y-0 overflow-y-auto">
                <?php echo $thumbnails; ?>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="relative grow overflow-hidden bg-white rounded-lg">
            <div class="hs-carousel-body relative md:absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                <?php echo $gallery; ?>
            </div>

            <button type="button" class="hs-carousel-prev z-50 hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex md:hidden justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg">
                <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                </span>
                <span class="sr-only">Previous</span>
            </button>
            <button type="button" class="hs-carousel-next z-50 hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex md:hidden justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg">
                <span class="sr-only">Next</span>
                <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
<!-- End Slider -->