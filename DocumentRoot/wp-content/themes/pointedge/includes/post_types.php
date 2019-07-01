<?php

add_theme_support( 'post-thumbnails' );

function create_post_type() {
    register_post_type( 'news', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => 'ニュース', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'news',    // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => false, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
    ]);

    register_post_type( 'blog', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => 'BLOG', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'blog',    // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => true, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
        'supports'      => ['title','editor','thumbnail'],
    ]);

    register_taxonomy(
        'blog_tag', //タグ名（任意）
        'blog', //カスタム投稿名
        array(
          'hierarchical' => false, //タグタイプの指定（階層をもたない）
          'update_count_callback' => '_update_post_term_count',
          //ダッシュボードに表示させる名前
          'label' => 'タグ', 
          'public' => true,
          'show_ui' => true
        )
    );

    register_post_type( 'letter', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => '作品', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'letter',    // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => false, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
    ]);

    register_post_type( 'work', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => 'WORK', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'work',    // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => true, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
        'supports'      => ['title','editor','thumbnail'],
    ]);

    register_taxonomy(
        'work_cat', //カテゴリー名（任意）
        'work', //カスタム投稿名
        array(
          'hierarchical' => true, //カテゴリータイプの指定
          'update_count_callback' => '_update_post_term_count',
          //ダッシュボードに表示させる名前
          'label' => 'WORKカテゴリ', 
          'public' => true,
          'show_ui' => true
        )
    );

    register_taxonomy(
        'work_tag', //タグ名（任意）
        'work', //カスタム投稿名
        array(
          'hierarchical' => false, //タグタイプの指定（階層をもたない）
          'update_count_callback' => '_update_post_term_count',
          //ダッシュボードに表示させる名前
          'label' => 'タグ', 
          'public' => true,
          'show_ui' => true
        )
    );
}

add_action( 'init', 'create_post_type' );