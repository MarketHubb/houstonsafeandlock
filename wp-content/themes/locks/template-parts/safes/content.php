
<div class="container-fluid">
    <div class="wrapper">

        <?php
            $product_cats = [37, 27, 28, 33, 42];
            $terms = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'include' => $product_cats,
                'orderby' => 'include'
            ));

            $i = 1;
            $cats = '';


            foreach ($terms as $term) {
                if ($term->parent === 0) {
                    $heading_order_class = ($i % 2 == 0) ? 'order-md-last' : '';
                    $cats .= '<div class="row align-items-center py-3 my-3">';
                    $cats .= '<div class="col-md-6 h-100 ' . $heading_order_class . '">';
                    $cats .= '<h2 class="font-weight-bold">' . $term->name . '</h2>';
                    $cats .= '<p class="lead">' . trim($term->description) . '</p>';
                    $cats .= '<a href="' . get_term_link($term) . '" class="lead font-weight-bold">';
                    $cats .= 'View All ' . $term->name . ' <i class="fas fa-long-arrow-right"></i></a>';
                    $cats .= '<p class="font-italic">' . $term->count . ' models in stock</p>';
                    $cats .= '</div><div class="col-md-6 h-100 text-center">';

                    $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                    $image = wp_get_attachment_url( $thumbnail_id );
                    $cats.= '<img src="' . $image . '" alt="' . $term->name . '" />';
                    $cats .= '</div></div>';

                    $i++;
                }
            }
            echo $cats;
            ?>
    </div>
</div>


