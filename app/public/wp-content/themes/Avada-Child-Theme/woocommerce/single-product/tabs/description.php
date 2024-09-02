<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version	 2.0.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit; // Exit if accessed directly
 }

global $woocommerce, $product, $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', esc_html__( 'Description', 'woocommerce' ) ) );
?>

<div class="post-content">
	<?php the_content(); ?>
</div>
