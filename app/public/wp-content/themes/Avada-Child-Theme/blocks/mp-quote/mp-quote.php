<?php
/**
 * MP Quote Block Template.
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
$class_name = 'mpQuote-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$text           = get_field( 'quote' );
$author         = get_field( 'author' );
$textColor      = get_field( 'quote_color' );
$authorColor    = get_field( 'author_color' );

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
  <div class="mpQuote-inner">
    <div class="mpQuote-text" style="color: <?php echo $textColor ?>;"><?php echo esc_html( $text ); ?></div>
    <div class="mpQuote-author" style="color: <?php echo $authorColor ?>;"><?php echo esc_html( $author ); ?></div>
  </div>
</div>