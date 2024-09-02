<?php
/**
 * Template Name: Blog Layout
 * A full-width Blog template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>
<div class='categoryHeading-block' style='background-color: #F5DEDA;'>
	<div class='categoryHeading-inner' style ='color: #cba666;'>
		<h1 class='categoryHeading-headline'>IN THE NEWS</h1>
		<span class='categoryHeading-subheading'>MICHELE PELAFAS</span>
	</div>
</div>
<?php $category = get_queried_object(); ?>
<div class='collectionRow'>
  
  <div class='collectionRow-inner'>
    <!--<ul class='collectionRow-list'>
		  <li><a class="collectionRow-link <?php if(is_home()){echo 'active';}?>" href="/news/">Show All</a></li></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'hair-salon-design'){echo 'active';}?>" href="category/hair-salon-design/">Hair Salon Design</a></li>
			<li><a class="collectionRow-link <?php if($category->slug === 'inside-beauty-membership'){echo 'active';}?>" href="category/inside-beauty-membership/">Inside Beauty Membership</a></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'interior-design'){echo 'active';}?>" href="category/interior-design/">Interior Design</a></li>
    </ul>-->
  </div>
  
</div>

<div class="breadcrumb"><?php dimox_breadcrumbs() ?></div>

<section id="content" class="full-width">

	<div class="bodyContentSlim top-20">

	<div class='blogListingHeading-block'>
		<div class='blogListingHeading-inner'>
			<span class='heading-sm-gold blogListing-smallHeading'></span>
			<h2 class='blogListing-largeHeading'>PRESS</h2>
			<p class='blogListing-textBody'></p>
		</div>
	</div>
		

		<div class="postItems-container">
		
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			
			<?php 
			$post_id = get_the_ID(); // or use the post id if you already have it
			$category_object = get_the_category($post_id);
			$category_name = $category_object[0]->name;

			?>

			<div class="postItem">
				<div class="postItem-image">
					<?php $imgUrl = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
					<a href="<?php the_permalink() ?>"><img src="<?php echo $imgUrl ?>" /></a>
				</div>
				<div class="postItem-small">
					<a href="<?php echo get_category_link($category_object[0]->cat_ID); ?>"><?php echo $category_name ?></a> - <?php the_time('M jS, Y') ?> 
				</div>
				<div class="postItem-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
				</div>
			</div>

			<?php endwhile;?> 
		</div>
		<?php // Get the pagination. ?>
    <?php echo fusion_pagination( '', Avada()->settings->get( 'pagination_range' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
  <div class="blog-related bodyContentSlim top-100-15">
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
</section>
<?php get_footer(); ?>


