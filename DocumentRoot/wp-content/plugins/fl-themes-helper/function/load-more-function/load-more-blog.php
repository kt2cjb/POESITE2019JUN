<?php

add_action( 'wp_ajax_rest_ajax_load_more_post_vc', 'rest_ajax_load_more_post_vc');
add_action( 'wp_ajax_nopriv_rest_ajax_load_more_post_vc', 'rest_ajax_load_more_post_vc');
function rest_ajax_load_more_post_vc() {

    check_ajax_referer( 'rest-load-more-post-nonce', 'nonce' );
    $args                   = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
    $args['post_type']      = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
    $args['paged']          = esc_attr( $_POST['page'] );
    $args['post_status']    = 'publish';
    $args['posts_per_page'] = esc_attr( $_POST['posts_per_page'] );


    ob_start();
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) : $i=0;  while ( $loop->have_posts() ): $loop->the_post(); $i++ ;
        $blog_style = $_POST['grid'];
        $column_setting = $_POST['posts_column'];
        $excerpt_limit = $_POST['excerpt_limit'];
        switch ($blog_style) {
            case 'standard' :
                $post_div_class = 'fl-standard-post-item';
                $header_size = 'h4';
                $column_setting = '1';
                break;
            case 'grid' :
                $post_div_class = 'fl-grid-post-item';
                $header_size = 'h5';
                break;
            case 'masonry' :
                $post_div_class = 'fl-masonry-post-item';
                $header_size = 'h5';
                break;
        }

    ?>
        <article <?php post_class(''.$post_div_class.' fl-post-box cbp-item item cf')?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
            <div class="fl-post-flex-blog">
                <div class="fl-post-holder">
                    <a href="<?php the_permalink(); ?>">
                        <?php if ($blog_style == 'masonry'){
                            if($column_setting == "2") {
                                if ($i == 1 || $i == 3 || $i == 5 || $i == 7 || $i == 9 || $i == 11) {
                                    echo get_the_post_thumbnail($loop->ID, 'size_1170x1170_crop');
                                } else {
                                    echo get_the_post_thumbnail($loop->ID, 'size_1170x668_crop');
                                }
                            } elseif($column_setting == "3"){
                                if ($i == 2 || $i == 4 || $i == 5 || $i == 8 || $i == 10 || $i == 11 ) {
                                    echo get_the_post_thumbnail($loop->ID, 'size_1170x1170_crop');
                                } else {
                                    echo get_the_post_thumbnail($loop->ID, 'size_1170x668_crop');
                                }
                            } elseif($column_setting == "4"){
                                if ($i == 1 || $i == 3 || $i == 5 || $i == 6) {
                                    echo get_the_post_thumbnail($loop->ID, 'size_1170x1170_crop');
                                } else {
                                    echo get_the_post_thumbnail($loop->ID, 'size_1170x668_crop');
                                }
                            } ?>

                        <?php } else {
                            echo get_the_post_thumbnail($loop->ID, 'size_1170x668_crop');
                        } ?>
                    </a>
                </div>
                <div class="fl-post-content-info cf">
                    <?php if(get_the_title() == false ){ ?>
                        <div class="read_more_rest">
                            <h5 class="fl-post-title <?php echo esc_attr($header_size) ;?>"><a href="<?php echo esc_url(the_permalink()); ?>"><?php esc_html_e('No Title','rest'); ?></a></h5>
                        </div>
                    <?php } ?>
                    <h5 class="fl-post-title <?php echo esc_attr($header_size) ;?>"><a class="main_color_hover" href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title()); ?></a></h5>
                    <div class="fl-post-info">
                        <span class="fl-post-date"><?php echo esc_attr(get_the_date()); ?></span>
                        <span class="fl-comments-post"><?php echo '<a class="fl-post-comments " href="'.get_comments_link().'" target="_self">';
                            comments_number('0 ' . esc_html__('Comments','rest'), '1 '.esc_html__('Comment','rest'), '% '.esc_html__('Comments','rest'));
                            echo '</a>';?></span>
                    </div>

                    <div class="fl-post-text-content">
                        <?php echo fl_limit_excerpt($excerpt_limit); ?>
                    </div>
                    <div class="fl-post-date-author cf">
                        <div class="fl-post-author">
                            <div class="fl-post-author-info">
                                <span class="fl-post-avatar"> <?php echo wp_kses_post(get_avatar( get_the_author_meta('user_email'), 32 )); ?></span>
                                <span class="fl-author-prefix"><?php echo esc_html__('By','rest');?></span>
                                <span class="fl-author-link h6"><?php echo wp_kses_post(get_the_author_posts_link());?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php
    endwhile; endif;
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success( $data );

    wp_die();

}