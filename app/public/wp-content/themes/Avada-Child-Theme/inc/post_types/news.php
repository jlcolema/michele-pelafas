<?php
/**
* Resources custom post type and all related functionality
*
* @package michele_pelafas
* 
*/

if( !function_exists( 'michele_pelafas_news_register' ) ) :
/**
 * Register the menu options
 *
 */
function michele_pelafas_news_register() {
    // News categories
    register_taxonomy( 'news_type', 'news', array(
        'labels'             => array(
            'name'               => _x( 'News Types', 'post type general name' ),
            'singular_name'      => _x( 'News Type', 'post type singular name' ),
            'add_new'            => _x( 'Add New', 'news' ),
            'add_new_item'       => __( 'Add New News Type' ),
            'edit_item'          => __( 'Edit News Type' ),
            'new_item'           => __( 'New News Type' ),
            'view_item'          => __( 'View News Type' ),
            'search_items'       => __( 'Search News Types' ),
            'not_found'          => __( 'Nothing found' ),
            'not_found_in_trash' => __( 'Nothing found in Trash' ),
            'parent_item_colon'  => ''
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'query_var'          => true,
        'menu_icon'          => 'dashicons-portfolio',
        'rewrite'            => array(
            'slug'                 => 'news/category',
            'with_front'           => false,
            'hierarchical'         => true
        ),
        'capability_type'    => 'post',
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    ));

    // News Post Type
    $args = array(
        'labels'             => array(
            'name'               => _x( 'News', 'post type general name' ),
            'singular_name'      => _x( 'News', 'post type singular name' ),
            'add_new'            => _x( 'Add New', 'news' ),
            'add_new_item'       => __( 'Add New News' ),
            'edit_item'          => __( 'Edit News' ),
            'new_item'           => __( 'New News' ),
            'view_item'          => __( 'View News' ),
            'search_items'       => __( 'Search News' ),
            'not_found'          => __( 'Nothing found' ),
            'not_found_in_trash' => __( 'Nothing found in Trash' ),
            'parent_item_colon'  => ''
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'query_var'          => true,
        'menu_icon'          => 'dashicons-admin-post',
        'rewrite'            => array( 
            'slug'       => 'news',
            'with_front' => false
        ),
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => null,
        'has_archive'        => true,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type( 'news', $args );
}
add_action( 'init', 'michele_pelafas_news_register' );
endif;