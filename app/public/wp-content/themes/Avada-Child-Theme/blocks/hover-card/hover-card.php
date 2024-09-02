<?php
/**
 * Hover Card Block Template.
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
$image             = get_field( 'image' ) ?: '#';
$imageHeight      = get_field( 'image_height' ) ?: '363';
$title             = get_field( 'title' );
$caption           = get_field( 'caption' );
$link              = get_field( 'link_url' ) ?: '#';
$linkTxt           = get_field( 'link_text' );
$background_color  = get_field( 'overlay_color' );
$slide           = get_field( 'hover_slide' ) ?: 'noslide';

// Build a valid style attribute for background and text colors.
$styles = array( 'background-color: ' . $background_color);
$style  = implode( '; ', $styles );

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
  <div class="hoverCard <?php echo esc_attr( $slide ); ?>" style="height:<?php echo esc_html( $imageHeight ); ?>px;">
    <div class="hoverCard-topOverlay"></div>
    <div class="hoverCard-inner" style="background-image: url('<?php echo esc_html( $image ); ?>'); height:<?php echo esc_html( $imageHeight ); ?>px;">
      <div class="hoverCard-title"> <?php echo esc_html( $title ); ?> </div>
      <div class="hoverCard-content">
        <span class="hoverCard-caption"><?php echo  $caption; ?></span>
        <span class="hoverCard-link">
          <a href="<?php echo esc_html( $link ); ?>"><?php echo esc_html( $linkTxt ); ?><span>&xrarr;</span></a>
        </span>
      </div>      
    </div>
  </div>
  <div class="hoverCard-overlay" style="<?php echo esc_html( $style ); ?>"></div>
</div>