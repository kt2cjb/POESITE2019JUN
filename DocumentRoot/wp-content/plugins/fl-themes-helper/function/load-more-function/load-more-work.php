<?php

add_action( 'wp_ajax_rest_ajax_load_more_work_vc', 'rest_ajax_load_more_work_vc');
add_action( 'wp_ajax_nopriv_rest_ajax_load_more_work_vc', 'rest_ajax_load_more_work_vc');
function rest_ajax_load_more_work_vc() {

    check_ajax_referer( 'rest-load-more-work-nonce', 'nonce' );
    $args                   = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
    $args['post_type']      = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'works';
    $args['paged']          = esc_attr( $_POST['page'] );
    $args['post_status']    = 'publish';
    $args['posts_per_page'] = esc_attr( $_POST['works_per_page'] );


    ob_start();
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) : $i=0;  while ( $loop->have_posts() ): $loop->the_post(); $i++ ;
        $grid = $_POST['grid'];
        $column_count = $_POST['works_column'];
        $img_hv_animation = $_POST['img_hv_animation'];
        $mask_text_animation = $_POST['text_mask'];
        $mask_animation =  $_POST['mask_animation'];
        $style_mask = $_POST['style_mask'];
    ?>
        <article <?php post_class('fl-work-box cbp-item item cf')?> id="work-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
            <div class="fl-work-thumbnail <?php echo $img_hv_animation;?>">
                <?php if($grid == 'grid') {
                    echo get_the_post_thumbnail( $loop->ID, 'size_1000x800_crop' );
                } elseif($grid == 'masonry'){
                    if($column_count == '3'){
                        if ($i == 2 || $i == 4 || $i == 7 ) {
                            echo get_the_post_thumbnail( $loop->ID, 'size_800x1000_crop' ) ;
                        } else {
                            echo  get_the_post_thumbnail( $loop->ID, 'size_1000x800_crop' ) ;
                        }
                    } elseif ($column_count == '2'){
                        if ($i == 1 || $i == 4  || $i == 7) {
                            echo get_the_post_thumbnail( $loop->ID, 'size_800x1000_crop' ) ;
                        } else {
                            echo  get_the_post_thumbnail( $loop->ID, 'size_1000x800_crop' ) ;
                        }
                    } elseif ($column_count == '4'){
                        if ($i == 1 || $i == 3 || $i == 5 || $i == 6) {
                            echo get_the_post_thumbnail( $loop->ID, 'size_800x1000_crop' ) ;

                        } else {
                            echo  get_the_post_thumbnail( $loop->ID, 'size_1000x800_crop' ) ;

                        }
                    } else {
                        if ($i == 1 || $i == 3 || $i == 5 || $i == 6 || $i == 7) {
                            echo get_the_post_thumbnail( $loop->ID, 'size_800x1000_crop' ) ;
                        } else {
                            echo  get_the_post_thumbnail( $loop->ID, 'size_1000x800_crop' ) ;
                        }
                    }
                } else  {
                    echo get_the_post_thumbnail( $loop->ID, 'size_1024x768_crop' ) ;
                } ?>
            </div>
            <?php if($style_mask !=='light_box') { ?>
                <a href="<?php esc_url(the_permalink()); ?>" class="fl-work-link"></a>
                <div class="fl-work-mask <?php echo $mask_animation;?>">
                    <div class="fl-work-info <?php echo $mask_text_animation;?>">
                        <h4 class="fl-work-title"><a class="fl-work-title-link" href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title()); ?></a></h4>
                        <div class="fl-work-category"><?php get_template_part('template-parts/work/category'); ?></div>
                    </div>
                </div>
            <?php } else { ?>
                <a href="<?php echo get_the_post_thumbnail_url( $loop->ID, 'full' ); ?>" data-lightbox="<?php echo get_the_post_thumbnail_url( $loop->ID, 'full' ); ?>" data-title="<?php esc_attr(the_title()); ?>" class="fl-work-link"></a>
                <div class="fl-work-mask <?php echo $mask_animation;?>">
                    <div class="fl-work-info">
                        <i class="fl-zoom"></i>
                    </div>
                </div>
            <?php }?>
        </article>
<?php
    endwhile; endif;
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success( $data );

    wp_die();

}