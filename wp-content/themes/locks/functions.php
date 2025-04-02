<?php
require_once 'includes/rest/init.php';
require_once 'includes/safes/init.php';
// require_once 'includes/rest-api.php';
require_once 'includes/new/content.php';
// require_once 'includes/tw-gravity-forms.php';
// require_once 'includes/tw-gravity-forms-admin.php';
require_once 'includes/gravity-forms/hooks.php';
require_once 'includes/tw-gravity-forms-helpers.php';
// require_once 'includes/gravity-forms.php';
require_once 'includes/enqueue.php';
// require_once 'includes/gform-enqueue.php';
require_once 'includes/acf.php';
require_once 'includes/admin.php';
// require_once 'includes/sales.php';
// require_once 'includes/ecommerce.php';
require_once 'includes/notifications.php';
// require_once 'includes/products.php';
// require_once 'includes/safe-helpers.php';
// require_once 'includes/safes-schema.php';
require_once 'includes/shopify.php';
require_once 'includes/shopify-admin.php';
require_once 'includes/shopify-form.php';
// require_once 'includes/queries.php';
require_once 'includes/plugins.php';
// require_once 'includes/safes.php';
require_once 'includes/tw-safes.php';
require_once 'includes/content.php';
require_once 'includes/tw-content.php';
require_once 'includes/helpers.php';

/**
 * locks functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package locks
 */

if (!function_exists('locks_setup')):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function locks_setup()
	{
		/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 * If you're building a theme based on locks, use a find and replace
			 * to change 'locks' to the name of your theme in all the template files.
		*/
		load_theme_textdomain('locks', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
		*/
		add_theme_support('title-tag');

		/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => esc_html__('Primary', 'locks'),
		));

		/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
		*/
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('locks_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));
	}
