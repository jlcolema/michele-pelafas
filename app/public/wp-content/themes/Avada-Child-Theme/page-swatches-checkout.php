<?php
/**
 * Template Name: Swatches Checkout
 * A template for ordering swatches
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

get_header();
?>

<div id="content" class="full-width post-content">
    <div class="row">
        <div class="col-lg-9">
        <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;

            $swatch_ids = $_COOKIE['mp-swatches-cart'];
            $swatch_id_array = explode(',', $swatch_ids);

            if ($swatch_ids) :
                $args = array(
                    'post_type' => 'swatches',
                    'post__in' => $swatch_id_array
                );
                $wp_query = new WP_Query($args);

                if($wp_query->have_posts()) : ?>
                    <div class="cart-items" style="display:none;"><?php
                        while ($wp_query->have_posts()) :
                            $wp_query->the_post();
                            echo get_the_title() . "\r\n";
                        endwhile;
                    ?></div>
                <?php
                endif;
            endif;

            echo do_shortcode( '[contact-form-7 id="6033" title="Swatch Order Form"]' );
            ?>
        </div>
        <div class="col-lg-3 swatch-cart">
            <div class="swatch-cart-wrapper">
                <?php 
                    if($wp_query->have_posts()) :
                        ?>
                        <h3>Order Details</h3>
                        <div class="selected-swatches">
                        <?php
                        while ($wp_query->have_posts()) :
                            $wp_query->the_post();
                            $id = get_the_ID();
                            $image = get_the_post_thumbnail_url( $id, 'large' );
                            echo '<div class="swatch"><img src="'.$image.'"/><p>'.get_the_title().'</p></div>';
                        endwhile;
                        //echo '<a href="/swatches" class="btn medium">Back To Swatches</a>';
                    endif;
                ?>
                </div>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	var swatches = $('.cart-items').html();
	$('#swatches').val(swatches);
});
</script>

<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
