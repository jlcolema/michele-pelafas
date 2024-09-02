<?php
/**
 * Template Name: Swatches
 * A template for ordering swatches
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

get_header();
?>

<div id="content" class="full-width post-content">
    <?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>
    <div class="row">
        <div class="col-lg-9">
            <?php
            $swatch_terms = get_terms('swatches_type', array(
                'hide_empty' => true
            ));

            // If there are no swatches do not show swatch content
            if( $swatch_terms ) : ?>

                <div class="swatch-filters">
                    <div class="styled-select">
                        <select class="color-filter">
                            <option value="">Filter by Color</option>
                            <?php
                            // Colors
                            $field = get_field_object('field_5c4919433308f');
                            if( $field['choices'] ) : ?>
                                <?php foreach( $field['choices'] as $value => $label ) : ?>
                                    <option value="<?= strtolower( $value ); ?>"><?= $label; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                        <div class="swatch-filters select-arrow"><span class="fa fa-chevron-down"></span></div>
                    </div>

                    <div class="styled-select">
                        <select class="type-filter">
                            <option value="">Filter by Pattern</option>
                            <?php
                            // Terms
                            foreach( $swatch_terms as $swatch_term ) : ?>
                                <option value="<?= $swatch_term->slug; ?>"><?= $swatch_term->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="swatch-filters select-arrow "><span class="fa fa-chevron-down"></span></div>
                    </div>
                </div>

                <?php
                foreach( $swatch_terms as $swatch_term ) :
                    $args = array(
                        'post_type'      => 'swatches',
                        'posts_per_page' => -1,
                        'fields'         => 'ids',
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'swatches_type',
                                'field'    => 'term_id',
                                'terms'    => $swatch_term->term_taxonomy_id,
                            )
                        )
                     );

                     $wp_query = new WP_Query( $args );
                     if( $wp_query->have_posts() ) : ?>
                        <div class="grid-items swatches <?= $swatch_term->slug; ?>">
                        <h2><?= $swatch_term->name; ?></h2>
                        <?php
                        $count = 1;
                        while( $wp_query->have_posts() ) :
                            $wp_query->the_post();
                            $id = get_the_ID();
                            $image = get_the_post_thumbnail_url( $id, 'large' );

                            $color_list = '';
                            $colors = get_field( 'color', $id );
                            foreach( $colors as $color ) {
                                $color_list .= ' ' . strtolower( $color );
                            }

                            $title = get_the_title();
                            ?>

                            <div class="swatch swatch-<?= $id; ?> grid-item-container col-lg-3 <?= $swatch_term->slug . $color_list; ?>">
                                <div class="grid-item swatch-image" style="background: url('<?= $image; ?>');">
                                    <div class="overlay"></div>
                                </div>
                                <div class="outer">
                                    <p class="swatch-name"><?= $title ?>&nbsp;<a class="open-popup-link" href="#swatch-<?= $id; ?>-dialog"><span class="swatch-info fa fa-info-circle"></span></a></p>
                                </div>
                                <a href="#" class="btn medium add-swatch" data-swatchid="<?= $id; ?>" data-swatchtitle="<?= $title ?>" data-swatchimg="<?= $image; ?>">Add</a>
                                <div id="swatch-<?= $id; ?>-dialog" class="swatch-popup zoom-anim-dialog mfp-hide">
                                    <div class="swatch-image">
                                        <img src="<?= $image; ?>" alt="<?= $title ?>"/>
                                    </div>
                                    <div class="swatch-details">
                                        <h3><?= $title ?></h3>
                                        <p><?= get_field( 'description', $id ); ?></p>
                                        <a href="#" class="btn medium add-swatch" data-swatchid="<?= $id; ?>" data-swatchtitle="<?= $title ?>" data-swatchimg="<?= $image; ?>">Add</a>
                                        <p class="swatch-limit" style="display:none;">You have the maximum number of swatches in your cart</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count++;
                        endwhile; ?>
                        </div>
                     <?php endif;
                endforeach;
            endif;
        ?>
        </div>
        <div class="col-lg-3 swatch-cart">
            <div class="swatch-cart-wrapper">
                <h3>Your Swatches</h3>
                <p class="swatch-limit" style="display:none;">You have the maximum number of swatches in your cart</p>
                <div class="selected-swatches"></div>
                <form class="order-swatches" style="display:none;" action="/swatch-checkout/" method="post">
                    <input type="submit" class="btn medium btn-order-swatches" value="Order Swatches">
                </form>
                <p class="note">There are no swatches in your cart.</p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {

    var set_cookie = true;

    $('.swatch, .selected-swatches').on('click', function(){ 
        checkQuantity();
    });
    $('.swatch').on('click', '.swatch-image', function(e) {
        e.preventDefault();
        $(this).parent('.swatch').find('a.btn').trigger('click');
    });
    $('.swatch, .swatch-details').on('click', '.add-swatch', function(e) {
        e.preventDefault();
        if($('.selected-swatches .swatch').length === 6) {
            // Show Reached Limit Message
            $('.swatch-limit').not(':visible').fadeIn().delay(3000).fadeOut();
        } else {
            var id = $(this).data('swatchid');
            var title = $(this).data('swatchtitle');
            var img = $(this).data('swatchimg');
            $('.selected-swatches').append('<div class="swatch" data-swatchid="' + id + '"><img src="' + img + '"/><p>' + title + '</p><span class="remove-selected fa fa-remove"</span></div>');
            $('p.note').text('Swatches are delivered free and will arrive in less than a week.');
            $('#swatch-'+ id +'-dialog, .swatch-' + id).addClass('added').find('a.btn.medium').removeClass('add-swatch').addClass('remove-swatch').text('Remove');
        }
    });
    $('.swatch, .swatch-details').on('click', '.remove-swatch', function(e) {
        e.preventDefault();
        var id = $(this).data('swatchid');

        $('.selected-swatches .swatch[data-swatchid=' + id + ']').remove();
        $('#swatch-'+ id +'-dialog, .swatch-' + id).removeClass('added').find('a.btn.medium').removeClass('remove-swatch').addClass('add-swatch').text('Add');
    });

    // Removing from cart
    $('.selected-swatches').on('click', '.remove-selected', function(e) {
        e.preventDefault();
        var id = $(this).parent('.swatch').data('swatchid');

        $(this).parent('.swatch').remove();
        $('#swatch-'+ id +'-dialog, .swatch-' + id).removeClass('added').find('a.btn.medium').removeClass('remove-swatch').addClass('add-swatch').text('Add');
    });

    // Sets cookie if necessary and shows empty cart message
    function checkQuantity() {
        if(set_cookie) {
            var selected_swatches = [];
            $('.selected-swatches .swatch').each(function() {
                var id = $(this).data('swatchid');
                selected_swatches.push(id);
            });
            Cookies.set('mp-swatches-cart', selected_swatches.join(','), { expires: 1 });
        }
        $('.order-swatches').show();
        if($('.selected-swatches .swatch').length === 0) {
            $('p.note').text('There are no swatches in your cart.');
            $('.order-swatches').hide();
        }
    }

    // Load cart from cookie if it exists
    var mp_swatches_cart = Cookies.get('mp-swatches-cart');
    //console.log(mp_swatches_cart);
    if(mp_swatches_cart) {
        var swatch_ids = mp_swatches_cart.split(',');
        if(swatch_ids) {
            set_cookie = false;
            //console.log(swatch_ids.length);
            for(var i = 0; i < swatch_ids.length; i++ ) {
                $('.swatches .swatch-' + swatch_ids[i] + ' .add-swatch')[0].click();
            }
            set_cookie = true;
        }
    }

    // If the filter is manually changed, filter the results
    $('.color-filter, .type-filter').change(function() {
        //console.log('Start filter');
        doFilter();

    // Trigger filters on page load, does filter on a page refresh
    }).trigger('change');

    // Handles the filtering of the results
    function doFilter() {
        //console.log('Filter Started');
        var color = $('.color-filter').val().toLowerCase();
        var type = $('.type-filter').val().toLowerCase();

        $('.swatches, .swatches .swatch').show();
        $('.swatches .swatch').each(function() {
            // Filter by color
            if(color !== '' && type === '') {
                if($(this).hasClass(color)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

            // Filter by Type
            } else if(color === '' && type !== '') {
                if($(this).hasClass(type)) {
                    $(this).parent('.swatches').show();
                } else {
                    $(this).parent('.swatches').hide();
                }

            // Filter by both
            } else if(color !== '' && type !== '') {
                if($(this).hasClass(color)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

                if($(this).hasClass(type)) {
                    $(this).parent('.swatches').show();
                } else {
                    $(this).parent('.swatches').hide();
                }
            }
        });
    }
});
</script>

<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
