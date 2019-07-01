<?php

function get_work_page(){
    $categories = ( $_GET['cats'] ) ? $_GET['cats'] : [];
    $tag = ( $_GET['tag'] ) ? $_GET['tag'] : '';


    $page = ( $_GET['page'] ) ? $_GET['page'] : 1;
    $args = [
        'post_type' => 'work',
        'posts_per_page' => 9,
        'paged' => $page,
    ];
    if(count($categories) || $tag){
        $args['tax_query'] = [];
    }
    if(count($categories)){
        $args['tax_query'][] = [
            'taxonomy' => 'work_cat',
            'field'    => 'slug',
            'terms'    => $categories,
            'operator' => 'IN',
        ];
    }
    if($tag){
        $args['tax_query'][] = [
            'taxonomy' => 'work_tag',
            'field'    => 'slug',
            'terms'    => [$tag],
            'operator' => 'IN',
        ];
    }

    $the_query = new WP_Query( $args );

    $result = [];
    $result['page_max'] = $the_query->max_num_pages;

    $postsData = [];

    if ( $the_query->have_posts() ) {
        while ( $post = $the_query->have_posts() ) {
            $the_query->the_post();

            $post = [];
            $post['permalink'] = get_permalink();
            $post['thumbnail'] = get_the_post_thumbnail();
            $post['title'] = get_the_title();
            $post['categories'] = [];

            $cat = get_the_terms($post->ID,'work_tag');
            foreach($cat as $c){
                $catData = [];
                $catData['title'] = $c->name;
                $catData['slug'] = $c->slug;
                $post['categories'][] = $catData;
            }
            $postsData[] = $post;
        }
    }

    $result['posts'] = $postsData;

    echo json_encode($result);
    exit;
}
add_action( 'wp_ajax_get_work', 'get_work_page' );
add_action( 'wp_ajax_nopriv_get_work', 'get_work_page' );


function get_blog_page(){
    $categories = ( $_GET['cats'] ) ? $_GET['cats'] : [];


    $page = ( $_GET['page'] ) ? $_GET['page'] : 1;
    $args = [
        'post_type' => 'blog',
        'posts_per_page' => 9,
        'paged' => $page,
    ];
    if(count($categories)){
        $args['tax_query'] = [
            [
                'taxonomy' => 'blog_tag',
                'field'    => 'slug',
                'terms'    => $categories,
                'operator' => 'IN',
            ],
        ];
    }

    $the_query = new WP_Query( $args );

    $result = [];
    $result['page_max'] = $the_query->max_num_pages;

    $postsData = [];

    if ( $the_query->have_posts() ) {
        while ( $post = $the_query->have_posts() ) {
            $the_query->the_post();

            $post = [];
            $post['permalink'] = get_permalink();
            $post['thumbnail'] = get_the_post_thumbnail();
            $post['title'] = get_the_title();
            $post['categories'] = [];

            $cat = get_the_terms($post->ID,'blog_tag');
            foreach($cat as $c){
                $catData = [];
                $catData['title'] = $c->name;
                $catData['slug'] = $c->slug;
                $post['categories'][] = $catData;
            }
            $postsData[] = $post;
        }
    }

    $result['posts'] = $postsData;

    echo json_encode($result);
    exit;
}
add_action( 'wp_ajax_get_blog', 'get_blog_page' );
add_action( 'wp_ajax_nopriv_get_blog', 'get_blog_page' );