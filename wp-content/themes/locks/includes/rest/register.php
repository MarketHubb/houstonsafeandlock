<?php 
/**
 * Registers a REST API endpoint for logging errors.
 *
 * Creates a POST endpoint at /wp-json/markethubb/log-error that allows
 * client-side errors to be logged on the server. This endpoint is publicly
 * accessible and does not require authentication.
 *
 * @since 1.0.0
 * @return void
 */
function mh_register_error_log_endpoint()
{
    register_rest_route(
        'markethubb',
        '/log-error',
        [
            'permission_callback' => '__return_true',
            'method' => 'POST',
            'callback' => 'mh_log_rest_errors'
        ]
    );
}
add_action('rest_api_init', 'mh_register_error_log_endpoint');

/**
 * Registers a REST API endpoint for retrieving remaining safes.
 *
 * Creates a GET endpoint at /wp-json/markethubb/remaining-safes that returns
 * a list of remaining safes, excluding those specified in the exclude_ids parameter.
 * This endpoint is publicly accessible and does not require authentication.
 *
 * @since 1.0.0
 * @return void
 */
function mh_register_products_endpoint()
{
    register_rest_route('markethubb', '/remaining-safes', array(
        'methods'             => 'GET',
        'callback'            => 'mh_get_remaining_safes',
        'permission_callback' => '__return_true', // Publicly accessible
        'args'                => array(
            'exclude_ids' => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));
}
add_action('rest_api_init', 'mh_register_products_endpoint');