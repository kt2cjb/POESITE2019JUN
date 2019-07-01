<?php
/*
 * Shortcode Blog
 */

add_shortcode('vc_fl_blog_home_page', 'vc_fl_blog_home_page_function');
function vc_fl_blog_home_page_function($atts, $content = null) {


    extract(shortcode_atts(array(
        'excerpt_count'         => '15',
        'header_size'           => 'h5',
        'column'                => '3',
        'img_mr_bt'             => '',
        'blog_content_fs'       => '',
        'blog_content_color'    => '',
        'blog_h_color'          => '',
        'header_mr_bt'          => '',
        'class'                 => '',
        'vc_css'                => '',
    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    switch ($column) {
        case '2' :
            $column_setting = 'fl-column-two';
            break;
        case '3' :
            $column_setting = 'fl-column-three';
            break;
    }

    $h_cl = '';
    $mb_h = '';
    if($blog_h_color){
        $h_cl = 'color:'.$blog_h_color.';';
    }

    if($header_mr_bt){
        $mb_h = 'margin-bottom:'.$header_mr_bt.'px;';
    }

    $blog_header_style = ( $h_cl || $mb_h ) ? 'style='. $h_cl . $mb_h.'' : '';


    $cn_fz = '';
    $cn_cl = '';
    if($blog_content_fs){
        $cn_fz = 'font-size:'.$blog_content_fs.';';
    }
    if($blog_content_color){
        $cn_cl = 'color:'.$blog_content_color.';';
    }

    $blog_text_style = ( $cn_fz || $cn_cl  ) ? 'style='. $cn_fz . $cn_cl  . '' : '';


    $mb_img = '';

    if($img_mr_bt){
        $mb_img = 'margin-bottom:'.$img_mr_bt.'px;';
    }
    $blog_img_style = (  $mb_img ) ? 'style='. $h_cl . $mb_img.'' : '';

    ob_start();
    ?>


    <div class="fl-home-page-blog-post cf <?php echo fl_sanitize_class($class).' '.$column_setting ;?>">
        <?php
        $post_query = new WP_Query(array(
            'posts_per_page'		=> $column,
            'ignore_sticky_posts'	=> 1,
            'orderby'               => 'date',
        ));
        ?>
        <?php global $post;
            if ($post_query->have_posts()) : while ($post_query->have_posts()) : $post_query->the_post(); ?>
            <article class="fl-blog-post-home cf" id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                <div class="fl-blog-home-img" <?php echo $blog_img_style ;?>>
                    <?php if ( has_post_thumbnail()) { ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                            <?php  echo get_the_post_thumbnail($post->ID, 'size_1170x668_crop');; ?>
                        </a>
                    <?php } ?>
                </div>
                <div class="fl-blog-post-home-info" >
                    <?php if(get_the_title() == false ){ ?>
                        <<?php echo $header_size;?> class="fl-post-title" <?php echo $blog_header_style ;?>><a href="<?php echo esc_url(the_permalink()); ?>"><?php esc_html_e('No Title','rest'); ?></a></<?php echo $header_size;?>>
                    <?php } ?>
                    <<?php echo $header_size;?> class="fl-post-title" <?php echo $blog_header_style ;?>><a class="main_color_hover" href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title()); ?></a></<?php echo $header_size;?>>
                    <div class="fl-post-text" <?php echo $blog_text_style ;?>>
                        <?php echo fl_limit_excerpt($excerpt_count); ?>
                    </div>
                </div>
            </article>
        <?php endwhile; endif; wp_reset_query(); ?>
    </div>


    <?php

    return ob_get_clean();
}
add_action('vc_before_init', 'vc_fl_blog_home_page_shortcode');

function vc_fl_blog_home_page_shortcode() {
    if(function_exists('vc_map')) {
        vc_map( array(
            'name'                      => esc_html__( 'Blog home page', 'fl-themes-helper' ),
            'base'                      => 'vc_fl_blog_home_page',
            'category'                  => esc_html__( 'Fl Theme', 'fl-themes-helper' ),
            'icon'                      => 'fl-icon icon-fl-blog-home-page',
            'controls'                  => 'full',
            'weight'                    => 900,
            'params'                    => array(
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Blog column', 'test'),
                    'param_name'    => 'column',
                    'value' => array(
                        'Two Column'    => '2',
                        'Three Column'  => '3',
                    ),
                    'std'           => '3',
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Image Margin Bottom", "fl-themes-helper" ),
                    "param_name"        => "img_mr_bt",
                    'value'             => "",
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'group'             => 'Image Setting',
                ),
                array(
                    "type"              => "textfield",
                    "heading"           => esc_html__( "Number of Words in Description", "fl-themes-helper" ),
                    "param_name"        => "excerpt_count",
                    'std'               => '15',
                    "description"       => esc_html__( "Specify the Number of Words for Description blog per post.", "fl-themes-helper" )
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Blog Header size', 'test'),
                    'param_name'    => 'header_size',
                    'value' => array(
                        'H1'            => 'h1',
                        'H2'            => 'h2',
                        'H3'            => 'h3',
                        'H4'            => 'h4',
                        'H5'            => 'h5',
                        'H6'            => 'h6',
                    ),
                    'std'           => 'h5',
                    'group'             => 'Text Settings',
                ),
                array(
                    "type"              => "textfield",
                    'heading'           => esc_html__('Content font size', 'fl-themes-helper'),
                    "description"       => esc_html__( "Enter text font size (Number + px).Example:14px.", "fl-themes-helper" ),
                    "param_name"        => 'blog_content_fs',
                    "value"             => esc_html__("", 'fl-themes-helper'),
                    'std'               => '',
                    'group'             => 'Text Settings',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Header text color', 'fl-themes-helper'),
                    'param_name'        => 'blog_h_color',
                    'value'             => '',
                    'std'               => '',
                    'group'             => 'Text Settings',
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Header Margin Bottom", "fl-themes-helper" ),
                    "param_name"        => "header_mr_bt",
                    'value'             => "",
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'group'             => 'Text Settings',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Content text color', 'fl-themes-helper'),
                    'param_name'        => 'blog_content_color',
                    'value'             => '',
                    'std'               => '',
                    'group'             => 'Text Settings',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'        => 'class',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    'type'              => 'css_editor',
                    'heading'           => esc_html__( 'CSS', 'fl-themes-helper'),
                    'param_name'        => 'vc_css',
                    'group'             => esc_html__( 'Design Options', 'fl-themes-helper'),
                )
            ),

        ) );
    }
}
