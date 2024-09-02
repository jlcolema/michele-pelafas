<?php
/**
 * MP Video Modal Block Template.
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
$class_name = 'video-modal-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$video      = get_field( 'video' );
$text       = get_field( 'text' );
$image      = get_field( 'image' );

?>

<?php if( $video ): ?>
  
  <div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
    <div class="video-preview-image" style="background: url(<?php echo $image ?>)">
      <div class="video-preview-text"><?php echo $text ?></div>
    </div>  
    <div class="video-modal">
      <button title="Close (Esc)" type="button" class="mfp-close video-modal-close">×</button>
      <div class="video-modal-iframe">
      <iframe class="mfp-iframe" src="<?php echo $video ?>?autoplay=1" frameborder="0" allowfullscreen=""></iframe>
      </div>  
    </div>  
  </div>
<script>
  const overlay = document.querySelector('.video-overlay');
  const modal = document.querySelector('.video-modal');
  const close = document.querySelector('.video-modal-close');
  const trigger = document.querySelector('.video-preview-image');
  trigger.addEventListener('click', event => {
    [overlay, modal].forEach(elm => {
      elm.classList.add('open');
    });
  });
  overlay.addEventListener('click', event => {
    [overlay, modal].forEach(elm => {
      elm.classList.remove('open');
    });
  });
  close.addEventListener('click', event => {
    [overlay, modal].forEach(elm => {
      elm.classList.remove('open');
    });
  });
</script>
<?php endif; ?>