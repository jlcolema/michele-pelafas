<?php
/**
 * Template Name: Category
 * A full-width Category template.
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
		<h1 class='categoryHeading-headline'><?php single_cat_title(); ?></h1>
		<span class='categoryHeading-subheading'>	<?php echo category_description(); ?></span>
	</div>
</div>
<?php $category = get_queried_object(); ?>
<div class='collectionRow'>
  <div class='collectionRow-inner'>
    <ul class='collectionRow-list'>
		  <li><a class="collectionRow-link <?php if(is_home()){echo 'active';}?>" href="/beauty-design-tips-trends/">Show All</a></li></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'learn-grow'){echo 'active';}?>" href="/category/learn-grow/">Beauty Biz</a></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'home-design'){echo 'active';}?>" href="/category/home-design/">Home Design</a></li>
			<li><a class="collectionRow-link <?php if($category->slug === 'destination-beauty'){echo 'active';}?>" href="/category/destination-beauty/">Destination Beauty</a></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'xo-michele'){echo 'active';}?>" href="/category/xo-michele/">XO Michele</a></li>
      <li><a class="collectionRow-link <?php if($category->slug === 'interiors'){echo 'active';}?>" href="/category/interiors/">Be Inspired</a></li>			
    </ul>
  </div>
</div>

<div class="breadcrumb"><?php dimox_breadcrumbs() ?></div>

<section id="content" class="full-width">

	<div class="bodyContentSlim">
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
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</div>
			</div>

			<?php endwhile;?> 
		</div>
		<?php // Get the pagination. ?>
    <?php echo fusion_pagination( '', Avada()->settings->get( 'pagination_range' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>
<?php get_footer(); ?>


