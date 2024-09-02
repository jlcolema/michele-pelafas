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
		<h1 class='categoryHeading-headline'>BEAUTY BY DESIGN</h1>
		<span class='categoryHeading-subheading'>KNOW BEAUTY, SEE BEAUTY, TOUCH BEAUTY, FEEL BEAUTY AND JUST BE IN BEAUTY.</span>
	</div>
</div>
<?php $category = get_queried_object(); ?>
<div class='collectionRow'>
  <div class='collectionRow-inner'>
    <ul class='collectionRow-list'>
		  <li><a class="collectionRow-link <?php if(is_home()){echo 'active';}?>" href="/news/">Show All</a></li></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'hair-salon-design'){echo 'active';}?>" href="/category/hair-salon-design/">Learn + Grow</a></li>
			<li><a class="collectionRow-link <?php if($category->slug === 'inside-beauty-membership'){echo 'active';}?>" href="/category/inside-beauty-membership/">Where to Go</a></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'interior-design'){echo 'active';}?>" href="/category/interior-design/">Be Inspired</a></li>
    </ul>
  </div>
</div>

<div class="breadcrumb"><?php dimox_breadcrumbs() ?></div>

<section id="content" class="full-width">

	<div class="bodyContentSlim top-20">

	<div class='blogListingHeading-block'>
		<div class='blogListingHeading-inner'>
			<span class='heading-sm-gold blogListing-smallHeading'>PRESS</span>
			<h2 class='blogListing-largeHeading'>MICHELE PELAFAS</h2>
			<p class='blogListing-textBody'>IN THE NEWS</p>
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
</section>
<?php get_footer(); ?>


