<?php
/**
 * Archives template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php 
	get_header();
	$category = get_queried_object();
?>
<div class="post-content">
	<div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:60px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
		<div class="fusion-builder-row fusion-row ">
			<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last 1_1" style="margin-top:0px;margin-bottom:0px;">
				<div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
					<div class="page-intro">
						<span class="page-title">Inside Beauty</span>
						<h1 data-fontsize="72" data-lineheight="72"><?php echo $category->name;?></h1>
					</div>
					<div class="fusion-clearfix"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-right:0px;padding-left:0px;">
		<div class="fusion-builder-row fusion-row ">
			<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last 1_1" style="margin-top:0px;margin-bottom:0px;">
				<div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
					<div class="fusion-text">
						<p style="text-align: center;">
							<em><?php echo $category->description;?></em>
						</p>
					</div>
					<div class="fusion-clearfix"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:60px;padding-right:0px;padding-bottom:60px;padding-left:0px;">
		<div class="fusion-builder-row fusion-row ">
			<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last 1_1" style="margin-top:0px;margin-bottom:0px;">
				<div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
					<div class="blog-categories style-2">
						<div class="col-lg-3">
							<a class="<?php if($category->slug === 'learn-grow'){echo 'active';}?>" href="/category/learn-grow/"><p class="category">Learn + Grow</p></a>
						</div>
						<div class="col-lg-3">
							<a class="<?php if($category->slug === 'destination-beauty'){echo 'active';}?>" href="/category/destination-beauty/"><p class="category">Where to Go</p></a></a>
						</div>
						<div class="col-lg-3">
							<a class="<?php if($category->slug === 'interiors'){echo 'active';}?>" href="/category/interiors/"><p class="category">Be Inspired</p></a>
						</div>
						<div class="col-lg-3 last">
							<a class="<?php if($category->slug === 'xo-michele'){echo 'active';}?>" href="/category/xo-michele/"><p class="category">XO Michele TEST</p></a>
						</div>
					</div>
					<div class="fusion-clearfix"></div>
				</div>
			</div>
		</div>
	</div>


</div>

<section id="content" <?php Avada()->layout->add_class( 'content_class' ); ?> <?php Avada()->layout->add_style( 'content_style' ); ?>>
	<?php 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	//Set posts per page variable used for query, and also later for the ajax request on the button
	$posts_per_page = 9;

	//Main Archive Query
	$wp_query = new WP_Query();
	$args = array(
		'post_type'       => 'post',
		'posts_per_page'  => $posts_per_page,
		'cat'             => $category->term_id,
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
			wp_reset_postdata();
		echo '</div>';

		//Used for ajax load more
		//Check how many posts we have for this category to determine if we need to show more, add category paramter for ajax
		$category = get_queried_object();
		$total_archive_wp_query = new WP_Query();
		$args = array(
			'post_type'       => 'post',
			'posts_per_page'  => -1,
			'cat'             => $category->term_id,
			'orderby'         => 'date',
			'post_status'     => 'publish'
		);	
		$total_archive_wp_query->query($args);
		$postCount = $total_archive_wp_query->post_count;

	    $page_number_max = ceil($postCount / $posts_per_page);

	    if ($page_number_max > 1) {
	    	echo '<div class="col-lg-12 center"><a href="#" class="mp-load-more btn small" data-maxpages="'.$page_number_max.'" data-ppp="'.$posts_per_page.'" data-postnotin="'.$postsNotInIds.'" data-cat="'.$category->term_id.'">Load More</a></div>';
	    }
	?>
</section>
<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
