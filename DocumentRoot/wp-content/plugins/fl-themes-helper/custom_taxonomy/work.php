<?php
add_theme_support( 'post-thumbnails', 'works' );


add_action( 'init', 'fl_work_init', 0 );

if( !function_exists('fl_work_init') ){
    function fl_work_init() {

        $labels = array(
            'name' => esc_html__( 'Work', 'fl-themes-helper' ),
            'singular_name' => esc_html__( 'Work Item', 'fl-themes-helper' ),
            'add_new' => esc_html__( 'Add New Item', 'fl-themes-helper' ),
            'add_new_item' => esc_html__( 'Add New Work Item', 'fl-themes-helper' ),
            'edit_item' => esc_html__( 'Edit Work Item', 'fl-themes-helper' ),
            'new_item' => esc_html__( 'Add New Work Item', 'fl-themes-helper' ),
            'view_item' => esc_html__( 'View Item', 'fl-themes-helper' ),
            'search_items' => esc_html__( 'Search Work', 'fl-themes-helper' ),
            'not_found' => esc_html__( 'No work items found', 'fl-themes-helper' ),
            'not_found_in_trash' => esc_html__( 'No work items found in trash', 'fl-themes-helper' )
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail', 'author', 'revisions'),
            'capability_type' => 'post',
            'menu_position' => 5,
            'has_archive' => false,
            'menu_icon'   => 'dashicons-schedule',
        );

        $args = apply_filters('fl_args', $args);

        register_post_type('works', $args);
        flush_rewrite_rules();


        /**
         * Register a taxonomy for work Categories
         * http://codex.wordpress.org/Function_Reference/register_taxonomy
         */

        $taxonomy_work_category_labels = array(
            'name' => esc_html__( 'Work Categories', 'fl-themes-helper' ),
            'singular_name' => esc_html__( 'Work Category', 'fl-themes-helper' ),
            'search_items' => esc_html__( 'Search Work Categories', 'fl-themes-helper' ),
            'popular_items' => esc_html__( 'Popular Work Categories', 'fl-themes-helper' ),
            'all_items' => esc_html__( 'All Work Categories', 'fl-themes-helper' ),
            'parent_item' => esc_html__( 'Parent Work Category', 'fl-themes-helper' ),
            'parent_item_colon' => esc_html__( 'Parent Work Category:', 'fl-themes-helper' ),
            'edit_item' => esc_html__( 'Edit Work Category', 'fl-themes-helper' ),
            'update_item' => esc_html__( 'Update Work Category', 'fl-themes-helper' ),
            'add_new_item' => esc_html__( 'Add New Work Category', 'fl-themes-helper' ),
            'new_item_name' => esc_html__( 'New Work Category Name', 'fl-themes-helper' ),
            'separate_items_with_commas' => esc_html__( 'Separate Work categories with commas', 'fl-themes-helper' ),
            'add_or_remove_items' => esc_html__( 'Add or remove Work categories', 'fl-themes-helper' ),
            'choose_from_most_used' => esc_html__( 'Choose from the most used Work categories', 'fl-themes-helper' ),
            'menu_name' => esc_html__( 'Work Categories', 'fl-themes-helper' ),
        );

        $taxonomy_work_category_args = array(
            'labels' => $taxonomy_work_category_labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => false,
        );
        register_taxonomy( 'works-category', array( 'works' ), $taxonomy_work_category_args );
    }
}




add_filter( 'manage_posts_columns', 'fl_add_thumbnail_column', 10, 1 );

if( !function_exists('fl_add_thumbnail_column') ){
    function fl_add_thumbnail_column( $columns ) {

        $column_thumbnail = array( 'thumbnail' => esc_html__('Thumbnail','fl-themes-helper' ) );
        $columns = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
        return $columns;
    }
}



add_action( 'manage_posts_custom_column', 'fl_display_thumbnail', 10, 1 );

if( !function_exists('fl_display_thumbnail') ){
    function fl_display_thumbnail( $column ) {
        global $post;
        switch ( $column ) {
            case 'thumbnail':
                echo get_the_post_thumbnail( $post->ID, array(50, 50) );
                break;
        }
    }
}