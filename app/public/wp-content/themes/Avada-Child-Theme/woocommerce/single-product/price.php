<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<p class="price">
	<?php
  $list_price = $product->get_regular_price();
  $sale_price = $product->get_sale_price();
  $sale_price_num = floatval($sale_price);
  $list_price_num = floatval($list_price);

  // Calculate the difference between the prices
  $savings = $list_price_num - $sale_price_num;
  $formatted_savings = number_format($savings, 2, '.', ',');

  if ($product->is_on_sale()) {
    // Product is on sale
    echo '<span class="price-list">List Price: '.wc_price($list_price).'</span>';
		echo '<span class="price-sale">Your Price: <strong>'.wc_price($sale_price).'</strong></span>';
    echo '<span class="price-savings">Savings: $'.$formatted_savings.'</span>';    
  } else {
      // Product is not on sale
      echo '<span class="price-sale">'.wc_price($list_price).'</span>';
  }
  
	?>
</p>