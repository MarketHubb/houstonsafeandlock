<?php /* Template Name: Full-width */

get_header('tw');

if (is_page([6448, 6624, 6839, 7276,7728])) {
    set_query_var('form_id', 2);
    set_query_var('modal_callouts', 'locksmith_');
    set_query_var('modal_heading', "Schedule Locksmith Service");
    set_query_var('modal_mobile_heading', 'Locksmith Inquiry');
}

?>
<?php if (is_page(6624)) { ?>
<div class="d-none container-fluid bg-orange py-3">
    <div class="row">
        <div class="col text-center">
			<p class="mb-0 text-white">
				<i class="fas fa-exclamation-triangle me-2"></i>
				Same-day appointments available - Call Now
            </p>
		</div>
        <div class="mb-5">
            <p class="d-inline-block px-3 text-white">Access Systems</p>
            <p class="d-inline-block px-3 text-white border-left border-right">Keys &  Locks</p>
            <p class="d-inline-block px-3 text-white">Emergencies</p>
        </div>

    </div>
</div>
<?php } ?>
<div class="genesis-container">
<?php 
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/content', 'page' );
endwhile; // End of the loop.
?>
</div>

<?php get_footer(); ?>