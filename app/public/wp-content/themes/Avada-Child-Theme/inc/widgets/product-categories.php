<?php
// Register and load the widget
function michele_pelafas_load_widget() {
    register_widget( 'michele_pelafas_widget' );
}
add_action( 'widgets_init', 'michele_pelafas_load_widget' );
 
// Creating the widget 
class michele_pelafas_widget extends WP_Widget {
 
	function __construct() {
		parent::__construct(
		 
		// Base ID of your widget
		'michele_pelafas_widget', 
		 
		// Widget name will appear in UI
		__('MP Product Categories', 'michele_pelafas'), 
		 
		// Widget description
		array( 'description' => __( 'Widget Shows Child Categories of Parent Category', 'michele_pelafas' ), ) 
		);
	}
	 
	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];

		// Get the current category term id, then get the children
		$current_term = get_queried_object();
		//Check if it has a parent category
		$parent = ( isset( $current_term->parent ) ) ? get_term_by( 'id', $current_term->parent, 'product_cat' ) : false;
		if ($parent) {

							

			//Get main menu items array, only show child terms if it is used in the menu
			$menu_items = wp_get_nav_menu_items('16');
			$menu_ids = array();
			foreach ( $menu_items as $menu_item ){
			   	if( !in_array( $menu_item->object_id, $menu_ids )){
			   		$menu_ids[] = $menu_item->object_id;
			   	}
			}

			//If term object_id is used in main menu, append those menu items
			if (in_array($current_term->term_id, $menu_ids)) {
				echo $args['before_title'] . $parent->name . $args['after_title'];

					echo '<ul id="childCategories">';
						echo '<li data-id="object-id-'.$current_term->term_id.'"></li>';
					echo '</ul>';
					?>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							if ( $("#childCategories").length ) {
								var object_id = $("#childCategories").find('li').data('id');
								var menu_html = $("#menu-main-menu").find('li.'+object_id).parent('ul').html();
								$("#childCategories").empty().append(menu_html);
							}
						})
					</script>
					<?php

				echo $args['after_widget'];	
			}
		}
	}      

}
?>