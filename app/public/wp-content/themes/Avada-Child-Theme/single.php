<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php 
	$currentID = get_the_ID();
	get_header();

	$featuerd_image = get_the_post_thumbnail_url( $currentID, 'large' );
	$post_id = get_the_ID(); // or use the post id if you already have it
  $category_object = get_the_category($post_id);
  $category_name = $category_object[0]->name;
?>

<div class='postHeading-block' style='background-color: #F5DEDA;'>
	<div class='postHeading-inner center' style ='color: #cba666;'>
	  <span class='heading-sm-gold postHeading-category'><?php echo $category_name ?></span>
		<h1 class='postHeading-headline'><?php the_title(); ?></h1>
		<div class='postHeading-subheading'><?php the_time('F j, Y') ?> | <?php echo get_the_author(); ?></div>
	</div>
</div>
<div class="breadcrumb"><?php dimox_breadcrumbs() ?></div>
<div class="blogContent">
	<?php 

	while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
			<div class="post-content">
				<?php the_content(); ?>

				<?php 
					$tag_list = get_the_tag_list( '', ', ', '', $id );
					if ($tag_list) {
						?>
						<div class="narrow-container">
							<div class="blog-tags">
								<div class="line"></div>
								<h2>TAGS:</h2>
								<?php echo $tag_list; ?>
								<div class="line"></div>
							</div>
						</div>
						<?php
					}
				?>
				<div class="returnLink">
				<a href="/beauty-design-tips-trends/">RETURN TO BLOG LISTINGS</a>
				</div>
			</div>
			<?php
				$heading     = get_field('heading');
				$buttonTxt   = get_field('button_text');
				$buttonLink  = get_field('link');
				$bgColor     = get_field('background_color');				
			?>
			<div class="is-layout-flex wp-container-7 wp-block-columns blackShadow has-background postClosing" style="background-color: <?php echo $bgColor; ?>;">
				<div class="is-layout-flow wp-block-column quoteContent">
					<div class="mpQuote-block">
						<div class="mpQuote-inner">
							<h2 class="mpQuote-text" style="color: #ffffff;"><?php echo $heading; ?></h2>
							<div class="mpQuote-author secondaryButton wider" style="color: #ffffff;"><a href="<?php echo $buttonLink; ?>" class="wp-block-button__link wp-element-button" style="border-radius:0px"><?php echo $buttonTxt; ?></a></div>
						</div>
				  </div>
			  </div>
			</div>
		</article>
	<?php endwhile; ?>
	<?php wp_reset_query(); ?>
</div>



	<div class="blog-related bodyContentSlim">
		<div class="blog-related-heading">
		  <span class="heading-sm-gold">MICHELE PELAFAS INSIDE BEAUTY BLOG</span>
		  <h2 class="center">Related Blog Posts</h2>
		</div>
		<?php
			global $post;
			$related_posts = new WP_Query();
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'post__not_in' => array($currentID)
			);
			$related_posts->query($args);
			echo '<div class="postItems-container">';
				$count = 1;
				while ($related_posts->have_posts()) : $related_posts->the_post(); 
					$id = get_the_ID();
					$image = get_the_post_thumbnail_url( $id, 'large' );
					$category_list = " ";
					$categories = get_the_category();
					$category_object = get_the_category($id);
			    $category_name = $category_object[0]->name;
					$link = get_the_permalink();
					$cat_link = get_category_link($category_object[0]->cat_ID);
					$title = get_the_title();
					$time = get_the_time('M jS, Y');
					if ($categories) {
						foreach ($categories as $category) {
						 	$category_list .= $category->name. ', ';
						}
						$category_list = rtrim( $category_list, ', ' );
					}
					$last = '';
					if ($count === 3) {
						$last = 'last';
					}

					echo '<div class="postItem">';
            echo '<div class="postItem-image">';					    
					    echo '<a href="'.$link.'"><img src="'.$image.'" /></a>';
				    echo '</div>';
            echo '<div class="postItem-small">';
              echo '<a href="'.$cat_link.'">'.$category_name.'</a> - '.$time;							
            echo '</div>';
				    echo '<div class="postItem-title">';
						  echo '<a href="'.$link.'" rel="bookmark">'.$title.'</a>';
            echo '</div>';
         echo '</div>';

					$count++;	
				endwhile;
			echo '</div>';
		?>
	</div>
<?php //do_action( 'avada_after_content' ); ?>
<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
