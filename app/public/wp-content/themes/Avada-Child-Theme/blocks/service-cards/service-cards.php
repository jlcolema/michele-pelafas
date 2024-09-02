<?php
/**
 * Service Cards Block Template.
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
$class_name = 'serviceCards-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$cards = get_field('card', $id);


?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
<?php foreach( $cards as $card) : ?>
  <div class="serviceCard ">
    <a href="<?php echo esc_html( $card['card_link'] ); ?>" class="serviceCard-link">
      <div class="serviceCard-image" style="background-image: url('<?php echo esc_html( $card['card_image'] ); ?>');"></div>
      <div class="serviceCard-title"><?php echo esc_html( $card['card_title'] ); ?></div>
    </a>
  </div>
<?php endforeach; ?>
</div>

