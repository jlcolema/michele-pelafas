<?php
/**
 * Template for the secondary header.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php

$content_1 = avada_secondary_header_content( 'header_left_content' );
$content_2 = avada_secondary_header_content( 'header_right_content' );
?>

<div class="fusion-secondary-header">
	<div class="fusion-row">
		<?php if ( $content_1 ) : ?>
			<div class="fusion-alignleft">
				<?php echo $content_1; // WPCS: XSS ok. ?>
			</div>
		<?php endif; ?>
		<?php if ( $content_2 ) : ?>
			<div class="fusion-alignright">
				<?php
					echo '<div class="menu-search"><ul><li class="search"><form role="search" method="get" id="searchform" action="'.home_url( '/' ).'"><input type="search" placeholder="search" name="s" id="s" /><input type="submit" id="searchsubmit" value="'. __('Search') .'" /></form></li></ul></div>';
					
					$cart_contents_count = WC()->cart->get_cart_contents_count();
					echo '<div class="menu-cart fusion-secondary-menu"><ul><li><a href="/cart/"><span class="menu-text" aria-label="View Cart">BAG (' . $cart_contents_count . ')</span></a></li></ul></div>';
					//echo $content_2; // WPCS: XSS ok.

					echo '<div class="fusion-secondary-menu design-studio"><ul><li><a href="'.get_permalink( 6693 ).'">DESIGN STUDIO</a></li></ul></div>';
				?>
			</div>
		<?php endif; ?>
	</div>
</div>
