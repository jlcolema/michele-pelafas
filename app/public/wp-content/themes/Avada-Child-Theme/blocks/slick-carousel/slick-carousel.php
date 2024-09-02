<?php
/**
 * Custom Slider Block Template.
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
$class_name = 'carousel-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$slides   = get_field('slides');
$slides3  = get_field('show_3_slides');
?>

<?php if( $slides ): ?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
  
  <div class="slides-container">
    <?php foreach( $slides as $slide) : 
      $image  = $slide['slide_image'];   
      $heading  = $slide['slide_heading'];
      $sub_heading  = $slide['slide_subheading'];
    ?>    
    <div class="slide-container" style="background-image: url(<?php echo $image; ?>);">    
      <?php if( $slides3 ): ?>
        <div class="slide-overlay"></div>
      <?php endif; ?>
      <div class="slide-inner">
        <div class="slide-heading heading-lg"><?php echo $heading; ?></div>
        <?php if( $slides3 ): ?>
          <div class="slide-subheading threeSlides"><?php echo $sub_heading; ?></div>
        <?php else: ?>
          <div class="slide-subheading"><?php echo $sub_heading; ?></div>
        <?php endif; ?>
      </div>
    </div>  
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<?php if( $slides3 ): ?>
  <script>
  let waitjQuery = setInterval(() => {
    const slides = document.querySelectorAll('.slide-container');
    if (jQuery && slides.length > 1) {
      clearInterval(waitjQuery);      
      jQuery('.slides-container').slick({
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
<?php else: ?>
<script>
  let waitjQuery = setInterval(() => {
    const slides = document.querySelectorAll('.slide-container');
    if (jQuery && slides.length > 1) {
      clearInterval(waitjQuery);      
      jQuery('.slides-container').slick({
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        speed: 600,
        centerPadding: '20px',
        infinite: true,
        fade: true,
        autoplay: true,
        cssEase: 'linear'
      });
    }
  }, 300);  
</script>
<?php endif; ?>