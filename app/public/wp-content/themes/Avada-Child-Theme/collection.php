<?php
/**
 * Template Name: Collection
 * A full-width Collection template.
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
<section id="content" class="full-width">

	<?php
	$class_name = 'categoryHeading-block';
	$headline     = get_field( 'heading' ) ?: 'Enter Headline Here...';
	$subhead      = get_field( 'sub_heading' ) ?: 'Enter SubHeading Here...';
	$background   = get_field( 'background_color' );
	$textColor    = get_field( 'text_color' );

	// Build a valid style attribute for background and text colors.
	$styles = array( 'background-color: ' . $background, 'color: ' . $textColor );
	$style  = implode( '; ', $styles );

	echo "<div class='$class_name' style='$style'>";
		echo "<div class='categoryHeading-inner'>";
			echo "<h1 class='categoryHeading-headline'>$headline</h1>";
			echo "<span class='categoryHeading-subheading'>$subhead</span>";
		echo "</div>";
	echo "</div>";
	?>

	<?php
		$parent = get_field('parent');
		$value = $parent[0];
		$current = get_the_ID();
		$args = array(
				'post_parent' => $value,
				'post_type' => 'page',
				'orderby' => 'menu_order'
		);
		
		$child_query = new WP_Query( $args );
		echo "<div class='collectionRow'>";
			echo "<div class='collectionRow-inner'>";
				echo "<ul class='collectionRow-list'>";
				if ( get_the_ID() === $value ) {
					echo '<li><a class="collectionRow-link active" href="'.get_permalink( $value ).'">'.get_the_title( $value ).'</a></li>';
				} else {
					echo '<li><a class="collectionRow-link" href="'.get_permalink( $value ).'">'.get_the_title( $value ).'</a></li>';
				}
  ?>
	
	<?php while ( $child_query->have_posts() ) : $child_query->the_post(); ?>
	<?php 
	  if ( get_the_ID() === $current ) {
      echo '<li><a class="collectionRow-link active" href="'.get_permalink().'">'.get_the_title().'</a></li>';
	  } else {
			echo '<li><a class="collectionRow-link" href="'.get_permalink().'">'.get_the_title().'</a></li>';
		}
	?>
	<?php endwhile; ?>
	  
	<?php
					echo '</ul>';  
				echo '</div>';
			echo '</div>';
		wp_reset_postdata();
	?>
	

	<div class="breadcrumb"><?php dimox_breadcrumbs() ?></div>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php echo fusion_render_rich_snippets_for_pages(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php avada_singular_featured_image(); ?>
			<div class="post-content category">
				<?php the_content(); ?>
				<?php fusion_link_pages(); ?>
			</div>
			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php if ( Avada()->settings->get( 'comments_pages' ) ) : ?>
					<?php comments_template(); ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</section>
<?php get_footer(); ?>
