<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );

    //Magnific Popup
	wp_enqueue_style( 'magnific', get_stylesheet_directory_uri() .'/inc/css/magnific-popup.css' );
	wp_enqueue_script( 'magnific-scripts', get_stylesheet_directory_uri() . '/inc/js/magnific-popup.js', array('jquery'), '1.0.0', TRUE );

    //Slick Slider
	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() .'/inc/css/slick.css' );
	wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() .'/inc/css/slick-theme.css' );
	wp_enqueue_script( 'slick-scripts', get_stylesheet_directory_uri() . '/inc/js/slick.min.js', array('jquery'), '1.0.0', TRUE );

	//JS Cookie
	wp_enqueue_script( 'js-cookie', get_stylesheet_directory_uri() . '/inc/js/js.cookie.js', array('jquery'), '1.0.0', TRUE );

	//Pelafas Script
	wp_enqueue_script( 'mp-scripts', get_stylesheet_directory_uri() . '/inc/js/script.js', array('jquery'), '1.0.0', TRUE );

	// Ajax Script
	wp_register_script( 'mp-loadmore', get_stylesheet_directory_uri() . '/inc/js/mp-loadmore.js', array('jquery') );
	wp_localize_script( 'mp-loadmore', 'mp_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1
	) );
 	wp_enqueue_script( 'mp-loadmore' );

	//MP New Styles
	wp_enqueue_style( 'child-header', get_stylesheet_directory_uri() . '/inc/css/header.css');
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

/**
 * News Post Type
 */
include('inc/post_types/news.php');
/**
 * Swatches Post Type
 */
include('inc/post_types/swatches.php');
/**
 * Swatches Post Type
 */
include('inc/widgets/product-categories.php');

function mp_product_category_object_id_class( $classes, $item ) {
    // only check pages
    // if this page has a template assigned
    if( $item->object_id ) {
        // sanitize it and add it to the classes
        $classes[] = sanitize_html_class( 'object-id-'.$item->object_id );
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'mp_product_category_object_id_class', 10, 2 );

/**
 * Blog Ajax
 */
function mp_loadmore_ajax_handler(){
	// prepare our arguments for the query
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $_POST['posts_per_page'],
		'orderby' => 'date',
		'paged' => $_POST['page'] + 1,
		'post_status' => 'publish',
		'post_status' => 'publish',
	);
	if ($_POST['postnotin']) {
		$args['post__not_in'] = array($_POST['postnotin']);
	}
	if ($_POST['cat']) {
		$args['cat'] = $_POST['cat'];
	}
	query_posts( $args );

	if( have_posts() ) :

		$count = 1;
		// run the loop
		while( have_posts() ): the_post();
			$last = '';
			if ($count === 3) {
				$last = 'last';
				$count = 0;
			}
			$id = get_the_ID();
			$image = get_the_post_thumbnail_url( $id, 'large' );
			$category_list = " ";
			$categories = get_the_category();
			if ($categories) {
				foreach ($categories as $category) {
				 	$category_list .= $category->name. ', ';
				}
				$category_list = rtrim( $category_list, ', ' );
			}

			echo '<div class="grid-item-container col-lg-4 '.$last.'">';
				echo '<a href="'.get_the_permalink().'">';
					echo '<div class="grid-item featured-post" style="background: url('.$image.');">';
							echo '<div class="overlay"></div>';
					echo '</div>';
					echo '<div class="outer">';
						echo '<p class="category">'.$category_list.'</p>';
						echo '<h2>'.wp_trim_words(get_the_title(), 8, '...' ).'</h2>';
					echo '</div>';
				echo '</a>';
			echo '</div>';	
			$count++;
		endwhile;

	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
add_action('wp_ajax_loadmore', 'mp_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'mp_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

/**
 * Volusion import
 */
require get_theme_file_path( '/volusion/init.php' );

/**
 * Custom Blocks Register
 * - Hover Card Blocks
 * - Post Slider Blocks
 * - MP Quotes
 * - Category Product Loop
 * - Service Cards
 * - Hover Gallery
 * - Detail Gallery
 */
add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
    register_block_type( __DIR__ . '/blocks/hover-card' );

		register_block_type( __DIR__ . '/blocks/post-slider' );

		register_block_type( __DIR__ . '/blocks/mp-quote' );

		register_block_type( __DIR__ . '/blocks/product-loop' );

		register_block_type( __DIR__ . '/blocks/service-cards' );

		register_block_type( __DIR__ . '/blocks/hover-gallery' );

		register_block_type( __DIR__ . '/blocks/detail-gallery' );

    register_block_type( __DIR__ . '/blocks/slick-carousel' );

    register_block_type( __DIR__ . '/blocks/video-modal' );
}



/**
 * Footer Top Widget Area
 */
function register_custom_widget_area() {
	register_sidebar(
	array(
	'id' => 'footer-top-widget-area',
	'name' => esc_html__( 'Footer Top', 'theme-domain' ),
	'description' => esc_html__( 'Above footer widget area', 'theme-domain' ),
	'before_widget' => '<div id="%1$s" class="footerTop-widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
	'after_title' => '</h3></div>'
	)
	);
	}
	add_action( 'widgets_init', 'register_custom_widget_area' );


	/**
 * Generate breadcrumbs
 */
function dimox_breadcrumbs() {

	/* === OPTIONS === */
	$text['home']     = 'Home'; // text for the 'Home' link
	$text['category'] = '%s'; // text for a category page
	$text['search']   = 'Search Results for "%s" Query'; // text for a search results page
	$text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
	$text['author']   = 'Articles Posted by %s'; // text for an author page
	$text['404']      = 'Error 404'; // text for the 404 page

	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter      = ' &nbsp;&nbsp;&#62;&nbsp;&nbsp; '; // delimiter between crumbs
	$before         = '<span class="current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$home_link    = home_url('/');
	$link_before  = '<span typeof="v:Breadcrumb">';
	$link_after   = '</span>';
	$link_attr    = ' rel="v:url" property="v:title"';
	$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$parent_id    = $parent_id_2 = $post->post_parent;
	$frontpage_id = get_option('page_on_front');
	$blogUrl = get_permalink( get_option( 'page_for_posts' ) );

	if (is_front_page()) {

		if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
		if ($show_home_link == 1) {
			echo '<a class="home" href="' . $home_link . '" rel="v:url" property="v:title"></a>';
			if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
		}

		if (is_home()) {			
			echo '<a href="' . $blogUrl . '">Blog</a>';			
		}

		if ( is_category() ) {
			$this_cat = get_category(get_query_var('cat'), false);
			if ($this_cat->parent != 0) {
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			if ($show_current == 1) echo '<a href="' . $blogUrl . '">Blog</a>' . $delimiter . $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo '<a href="' . $blogUrl . '">Blog</a>'. $delimiter .$cats;
				if ($show_current == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $parent_id ) {
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
			}
			if ($show_current == 1) {
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
				echo $before . get_the_title() . $after;
			}

		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div><!-- .breadcrumbs -->';

	}
} 

