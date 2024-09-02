<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
//do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	//do_action( 'woocommerce_archive_description' );
	?>
</header>


<?php

$current_category = get_queried_object();

if ($current_category) {
    $category_name = $current_category->name;
    $category_subhead = get_field('cat_subhead');
    $category_description = $current_category->description;
    $category_image_id = get_term_meta($current_category->term_id, 'thumbnail_id', true);
    $prodName = $current_category->slug;
    $category_id = $current_category->term_id;
    $category_image_url = wp_get_attachment_image_src($category_image_id, 'full');
    $current_category_link = get_term_link($current_category);
    
} 
?>
<?php
		$parent = get_term($current_category->parent, 'product_cat');
    $parent_title = $parent->name;
    $current_parent_link = get_term_link($parent);
    $parent_subhead = get_field('cat_subhead', $parent);
    //print_r($parent);
    $value = $parent->term_id;
		$current = $category_id;
		
    $subcategories = get_terms(
      array(
          'taxonomy' => 'product_cat',
          'parent' => $current_category->term_id,
      )
    );

    if (!empty($subcategories)) {
      echo "<div class='categoryHeading-block' style='background-color: #e2eded; color: #cba666'>";
        echo "<div class='categoryHeading-inner'>";
        echo '<h1 class="categoryHeading-headline">'.$category_name.'</h1>';
        echo '<span class="categoryHeading-subheading">'.$category_subhead.'</span>';
        echo "</div>";
      echo "</div>";

      echo "<div class='collectionRow'>";
          echo "<div class='collectionRow-inner'>";
            echo "<ul class='collectionRow-list'>";
              echo '<li><a class="collectionRow-link" href="'.$current_category_link.'">'.$category_name.'</a></li>';
              foreach ($subcategories as $subcategory) {
                  $subcategory_link = get_term_link($subcategory);
                  
                  if ( $subcategory->term_id === $category_id ) {
                    echo '<li><a class="collectionRow-link active" href="'.$subcategory_link.'">'.$subcategory->name.'</a></li>';
                  } else {
                    echo '<li><a class="collectionRow-link" href="'.$subcategory_link.'">'.$subcategory->name.'</a></li>';
                  }
              }
            echo '</ul>';  
          echo '</div>';
        echo '</div>'; 

    } else {

      if ($parent_title) {
        echo "<div class='categoryHeading-block' style='background-color: #e2eded; color: #cba666'>";
          echo "<div class='categoryHeading-inner'>";
          echo '<h1 class="categoryHeading-headline">'.$parent_title.'</h1>';
          echo '<span class="categoryHeading-subheading">'.$parent_subhead.'</span>';
          echo "</div>";
        echo "</div>";

        $parentcategories = get_terms(
          array(
              'taxonomy' => 'product_cat',
              'parent' => $parent->term_id,
          )
        );
  
        if (!empty($parentcategories)) {
          echo "<div class='collectionRow'>";
            echo "<div class='collectionRow-inner'>";
              echo "<ul class='collectionRow-list'>";
                echo '<li><a class="collectionRow-link" href="'.$current_parent_link.'">'.$parent_title.'</a></li>';
                foreach ($parentcategories as $subcategory) {
                    $subcategory_link = get_term_link($subcategory);
                    
                    if ( $subcategory->term_id === $category_id ) {
                      echo '<li><a class="collectionRow-link active" href="'.$subcategory_link.'">'.$subcategory->name.'</a></li>';
                    } else {
                      echo '<li><a class="collectionRow-link" href="'.$subcategory_link.'">'.$subcategory->name.'</a></li>';
                    }
                }
              echo '</ul>';  
            echo '</div>';
          echo '</div>';  
        }

      } else {
        echo "<div class='categoryHeading-block' style='background-color: #e2eded; color: #cba666'>";
          echo "<div class='categoryHeading-inner'>";
            echo '<h1 class="categoryHeading-headline">'.$category_name.'</h1>';
            echo '<span class="categoryHeading-subheading">'.$category_subhead.'</span>';
          echo "</div>";
        echo "</div>";
      }

    }
    

  ?>


<div class="is-layout-flex wp-container-3 wp-block-columns collectionContainer collectionBlock" style="gap: 2em;">
  <div class="is-layout-flow wp-block-column" style="flex-basis:66.66%">
    <h3 data-fontsize="36" style="--fontSize: 36; line-height: 1;" data-lineheight="36px" class="fusion-responsive-typography-calculated"><?php echo $category_name; ?></h3>
    <p><?php echo $category_description; ?></p>
  </div>

  <div class="is-layout-flow wp-block-column" style="flex-basis:33.33%">
    <?php echo '<div style="background-image:url(' . esc_url($category_image_url[0]) . ')" class="categoryImage"></div>'; ?>
  </div>

</div>


<div class="productLoop-block">
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

<?php get_footer( 'shop' ); ?>
