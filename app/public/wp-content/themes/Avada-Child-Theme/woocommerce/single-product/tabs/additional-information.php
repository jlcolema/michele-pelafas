<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce, $product, $post;

$heading = esc_html( apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional information', 'woocommerce' ) ) );

	if ($product->get_sku()) {
		?>
		<table class="shop_attributes">
			<tbody>
				<tr>
					<th>Product Code</th>
					<td class="product_weight"><?php echo $product->get_sku();?></td>
				</tr>
			</tbody>
		</table>
		<?php
	}

?>

<?php do_action( 'woocommerce_product_additional_information', $product ); ?>
