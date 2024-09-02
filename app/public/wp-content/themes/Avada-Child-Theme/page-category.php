<?php
/**
 * Template Name: Page Category
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
