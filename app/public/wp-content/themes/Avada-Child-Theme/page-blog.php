<?php
/**
 * Template Name: Blog
 * A template for the main blog
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php 
	get_header();
?>
<div id="content" class="full-width post-content">
	<?php 
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;

	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	//Set posts per page variable used for query, and also later for the ajax request on the button
	$posts_per_page = 9;
	//Main Blog Query
	$wp_query = new WP_Query();
	$args = array(
		'post_type'       => 'post',
		'posts_per_page'  => $posts_per_page,
		'orderby'         => 'date',
		'post_status'     => 'publish',
		'paged'           => $paged
	);	
	$wp_query->query($args);
	$postCount = $wp_query->post_count;

		echo '<div class="grid-items featured-blog">';
			$count = 1;
			while ($wp_query->have_posts()) : $wp_query->the_post();
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
						if ($category->name != 'Featured') {
							$category_list .= $category->name. ', ';
						}
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
		echo '</div>';

		//Used for ajax load more
	    $published_posts = wp_count_posts()->publish;
	    $page_number_max = ceil($published_posts / $posts_per_page);
	    if ($page_number_max > 1) {
	    	echo '<div class="col-lg-12 center"><a href="#" class="mp-load-more btn small" data-maxpages="'.$page_number_max.'" data-ppp="'.$posts_per_page.'" data-postnotin="'.$postsNotInIds.'">Load More</a></div>';
	    }

	?>
</div>


<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
