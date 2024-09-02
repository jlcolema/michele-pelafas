<?php
/**
* Resources custom post type and all related functionality
*
* @package michele_pelafas
* 
*/

if( !function_exists( 'michele_pelafas_swatches_register' ) ) :
/**
 * Register the menu options
 *
 */
function michele_pelafas_swatches_register() {
    // Swatches categories
    register_taxonomy( 'swatches_type', 'swatches', array(
        'labels'             => array(
            'name'               => _x( 'Swatch Types', 'post type general name' ),
            'singular_name'      => _x( 'Swatch Type', 'post type singular name' ),
            'add_new'            => _x( 'Add New', 'swatches' ),
            'add_new_item'       => __( 'Add New Type' ),
            'edit_item'          => __( 'Edit Type' ),
            'new_item'           => __( 'New Type' ),
            'view_item'          => __( 'View Type' ),
            'search_items'       => __( 'Search Types' ),
            'not_found'          => __( 'Nothing found' ),
            'not_found_in_trash' => __( 'Nothing found in Trash' ),
            'parent_item_colon'  => ''
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'query_var'          => false,
        'menu_icon'          => 'dashicons-portfolio',
        'capability_type'    => 'post',
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => array( 'title', 'thumbnail' )
    ));

    // Swatches Post Type
    $args = array(
        'labels'             => array(
            'name'               => _x( 'Swatches', 'post type general name' ),
            'singular_name'      => _x( 'Swatches', 'post type singular name' ),
            'add_new'            => _x( 'Add New', 'swatches' ),
            'add_new_item'       => __( 'Add New Swatches' ),
            'edit_item'          => __( 'Edit Swatches' ),
            'new_item'           => __( 'New Swatches' ),
            'view_item'          => __( 'View Swatches' ),
            'search_items'       => __( 'Search Swatches' ),
            'not_found'          => __( 'Nothing found' ),
            'not_found_in_trash' => __( 'Nothing found in Trash' ),
            'parent_item_colon'  => ''
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'query_var'          => false,
        'menu_icon'          => 'dashicons-admin-appearance',
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => null,
        'has_archive'        => false,
        'supports'           => array( 'title', 'thumbnail' )
    );
    register_post_type( 'swatches', $args );
}
add_action( 'init', 'michele_pelafas_swatches_register' );
endif;

function add_featured_image_column($defaults) {
    $defaults['featured_image'] = 'Featured Image';
    return $defaults;
}
add_filter('manage_swatches_posts_columns', 'add_featured_image_column');
 
function show_featured_image_column($column_name, $post_id) {
    if ($column_name == 'featured_image') {
        echo get_the_post_thumbnail($post_id, array( 50, 50)); 
    }
}
add_action('manage_swatches_posts_custom_column', 'show_featured_image_column', 10, 2);
