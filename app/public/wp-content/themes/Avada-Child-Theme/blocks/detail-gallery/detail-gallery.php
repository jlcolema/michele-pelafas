<?php
/**
 * Detail Gallery Block Template.
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
$class_name = 'detailGallery-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$gallery = get_field('gallery');
$i   = 0;
$ii  = 0;
?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
  <div class="galleryMain-container">
    
    <?php foreach( $gallery as $item) : $i++ ?>
      <?php if ($i === 1) {
        echo '<div class="galleryContent-item active first" id="tab'.$i.'-content">
          <div class="galleryMain-image"><img src="'.$item['image'].'" /><div class="mainOverlay"><a href="'.$item['link'].'">'.$item['link_text'].'</a></div></div>          
          <div class="galleryMain-text">'.$item['text'].'</div>
          <div class="galleryMain-link"><a href="'.$item['link'].'">'.$item['link_text'].'</a></div>          
        </div>';
      } else {
        echo '<div class="galleryContent-item" id="tab'.$i.'-content">
          <div class="galleryMain-image"><img src="'.$item['image'].'" /><div class="mainOverlay"><a href="'.$item['link'].'">'.$item['link_text'].'</a></div></div>
          <div class="galleryMain-text">'.$item['text'].'</div>
          <div class="galleryMain-link"><a href="'.$item['link'].'">'.$item['link_text'].'</a></div>          
        </div>';
      } ?>
    <?php endforeach; ?>
    
  </div>
  <div class="galleryThumbs-container">
    <?php foreach( $gallery as $item) : $ii++ ?>
      <?php if ($ii === 1) {
        echo '<div class="galleryThumb-item active first" data-tab-content="tab'.$ii.'-content" data-tab-page="tab'.$ii.'-page">
          <div class="galleryThumb-image"><img src="'.$item['image'].'" /></div>
        </div>';
      } else {
        echo '<div class="galleryThumb-item" data-tab-content="tab'.$ii.'-content" data-tab-page="tab'.$ii.'-page">
          <div class="galleryThumb-image"><img src="'.$item['image'].'" /></div>
        </div>';
      } ?>
    <?php endforeach; ?>
  </div>
</div>

<script>
  //Tab Actions
  const allTabs = document.querySelectorAll('.galleryThumbs-container .galleryThumb-item');
  const allTabContents = document.querySelectorAll('.galleryMain-container .galleryContent-item');
  allTabs.forEach(tab => {
    tab.addEventListener('mouseover', event => {
      
      // Remove Active Classes
      allTabs.forEach(tab => tab.classList.remove('active'));
      allTabContents.forEach(content => content.classList.remove('active'));
      // Add Active Class
      tab.classList.add('active');
      document.getElementById(tab.dataset.tabContent).classList.add('active');

    });
  });
</script>