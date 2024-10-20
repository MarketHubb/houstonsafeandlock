<?php
$blogs = get_posts(array(
    'post_type' => 'post',
    'posts_per_page' => -1,
));

$posts = '';

foreach ($blogs as $blog) {
    $posts .= '<div class="blog-list">';
    $posts .= '<div class="card h-100 shadow-sm">';
    $posts .= '<img src="' . get_the_post_thumbnail_url($blog->ID, "large") . '" class="card-img-top" alt="...">';
    $posts .= '<div class="card-body">';

    $terms = get_the_terms($blog->ID, 'category');

    if (count($terms) > 0) {
        foreach ($terms as $term) {
            $posts .= '<span class="text-dark badge bg-light me-2">' . $term->name . '</span>';
        }
    }

    $posts .= '<a href="' . get_the_permalink($blog->ID) . '" class="">';
    $posts .= '<h5 class="card-title mt-3">' . get_the_title($blog->ID) . '</a></h5>';
    $posts .= '<p class="card-text">' . get_the_excerpt($blog->ID) . '</p>';
    $posts .= '<a href="' . get_the_permalink($blog->ID) . '" class="fs-5">View Article</a>';
    $posts .= '</div></div></div>';
}
echo $posts;
?>

