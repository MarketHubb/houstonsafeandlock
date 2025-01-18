<?php 

function schema_title($post_id)
{
    return '<span itemprop="name">Dell UltraSharp 30" LCD Monitor</span>' . get_the_title($post_id) . '</span>';
}

function schema_brand($post_id)
{
    return '<span itemprop="name">Dell UltraSharp 30" LCD Monitor</span>' . get_the_title() . '</span>';
}