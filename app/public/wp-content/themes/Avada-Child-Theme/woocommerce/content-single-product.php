<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

	<div class="site-width">
		<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="summary entry-summary">
			<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				//do_action( 'woocommerce_single_product_summary' );
			?>
      <div class="summary-container">
      <?php 
      woocommerce_template_single_title(); 
      woocommerce_template_single_price();
      woocommerce_template_single_add_to_cart();
      woocommerce_template_single_meta();
      ?>
      </div>
		</div>




<div class="fusion-clearfix"></div>

<?php $nofollow = ( Avada()->settings->get( 'nofollow_social_links' ) ) ? ' rel="noopener noreferrer nofollow"' : ' rel="noopener noreferrer"'; ?>

<?php if ( Avada()->settings->get( 'woocommerce_social_links' ) ) : ?>

	<?php $facebook_url = 'https://m.facebook.com/sharer.php?u=' . get_permalink(); ?>
	<?php if ( ! avada_jetpack_is_mobile() ) : ?>
		<?php $facebook_url = 'http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;=' . get_permalink() . '&p&#91;title&#93;=' . the_title_attribute( array( 'echo' => false ) ); ?>
	<?php endif; ?>

	<ul class="social-share clearfix">
		<li class="facebook">
			<a href="<?php echo esc_url_raw( $facebook_url ); ?>" target="_blank"<?php echo $nofollow; // WPCS: XSS ok. ?>>
				<i class="fontawesome-icon medium circle-yes fusion-icon-facebook"></i>
				<div class="fusion-woo-social-share-text">
					<span><?php esc_attr_e( 'Share On Facebook', 'Avada' ); ?></span>
				</div>
			</a>
		</li>
		<li class="twitter">
			<a href="https://twitter.com/share?text=<?php the_title_attribute(); // WPCS: XSS ok. ?>&amp;url=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank"<?php echo $nofollow; // WPCS: XSS ok. ?>>
				<i class="fontawesome-icon medium circle-yes fusion-icon-twitter"></i>
				<div class="fusion-woo-social-share-text">
					<span><?php esc_attr_e( 'Tweet This Product', 'Avada' ); ?></span>
				</div>
			</a>
		</li>
		<li class="pinterest">
			<?php $full_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo rawurlencode( get_permalink() ); ?>&amp;description=<?php echo rawurlencode( the_title_attribute( array( 'echo' => false ) ) ); ?>&amp;media=<?php echo rawurlencode( $full_image[0] ); ?>" target="_blank"<?php echo $nofollow; // WPCS: XSS ok. ?>>
				<i class="fontawesome-icon medium circle-yes fusion-icon-pinterest"></i>
				<div class="fusion-woo-social-share-text">
					<span><?php esc_attr_e( 'Pin This Product', 'Avada' ); ?></span>
				</div>
			</a>
		</li>
		<li class="email">
			<a href="mailto:?subject=<?php echo rawurlencode( html_entity_decode( the_title_attribute( array( 'echo' => false ) ), ENT_COMPAT, 'UTF-8' ) ); ?>&body=<?php echo esc_url_raw( get_permalink() ); ?>" target="_blank"<?php echo $nofollow; // WPCS: XSS ok. ?>>
				<i class="fontawesome-icon medium circle-yes fusion-icon-mail"></i>
				<div class="fusion-woo-social-share-text">
					<span><?php echo esc_attr_e( 'Mail This Product', 'Avada' ); ?></span>
				</div>
			</a>
		</li>
	</ul>
	<?php
endif;?>




	</div>

	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