endif;
add_action('after_setup_theme', 'locks_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function locks_content_width()
{
	$GLOBALS['content_width'] = apply_filters('locks_content_width', 640);
}
add_action('after_setup_theme', 'locks_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function locks_widgets_init()
{
	register_sidebar(array(
		'name' => esc_html__('Sidebar', 'locks'),
		'id' => 'sidebar-1',
		'description' => esc_html__('Add widgets here.', 'locks'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => esc_html__('Footer Menus', 'locks'),
		'id' => 'footer-menus',
		'description' => esc_html__('Add footer menus.', 'locks'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'locks_widgets_init');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function register_safe_post_type()
{

	if (!post_type_exists('safe')) {

		register_post_type('safe', array(
			'public' => true,
			'label' => 'Safe Lines',
			'supports' => array('title', 'editor', 'thumbnail'),
		));

		register_taxonomy('safe_category', 'safe', array(
			'label' => __('Safe Categories'),
			'rewrite' => array('slug' => 'safe-category'),
			'hierarchical' => true,
		));
	}
}

add_action('init', 'register_safe_post_type');

function single_post_hero_background()
{

	$background_image = get_field('hero_background');
	$style_str = '';

	if (!empty($background_image)) {
		$style_str = 'style="background-image: url(\'' . $background_image['url'] . '\');"';
	} else {
		$style_str = 'style="background-image: url(\'/wp-content/themes/locks/images/header/header-back.jpg\');"';
	}

	return $style_str;
}

function render_single_post_hero_headlines($the_id)
{

	$headline = get_field('page_headline', $the_id);
	$sub_headline = get_field('page_sub_headline', $the_id);
	$html = '';

	if (!empty($headline)) {
		$html .= '<h1 class="test">' . $headline . '</h1>';
	} else {
		if (is_single()) {
			$html .= '<h1>' . get_the_title() . '</h1>';
		} else {
			$html .= '<h1>' . sanitize_post(get_queried_object())->name . '</h1>';
		}
	}

	if (!empty($sub_headline)) {
		$html .= '<h2>' . $sub_headline . '</h2>';
	} else {
		if (is_single()) {
			$terms = get_the_terms(get_the_ID(), 'safe_category');
			$html .= '<h2>' . $terms[0]->name . '</h2>';
		}
	}

	echo $html;
}

function tgm_io_cpt_search($query)
{

	if ($query->is_search) {
		$query->set('post_type', array('post', 'safe', 'page', 'attachment'));
	}

	return $query;
}

add_filter('posts_where', 'custom_posts_where', 10, 2);

function custom_posts_where($where, $query)
{

	global $wpdb;
	if (is_main_query() && is_search()) {
		$where .= " OR {$wpdb->posts}.post_title LIKE '%" . esc_sql(get_query_var('s')) . "%'";
	}
	return $where;
}

add_filter('wpseo_breadcrumb_links', 'check_links');

function check_links($links)
{
	if (is_tax('safe_category') || is_singular('safe')) {
		$safes_page_link = array(
			'text' => 'Safes',
			'url' => site_url() . '/safes',
			'allow_html' => 'true',
		);

		$new_links = array();
		$new_links[] = $links[0];
		$new_links[] = $safes_page_link;

		for ($i = 1; $i < count($links); $i++) {
			$new_links[] = $links[$i];
		}
	} else {
		$new_links = $links;
	}

	return $new_links;
}

############ BB

function mycode_add_rewrite_query_vars($vars)
{
	//array_push($vars, 'vids');
	array_push($vars, 'view');
	array_push($vars, 'viewblogdetail');
	array_push($vars, 'blog_id_1');
	array_push($vars, 'pgg');
	array_push($vars, 'bname');
	return $vars;
}
add_filter('query_vars', 'mycode_add_rewrite_query_vars');

add_rewrite_rule('^blog/([^/]*)/?', 'index.php?blog=blog', 'top');

add_rewrite_rule('Blog/([^/]*)/?', 'index.php?blog=blogg&pgg=$matches[1]', 'top');

add_rewrite_rule('blogdetail/([^/]*)/([^/]*)/?', 'index.php?blogdetail=blogdetail&bname=$matches[2]&blog_id_1=$matches[1]', 'top');

function my_page_function()
{

	if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'blog' && !isset($_REQUEST['page'])) {
		wp_redirect(home_url("/blog/"));
	} elseif (isset($_REQUEST['view']) && $_REQUEST['view'] == 'blog' && isset($_REQUEST['page'])) {
		wp_redirect(home_url("/blog/") . $_REQUEST['page'] . "/");
	} elseif (isset($_REQUEST['blogdetail']) && $_REQUEST['blogdetail'] != '') {
	}
}
add_action("template_redirect", "my_page_function");

/*
 * Woo Commerce functions
 * https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start()
{
	echo '<div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
	get_template_part('template-parts/content', 'header-hero-safe');
	echo '<div class="container-fixed">';
}

function my_theme_wrapper_end()
{
	echo '</div></main></div>';
}
add_filter('woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_delimiter');

function jk_change_breadcrumb_delimiter($defaults)
{
	$defaults['delimiter'] = ' &gt; ';
	return $defaults;
}

add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
	add_theme_support('woocommerce');
}

//-----------------------------------------------------
// RI - Global functions
//-----------------------------------------------------

function ri_get_product_parent_tax($term = array())
{

	$term_parent = ($term[0]->parent == 0) ? $term : get_term($term[0]->parent, 'product_cat');

	if (is_array($term_parent)) {

		$term_parent = $term_parent[0];
	}

	return $term_parent;
}

function ri_get_product_alert($parent_id)
{

	$alert = [];

	if (have_rows('global_safes_category_alerts', 'option')):

		while (have_rows('global_safes_category_alerts', 'option')): the_row();

			if (get_sub_field('global_safes_category_alerts_safe_category', 'option') == $parent_id) {

				$alert['desktop'] = get_sub_field('global_safes_category_alerts_category_message', 'option');
				$alert['mobile'] = get_sub_field('global_safes_category_message_mobile', 'option');
			}

		endwhile;

	endif;

	if (count($alert) === 0) {

		$alert['desktop'] = get_field('field_5dea85d0f82c7', 'option');
		$alert['mobile'] = get_field('field_5defc058afe02', 'option');
	}

	return $alert;
}

function get_sem_locksmith_pages()
{
	$page_ids = [];
	if (have_rows('global_safes_sem_locksmith_pages', 'option')):
		while (have_rows('global_safes_sem_locksmith_pages', 'option')): the_row();

			$page_ids[] = get_sub_field('global_safes_sem_locksmith_page', 'option');

		endwhile;
	endif;

	return $page_ids;
}

function compare_published_updated_dates($post_id)
{
	$dates = [];
	$published_time = strtotime(get_the_date('', $post_id));
	$updated_time = strtotime(get_the_modified_date('', $post_id));
	$date_diff = $updated_time - $published_time;
	$days_diff = round($date_diff / (60 * 60 * 24));

	if ($days_diff > 30) {
		$dates['updated'] = get_the_modified_date('', $post_id);
	} else {
		$dates['published'] = get_the_date('', $post_id);
	}

	return $dates;
}

function show_template()
{
	if (is_super_admin()) {
		global $template;
		print_r($template);
	}
}
add_action('wp_footer', 'show_template');
