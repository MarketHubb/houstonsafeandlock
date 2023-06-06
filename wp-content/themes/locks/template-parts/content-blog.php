<div class="container">
    <div class="row">

        <?php
        $blogs = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
        ));

        $p = '<div class="row">';

        foreach ($blogs as $blog) {
            $p .= '<div class="col-md-4 my-4 blog-list">';
            $p .= '<div class="card h-100 shadow-sm">';
            $p .= '<img src="' . get_the_post_thumbnail_url($blog->ID, "large") . '" class="card-img-top" alt="...">';
            $p .= '<div class="card-body">';
            
            $terms = get_the_terms($blog->ID, 'category');

            if (count($terms) > 0) {
                foreach ($terms as $term) {
                    $p .= '<span class="text-dark badge bg-light me-2">' . $term->name . '</span>';
                }
            }

            $p .= '<a href="' . get_the_permalink($blog->ID) . '" class="">';
            $p .= '<h5 class="card-title mt-3">' . get_the_title($blog->ID) . '</a></h5>';
            $p .= '<p class="card-text">' . get_the_excerpt($blog->ID) . '</p>';
            $p .= '<a href="' . get_the_permalink($blog->ID) . '" class="fs-5">View Article</a>';
            $p .= '</div></div></div>';

        }

        $p .= '</div>';
        echo $p;
        ?>

    </div>
</div>
