<?php
/**
 * Category Product Loop Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'productLoop-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$prodCat   = get_field( 'category' );
$prodName = $prodCat->slug;
?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
  <div class="productLoop-inner collectionContainer">
  <ul class="productsLoop">
    <?php
    if ( get_query_var('paged') ) {
      $paged = get_query_var('paged');
    } elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'product_cat' => $prodName,
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'paged' => $paged,
        'orderby' => 'acend'
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        global $product; ?>
            <li class="productLoop">
              <div class="productLoop-content">
                <a href="<?php echo get_permalink($loop->post->ID) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                    <?php //woocommerce_show_product_sale_flash($post, $product); ?>

                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' ); ?>

                    <?php
                    if (! $image) {
                      echo '<div class="productLoop-image">';
                      echo wc_placeholder_img();
                      echo '</div>';
                      
                    } else {
                      echo '<div class="productLoop-image">';
                      echo '<img class="prodImgOne" src="'.$image[0].'" data-id="'.$loop->post->ID.'">';
                      echo '</div>';
                    }
                    ?>

                </a>
                <a href="<?php echo get_permalink($loop->post->ID) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                  <span class="productTitle"><?php the_title(); ?></span>
                </a>
                <div class="productLoop-prices">
                  <span class="price"><?php echo $product->get_price_html(); ?></span>
                  <?php woocommerce_template_loop_add_to_cart($loop->post, $product); ?>
                </div>
              </div>  
            </li>
    <?php endwhile; ?>
    </ul>
    <?php if ($loop->max_num_pages > 1) : // custom pagination  ?>
      <nav class="woocommerce-pagination">
                <?php
                  $orig_query = $wp_query; // fix for pagination to work
                  $wp_query = $loop;
                  $big = 999999999;
                  echo paginate_links(array(
                      'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                      'format' => '?paged=%#%',
                      'current' => max(1, get_query_var('paged')),
                      'total' => $wp_query->max_num_pages,
                      'prev_text'    => 'Previous',
                      'next_text'    => 'Next'
                  ));                  
                  $wp_query = $orig_query; // fix for pagination to work
                ?>
                </nav>
              <?php endif; ?>
    <?php wp_reset_query(); ?>

  </div>
</div>