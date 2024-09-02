<?php
/**
 * Post Slider Block Template.
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
$class_name = 'hoverCard-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$posts             = get_field( 'posts' );


?>
<div class="post-slider">
  <?php foreach( $posts as $post_object): ?>
    <?php 
      $post_thumbnail_id = get_post_thumbnail_id( $post_object );
      $thumbnail_url = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );
      $title = get_the_title( $post_object );
      ?>
      <a href="<?php echo get_permalink($post_object->ID); ?>">
          <div class="post-image" style="background-image: url(<?php echo $thumbnail_url ?>);"><span><?php echo $title ?></span></div>
      </a>
  <?php endforeach; ?>
</div>

<script>
  let waitjForQuery = setInterval(() => {
    const slides = document.querySelectorAll('.post-slider a');
    if (jQuery && slides.length > 3) {
      clearInterval(waitjForQuery);      
      jQuery('.post-slider').slick({
        centerMode: true,
        centerPadding: '30px',
        slidesToShow: 3,
        responsive: [
          {
            breakpoint: 1280,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 2
            }
          },
          {
            breakpoint: 800,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });
    }
  }, 300);  
</script>