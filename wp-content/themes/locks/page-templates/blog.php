<?php /* Template Name: Blog (New) */

get_header(); ?>

<?php //get_template_part('template-parts/global/content', 'hero-simple'); 
?>

<div class="container py-16">
    <div class="max-w-3xl justify-content-center text-center mx-auto pb-12">
        <h1>Our Blog</h1>
        <p class="text-base md:text-lg text-gray-700">Welcome to the Houston Safe & Lock blog - your go-to resource for insightful articles and expert tips on gun safes, high-security storage, and locksmith services. Discover how to fortify your security with our trusted products, and delve into the world of safety with our industry professionals.</p>
    </div>
    <div class="grid grid-cols-3 max-w-7xl mx-auto gap-8">
        <?php get_template_part('template-parts/content', 'blog'); ?>
    </div>
</div>


<?php get_footer(); ?>