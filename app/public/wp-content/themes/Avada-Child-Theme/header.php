<?php
/**
 * Header template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<!DOCTYPE html>
<html class="<?php echo ( Avada()->settings->get( 'smooth_scrolling' ) ) ? 'no-overflow-y' : ''; ?>" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php Avada()->head->the_viewport(); ?>

	<script async src="https://js.convertflow.co/production/websites/18788.js"></script>
	
	<?php wp_head(); ?>

	<?php $object_id = get_queried_object_id(); ?>
	<?php $c_page_id = Avada()->fusion_library->get_page_id(); ?>

	<script type="text/javascript">
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

	<?php
	/**
	 *
	 * The settings below are not sanitized.
	 * In order to be able to take advantage of this,
	 * a user would have to gain access to the database
	 * in which case this is the least on your worries.
	 */
	echo Avada()->settings->get( 'google_analytics' ); // WPCS: XSS ok.
	echo Avada()->settings->get( 'space_head' ); // WPCS: XSS ok.
	?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-46561218-4"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-46561218-4');
	</script>
</head>

<?php
$wrapper_class = ( is_page_template( 'blank.php' ) ) ? 'wrapper_blank' : '';

if ( 'modern' === Avada()->settings->get( 'mobile_menu_design' ) ) {
	$mobile_logo_pos = strtolower( Avada()->settings->get( 'logo_alignment' ) );
	if ( 'center' === strtolower( Avada()->settings->get( 'logo_alignment' ) ) ) {
		$mobile_logo_pos = 'left';
	}
}


