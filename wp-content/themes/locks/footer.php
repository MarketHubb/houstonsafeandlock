</div><!-- #content -->

<?php if (!is_singular('product')) { ?>

    <!-- One company, two locations -->
    <?php get_template_part('template-parts/footer/content', 'locations'); ?>

<?php } ?>

<!-- Links  -->
<?php get_template_part('template-parts/footer/content', 'links'); ?>

<!-- Links  -->
<?php get_template_part('template-parts/footer/content', 'callouts'); ?>

</div><!-- #page -->


<!-- Featured Safes -->
<?php
if (is_front_page()) {
    $featured_home = featured_safes("home");
    if (count($featured_home) > 0) {
        get_template_part('template-parts/featured/content', 'featured-home', $featured_home);
    }
}
?>

<?php
if (is_front_page()) {
    get_template_part('template-parts/tw-shared/content', 'modal-global');
}
?>

<!-- Lead Form (Safes) -->
<?php
$product_data = isset($product_data) && !empty($product_data)
    ? $product_data
    : get_product_attributes(get_queried_object_id(), false);

if (false) {
    // if ($product_data) {
    get_template_part("template-parts/product/content", "modal", $product_data);
}

$id = get_queried_object_id();

if (is_page_with_modal_form($id)) {
    $form_id = get_preline_modal_form_id(get_queried_object_id());

    if ($form_id) {
        gravity_form_enqueue_scripts($form_id, true);
        get_template_part("template-parts/product/content", "modal", ['form_id' => $form_id]);
    }
}

?>

<?php wp_footer(); ?>

<!-- Inline Scripts -->

<!-- Lucide icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
<!-- Google Code for Remarketing Tag -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1026494785;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1026494785/?guid=ON&amp;script=0" />
    </div>
</noscript>
<script type="text/javascript" src="//cdn.callrail.com/companies/327335430/7f0018b85cb8e567f0f9/12/swap.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        HSOverlay.autoInit();
    });
</script>

</body>

</html>