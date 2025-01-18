<?php
function get_product_modal_tabs_data()
{
    return [
        [
            'name' => 'Contact',
            'description' => 'To start or place an order for this safe',
            'icon' => '<i class="fa-light fa-inbox-in"></i>',
            'content' => do_shortcode('[gravityform id="7" title="false" description="false" ajax="false" tabindex="10"]')
        ],
        [
            'name' => 'Visit',
            'description' => 'One of our two Houston locations',
            'icon' => '<i class="fa-light fa-shop"></i>',
            'content' => 'Visit content'
        ]
    ];
}

function get_gf_args_input_12()
{
    return [
        // [
        //     'icon' => '<i class="fa-light fa-cart-shopping"></i>',
        //     'value' => 'Place an order',
        //     'description' => "Contact our team to start your order today + ensure you're getting our guaranteed best price."
        // ],
        [
            'icon' => '<i class="fa-light fa-vault"></i>',
            'value' => 'Product information',
            'description' => 'Specs or product recommendations by certified safe experts'
        ],
        [
            'icon' => '<i class="fa-light fa-truck"></i>',
            'value' => 'Delivery information',
            'description' => 'Pickup & delivery options + custom installation quotes'
        ],
        [
            'icon' => '<i class="fa-light fa-square-question"></i>',
            'value' => 'Need something else?',
            'description' => 'Ask a question or leave a comment - our team is here to help you'
        ],
    ];
}

function get_gf_header_callouts()
{
    return [
        [
            'desktop' => 'Get our guaranteed best price',
            'mobile' => 'Get guaranteed best price',
            'icon' => '<i class="fa-light fa-tags"></i>'
        ],
        [
            'desktop' => 'Setup pickup or delivery options',
            'mobile' => 'Setup pickup or delivery',
            'icon' => '<i class="fa-light fa-truck"></i>'
        ],
        [
            'desktop' => 'Review available safe customizations',
            'mobile' => 'Review safe customizations',
            'icon' => '<i class="fa-light fa-vault"></i>'
        ],
    ];
}