//Add hero class to body if needed
$class = '';
$slider = get_field('slider', $id);
if( $slider && !is_woocommerce() ){
	$class = 'has-hero';
}
?>
<body <?php body_class($class); ?>>
	<?php
	do_action( 'avada_before_body_content' );

	$boxed_side_header_right = false;
	$page_bg_layout = ( $c_page_id ) ? get_post_meta( $c_page_id, 'pyre_page_bg_layout', true ) : 'default';
	?>
	<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && ( 'default' === $page_bg_layout || '' == $page_bg_layout ) ) || 'boxed' === $page_bg_layout ) && 'Top' != Avada()->settings->get( 'header_position' ) ) : ?>
		<div id="boxed-wrapper">
	<?php endif; ?>
	<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && 'default' === $page_bg_layout ) || 'boxed' === $page_bg_layout ) && 'framed' === Avada()->settings->get( 'scroll_offset' ) ) : ?>
		<div class="fusion-sides-frame"></div>
	<?php endif; ?>
	<div id="wrapper" class="<?php echo esc_attr( $wrapper_class ); ?>">
		<div id="home" style="position:relative;top:-1px;"></div>
		<div class="headerContainer">
			<div class="headerContainerInner">
				<div class="headerPhoneLogo">
					<div class="headerPhone">
					<a class="headerTopLink" href="tel:18669907750" aria-label="Call Us" tabindex="0">CALL US (866) 990-7750</a>
					</div>
					<div class="headerLogo">
						<a class="headerLogoLink" href="/"><img src="<?php echo get_stylesheet_directory_uri();?>/images/michele-pelafas-logo.svg" /></a>
					</div>
				</div>
				<div class="headerMenus">
					<div class="headerTopMenu desktop-only">
						
						<?php if ( is_user_logged_in() ){ 
							echo '<a class="headerTopLink marker" href="/my-account/" aria-label="Login" tabindex="0">My Account</a>';
						}else{
    					echo '<a class="headerTopLink marker" href="/my-account/" aria-label="Login" tabindex="0">Login</a>';
						} ?>
						<?php
							$cart_contents_count = WC()->cart->get_cart_contents_count();
							echo '<a class="headerTopLink" href="/cart/"><span class="menu-text bag" aria-label="View Cart">BAG (' . $cart_contents_count . ')</span></a>';
						?>
						
					</div>
					<div class="headerMainMenu">
					<svg xmlns="http://www.w3.org/2000/svg" width="22.425" height="22.425" viewBox="0 0 22.425 22.425">
						<g id="icon_-_MP_STAR" data-name="icon - MP STAR" transform="translate(-54.895 -54.342)">
							<g id="Group_35" data-name="Group 35" transform="translate(55.108 54.554)">
								<g id="Group_34" data-name="Group 34" transform="translate(4.313 4.268)">
									<path id="Path_9" data-name="Path 9" d="M90.656,148.138l4.774-4.213-1.308,3.185,3.177-1.317-4.12,4.867" transform="translate(-90.6 -137.209)" fill="none" stroke="#cba966" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.3"/>
									<path id="Path_10" data-name="Path 10" d="M149.416,89.378,145.2,94.152l3.185-1.308-1.317,3.177,4.867-4.12" transform="translate(-138.443 -89.365)" fill="none" stroke="#cba966" stroke-linejoin="round" stroke-width="0.3"/>
									<path id="Path_11" data-name="Path 11" d="M92.725,89.276l4.213,4.774-3.185-1.308,1.317,3.177L90.2,91.8" transform="translate(-90.202 -89.276)" fill="none" stroke="#cba966" stroke-linejoin="round" stroke-width="0.3"/>
									<path id="Path_12" data-name="Path 12" d="M152,147.887l-4.774-4.213,1.308,3.185-3.177-1.317,4.12,4.867" transform="translate(-138.58 -136.988)" fill="none" stroke="#cba966" stroke-linejoin="round" stroke-width="0.3"/>
								</g>
								<rect id="Rectangle_957" data-name="Rectangle 957" width="15.534" height="15.579" transform="translate(11.016 0) rotate(45)" fill="none" stroke="#cba966" stroke-linejoin="round" stroke-width="0.3"/>
							</g>
						</g>
					</svg>
						<?php wp_nav_menu( array( 'theme_location' => 'main_navigation' ) ); ?>
						<?php
							$cart_contents_count = WC()->cart->get_cart_contents_count();
							echo '<a class="headerTopLink mobile-only" href="/cart/"><span class="menu-text bag" aria-label="View Cart">BAG (' . $cart_contents_count . ')</span></a>';
						?>
					</div>
				</div>
			</div>
		</div>

		<?php
		//Slider for homepage
		$slider  = get_field('slider', $id);
		$bgColor = get_field('overlay_color');
		$blend = get_field('blend_mode');
		if( $slider ){
			echo "<div class='hero main-hero'>";
				if( $slider ){
					if (is_front_page()) {
					  echo "<div class='hero-slider main-slider'>";
					}else {
						echo "<div class='hero-slider main-slider landing'>";
					}
					 	// loop through the rows of data
						$slide = 1;
					    foreach($slider as $row){
					    	echo '<div class="slide heroImage" style="background: url('.$row['image'].'); background-position: center;">';
					    		echo '<div class="slide-overlay" style="background: '.$bgColor.'; mix-blend-mode:'.$blend.';"></div>';
							    	echo '<div class="slide-content">';
								    	echo '<div class="inner">';
								    		if ($slide === 1) {
													echo '<span class="heroKeyword">'.$row['keyword'].'</span>';
								    			echo '<h1>'.$row['heading'].'</h1>';
								    		}else{
								    			echo '<h2>'.$row['heading'].'</h2>';
								    		}
								    		if ($row['sub_heading']) {
								    			echo '<span>'.$row['sub_heading'].'</span>';
								    		}
								    		if ($row['cta']) {
								    			$link = $row['cta'];
								    			echo '<a class="heroCTA" href="'.$link['url'].'">'.$link['title'].' </a>';
								    		}
								    		$slide++;
										echo '</div>';
									echo '</div>';
							echo '</div>';
					    }
				    echo '</div>';
				}
			echo '</div>';					
		}
		?>

		<?php if ( is_page_template( 'contact.php' ) && Avada()->settings->get( 'recaptcha_public' ) && Avada()->settings->get( 'recaptcha_private' ) ) : ?>
			<script type="text/javascript">var RecaptchaOptions = { theme : '<?php echo esc_attr( Avada()->settings->get( 'recaptcha_color_scheme' ) ); ?>' };</script>
		<?php endif; ?>

		<?php if ( is_page_template( 'contact.php' ) && Avada()->settings->get( 'gmap_address' ) && Avada()->settings->get( 'status_gmap' ) ) : ?>
			<?php
			$map_popup             = ( ! Avada()->settings->get( 'map_popup' ) ) ? 'yes' : 'no';
			$map_scrollwheel       = ( Avada()->settings->get( 'map_scrollwheel' ) ) ? 'yes' : 'no';
			$map_scale             = ( Avada()->settings->get( 'map_scale' ) ) ? 'yes' : 'no';
			$map_zoomcontrol       = ( Avada()->settings->get( 'map_zoomcontrol' ) ) ? 'yes' : 'no';
			$address_pin           = ( Avada()->settings->get( 'map_pin' ) ) ? 'yes' : 'no';
			$address_pin_animation = ( Avada()->settings->get( 'gmap_pin_animation' ) ) ? 'yes' : 'no';
			?>
			<div id="fusion-gmap-container">
				<?php // @codingStandardsIgnoreLine
				echo Avada()->google_map->render_map(
					array(
						'address'                  => esc_html( Avada()->settings->get( 'gmap_address' ) ),
						'type'                     => esc_attr( Avada()->settings->get( 'gmap_type' ) ),
						'address_pin'              => esc_attr( $address_pin ),
						'animation'                => esc_attr( $address_pin_animation ),
						'map_style'                => esc_attr( Avada()->settings->get( 'map_styling' ) ),
						'overlay_color'            => esc_attr( Avada()->settings->get( 'map_overlay_color' ) ),
						'infobox'                  => esc_attr( Avada()->settings->get( 'map_infobox_styling' ) ),
						'infobox_background_color' => esc_attr( Avada()->settings->get( 'map_infobox_bg_color' ) ),
						'infobox_text_color'       => esc_attr( Avada()->settings->get( 'map_infobox_text_color' ) ),
						// @codingStandardsIgnoreLine
						'infobox_content'          => htmlentities( Avada()->settings->get( 'map_infobox_content' ) ),
						'icon'                     => esc_attr( Avada()->settings->get( 'map_custom_marker_icon' ) ),
						'width'                    => esc_attr( Avada()->settings->get( 'gmap_dimensions', 'width' ) ),
						'height'                   => esc_attr( Avada()->settings->get( 'gmap_dimensions', 'height' ) ),
						'zoom'                     => esc_attr( Avada()->settings->get( 'map_zoom_level' ) ),
						'scrollwheel'              => esc_attr( $map_scrollwheel ),
						'scale'                    => esc_attr( $map_scale ),
						'zoom_pancontrol'          => esc_attr( $map_zoomcontrol ),
						'popup'                    => esc_attr( $map_popup ),
					)
				);
				?>
			</div>
		<?php endif; ?>
		<?php
		$main_css   = '';
		$row_css    = '';
		$main_class = '';

		if ( apply_filters( 'fusion_is_hundred_percent_template', $c_page_id, false ) ) {
			$main_css = 'padding-left:0px;padding-right:0px;';
			$hundredp_padding = get_post_meta( $c_page_id, 'pyre_hundredp_padding', true );
			if ( Avada()->settings->get( 'hundredp_padding' ) && ! $hundredp_padding ) {
				$main_css = 'padding-left:' . Avada()->settings->get( 'hundredp_padding' ) . ';padding-right:' . Avada()->settings->get( 'hundredp_padding' );
			}
			if ( $hundredp_padding ) {
				$main_css = 'padding-left:' . $hundredp_padding . ';padding-right:' . $hundredp_padding;
			}
			$row_css    = 'max-width:100%;';
			$main_class = 'width-100';
		}
		do_action( 'avada_before_main_container' );
		?>
    <div class="video-overlay"></div>  
		<main id="main" role="main" class="clearfix <?php echo esc_attr( $main_class ); ?> <?php echo "width-100"; ?>" style="<?php echo esc_attr( $main_css ); ?>">

			<?php
			


			//Header section for Product Categories
      /*
			if ( is_product_category() ) {
				$term_object = get_queried_object();
				echo '<div class="page-intro">';
					if ($term_object->parent) {
						$category_parent = get_term( $term_object->parent, 'product_cat' );
						if ($category_parent) {
							echo '<span>'.$category_parent->name.'</span>';
						}
					}

					echo '<h1>'.$term_object->name.'</h1>';
					if ($term_object->description) {
						echo '<div class="description"><p>'.$term_object->description.'</p></div>';
					}
				echo '</div>';
			}
      */
			?>

			<div class="fusion-row main" style="<?php echo esc_attr( $row_css ); ?><?php echo "max-width:100%;"?>">
			