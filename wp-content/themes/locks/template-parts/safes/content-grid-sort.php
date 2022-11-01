<?php $attributes = $args['attributes'] ?: get_query_var('product_attributes'); ?>

<?php
if ($attributes) {
    $sorts  = '<div class="container" id="sort-filter-container">';
    $sorts .= '<ul id="sort-filter-nav" class="nav nav-pills justify-content-start">';
    $sorts .= '<li class="nav-item dropdown">';
    $sorts .= '<a class="nav-link dropdown-toggle filter-sort-type" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">';
    $sorts .= 'Sort By:</a>';
    $sorts .= '<div class="dropdown-menu">';

    $sort_types = ['asc', 'desc'];
    foreach ($attributes as $attribute) {
        foreach ($sort_types as $sort_type) {
            $sort_label = $sort_type === 'asc' ? ' (Asc)' : ' (Desc)';
            $sorts .= '<a class="dropdown-item" data-mixitup-control data-sort="';
            $sorts .= $attribute . ':' . $sort_type . '">';
            $sorts .= get_formatted_attributes($attribute)['name'] . ' ' . $sort_label . '</a>';
        }
    }

    $sorts .= '</div></li></ul></div>';
    echo $sorts;
}
