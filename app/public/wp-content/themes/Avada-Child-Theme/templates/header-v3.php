<?php
/**
 * Header-v3 template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="fusion-header-sticky-height"></div>
<div class="fusion-header">
	<div class="fusion-row">
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
			<div class="fusion-header-has-flyout-menu-content">
		<?php endif; ?>

		<div class="fusion-logo" data-margin-top="31px" data-margin-bottom="31px" data-margin-left="0px" data-margin-right="0px">
			<!-- <a class="fusion-logo-link" href="/">MICHELE PELAFAS</a> -->
			<a class="fusion-logo-link" href="/"><img src="<?php echo get_stylesheet_directory_uri();?>/images/michele-pelafas-logo.svg" /></a>
		</div>


		<?php avada_main_menu(); ?>
		<?php avada_mobile_menu_search(); ?>
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
			</div>
		<?php endif; ?>
	</div>
</div>
