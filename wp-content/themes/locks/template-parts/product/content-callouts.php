<?php if (empty($args)) return; ?>

<?php
$items = '';

foreach ($args as $callout) {
    ob_start(); ?>
        <li class="flex gap-x-3">
            <span class="size-5 flex justify-center items-center rounded-full bg-blue-50 text-blue-600">
                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
            <span class="text-gray-800 tracking-tight text-sm sm:text-base"><?php echo $callout; ?></span>
        </li>
    <?php
    $items .= ob_get_clean();
}
?>

<div class="grid grid-cols-1">
    <ul class="space-y-3 text-sm">
        <?php echo $items; ?>
    </ul>
</div>
