<?php
/*
 * Shortcode Blog
 * */

add_shortcode('vc_fl_posts', 'vc_fl_posts_function');

function vc_fl_posts_function($atts, $content = null) {
    extract(shortcode_atts(array(
        'excerpt_limit'             => 15,
        'filter_counter'            => 'disable',
        'animation_count'           => '',
        'filter'                    => 'disable',
        'filter_style'              => 'fl_filter_style_one',
        'filter_mr_bt'              => 15,
        'filter_mr_top'             => '',
        'filter_a_cl'               => '#000000',
        'filter_cl'                 => '#1f1f1f',
        'animation_type'            => 'fadeOut',
        'count'                     => '8',
        'blog_style'                => 'standard',
        'column_grid_masonry'       => '3',
        'pagination'                => 'load_more',
        'btn_text_cl'               => '#ffffff',
        'btn_cl'                    => '#1f1f1f',
        'btn_mr_top'                => 35,
        'btn_mr_bt'                 => 0,
        'btn_style'                 => 'fl_btn_bg',
        'width_border'              => 1,
        'btn_cl_br'                 => '#1f1f1f',
        'shape'	                    => 'fl_btn_square',
        'fl_btn_effects'            => '',
        'fl_btn_hv_color_enable'	=> 'disable',
        'btn_hv_text_cl'		    => '#1f1f1f',
        'btn_hv_bg_cl'			    => '#1f1f1f',
        'btn_sp_hv_bg_cl'           => "#f1f1f1",
        'btn_sp_hv_text_cl'         => "#1f1f1f",
        'size'			            => 'fl_btn_medium',
        'button_block'		        => '',
        'hor_gap'                   => '30',
        'ver_gap'                   => '30',
        'display_type'              => 'default',
        'displaytypespeed'          => '150',
        'class'                     => '',
        'vc_css'                    => '',
    ), $atts));



    $idf = uniqid('fl-post-');

    $class .= fl_get_css_tab_class($atts);

    $max_page = new WP_Query( $pages = array('post_type' => 'post', 'posts_per_page'    => $count,));
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $args = array(
        'nonce'                 => wp_create_nonce( 'rest-load-more-post-nonce' ),
        'url'                   => admin_url( 'admin-ajax.php' ),
        'button_text'           => esc_attr__( 'Load More', 'fl-themes-helper' ),
        'button_text_no_post'   => esc_attr__( 'No More Posts', 'fl-themes-helper' ),
        'button_loading'        => esc_attr__( 'Loading...', 'fl-themes-helper' ),
        'post_type'             => 'post',
        'post_status'           => 'publish',
        'posts_category'        => 'post-category',
        'maxpage'               => $max_page->max_num_pages,
        'posts_per_page'        => $count,
        'paged'                 => $paged,
    );

    $blog_posts = new WP_Query( $args );
    $i = '0';


    $max_page_data = $max_page->max_num_pages;

    if($filter_counter !== 'disable'){
        $counter_filter = '<div class="cbp-filter-counter"></div>';
    }  else {
        $counter_filter = '';
    }


    $output_filter = '';
    $categories = get_categories();
    foreach ($categories as $category) {
        $output_filter .= '<div data-filter=".category-'.$category->slug .'" class="cbp-filter-item fl-post-filter-item"><span>'.$category->name . '</span>'.$counter_filter.'<span class="fl-filter-line"></span></div>';
    }


    $mr_bt_fl = '';
    if($filter_mr_bt){
        $mr_bt_fl = 'margin-bottom:'.$filter_mr_bt.'px;';
    }
    $mr_top_fl = '';
    if($filter_mr_top){
        $mr_top_fl = 'margin-top:'.$filter_mr_top.'px;';
    }

    $filter_style_css = ( $mr_bt_fl  ||  $mr_top_fl ) ? 'style='.$mr_bt_fl.$mr_top_fl. '' : '';

    $load_enable = '';
    if($pagination == 'infinite') {
        $load_enable = 'fl-infinite-enable';
    }
    $cl_btn = $mr_bt_btn = $mr_top_btn = $text_cl_btn = $border_width = $css_result_pagination ='';

    if($pagination !=='standard'){
       if($btn_mr_bt){
           $mr_bt_btn = 'margin-bottom:'.$btn_mr_bt.'px;';
       }
       if($btn_mr_top){
           $mr_top_btn = 'margin-top:'.$btn_mr_top.'px;';
       }
       if($btn_text_cl){
           $text_cl_btn = 'color:'.$btn_text_cl.';';
       }

       if($btn_style =='fl_btn_bg'){
           if($btn_cl){
               $cl_btn = 'background:'.$btn_cl.';';
           }
       }
       if($btn_style =='fl_btn_br'){
           if($btn_cl_br){
               $cl_btn = 'border-color:'.$btn_cl_br.';';
           }
           if($width_border){
               $border_width = 'border-width:'.$width_border.'px solid;';
           }
       }
   } else {
        if($btn_mr_bt){
            $mr_bt_btn = 'margin-bottom:'.$btn_mr_bt.'px;';
        }
        if($btn_mr_top){
            $mr_top_btn = 'margin-top:'.$btn_mr_top.'px;';
        }
   }
    $btn_style_css = ( $mr_bt_btn  ||  $mr_top_btn || $cl_btn || $text_cl_btn || $border_width ) ? 'style='.$mr_bt_btn.$mr_top_btn. $cl_btn. $text_cl_btn. $border_width.'' : '';


    switch ($blog_style) {
        case 'standard' :
            $post_div_class = 'fl-standard-post-item';
            $header_size = 'h4';
            $column_setting = '1';
            $gap_hor = $ver_gap;
            $gap_ver = '0';
            break;
        case 'grid' :
            $post_div_class = 'fl-grid-post-item';
            $header_size = 'h5';
            $column_setting = $column_grid_masonry;
            $gap_hor = $ver_gap;
            $gap_ver = $hor_gap;
            break;
        case 'masonry' :
            $post_div_class = 'fl-masonry-post-item';
            $header_size = 'h5';
            $column_setting = $column_grid_masonry;
            $gap_hor = $ver_gap;
            $gap_ver = $hor_gap;
            break;
    }


    if($column_setting >= '2'){
        $column_responsive = '2';
    } else {
        $column_responsive = '1';
    }


    ob_start();
    ?>



    <div class="fl_content_story-vc <?php echo fl_sanitize_class($class)?>">
        <div class="fl_content-vc">

            <?php if($filter !== 'disable') { ?>
                <div class="fl_post_filter <?php echo $filter_style.' '.$animation_count; ?>" id="<?php echo $idf ?>-filter" <?php echo  $filter_style_css;?>>
                    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item fl-post-filter-item"><span><?php echo esc_html_e('All','rest') ;?></span><?php echo $counter_filter ;?><span class="fl-filter-line"></span></div>
                    <?php echo $output_filter;?>
                </div>
            <?php  } ?>

                <div class="fl-post-list-vc <?php echo $load_enable ;?> cbp cf " id="<?php echo $idf; ?>">
                    <?php if ( $blog_posts->have_posts() ) {
                    while ( $blog_posts->have_posts() ) {
                        $blog_posts->the_post(); ?>

                        <article <?php post_class(''.$post_div_class.' fl-post-box cbp-item item cf')?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                               <div class="fl-post-flex-blog">
                                   <div class="fl-post-holder">
                                       <a href="<?php the_permalink(); ?>">
                                           <?php if ($blog_style == 'masonry'){
                                                       if($column_setting == "2") {
                                                           if ($i == 1 || $i == 4  || $i == 7) {
                                                               echo get_the_post_thumbnail($blog_posts->ID, 'size_800x1000_crop');
                                                           } else {
                                                               echo get_the_post_thumbnail($blog_posts->ID, 'size_1000x800_crop');
                                                           }
                                                       } elseif($column_setting == "3"){
                                                           if ($i == 1 || $i == 3 || $i == 6 ) {
                                                               echo get_the_post_thumbnail($blog_posts->ID, 'size_800x1000_crop');
                                                           } else {
                                                               echo get_the_post_thumbnail($blog_posts->ID, 'size_1000x800_crop');
                                                           }
                                                       }  ?>

                                               <?php } else {
                                                    echo get_the_post_thumbnail($blog_posts->ID, 'size_1170x668_crop');
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
                        <?php wp_reset_postdata();
                        $i ++;
                    } ?>

        <?php } else { ?>
            <div class="cbp-item item cf"><span><?php esc_html_e( 'Add some posts in Posts section', 'fl-themes-helper' )?></span></div>
        <?php }
        ?>
                 </div>
        </div>
        <?php if($pagination == 'load_more'){
            if ( $blog_posts->max_num_pages > 1) {
                wp_enqueue_script( 'fl-load-more-post-vc', plugins_url(  '../../assets/js/post_load_more/post-load-more.js', __FILE__  ));
                wp_localize_script( 'fl-load-more-post-vc', 'restloadmorepostvc', $args  );?>
                <div class="fl-pagination-container">
                    <div class="fl-load-more-btn-post fl-loading-more-enable-vc <?php echo $btn_style .' '.$shape .' '.$fl_btn_effects.' '.$size.' '.$button_block  ;?>" data-max-page="<?php echo $max_page_data; ?>" data-grid="<?php echo $blog_style; ?>" data-post-per-page="<?php echo $count; ?>" data-posts-column="<?php echo $column_setting; ?>" data-excerpt-limit="<?php echo $excerpt_limit; ?>" <?php echo $btn_style_css;?> id="<?php echo $idf; ?>-btn"><?php echo esc_html_e('Load More','fl-themes-helper'); ?></div>
                </div>
            <?php } ?>
        <?php }  elseif($pagination == 'infinite') {
            if ( $blog_posts->max_num_pages > 1) {
                wp_enqueue_script( 'fl-load-more-infinite-post-vc', plugins_url(  '../../assets/js/post_load_more/post-load-more-infinite.js', __FILE__  ));
                wp_localize_script( 'fl-load-more-infinite-post-vc', 'restloadmoreinfinitepost', $args  );?>
                <div class="fl-pagination-container">
                    <div class="fl-load-more-btn-post fl-loading-enable-infinite-vc <?php echo $btn_style .' '.$shape .' '.$size.' '.$button_block  ;?>" data-max-page="<?php echo $max_page_data; ?>" data-grid="<?php echo $blog_style; ?>" data-post-per-page="<?php echo $count; ?>" data-posts-column="<?php echo $column_setting; ?>" data-excerpt-limit="<?php echo $excerpt_limit; ?>" <?php echo $btn_style_css;?>><?php echo esc_html_e('Load More','fl-themes-helper'); ?></div>
                </div>
            <?php } ?>
        <?php } else {
            if (function_exists("fl_custom_pagination")) {
                echo '<div class="fl-pagination-container fl-default-pagination cf" '. $btn_style_css.'>
                          <div class="fl-simple-pagination '.$btn_style.' '.$shape .' '.$size.' '.$button_block.'"  id="'.$idf.'-simple-pagination">';
                            fl_custom_pagination($blog_posts->max_num_pages);
                echo '    </div>
                      </div>';
            } ?>
        <?php } ?>

    </div>
    <script type="text/javascript">
        jQuery.noConflict()(document).ready( function() {
            jQuery('#<?php echo $idf ;?>').cubeportfolio({
                filters: '#<?php echo $idf?>-filter',
                layoutMode: 'grid',
                defaultFilter: '*',
                gapHorizontal:  <?php echo $gap_hor;?>,
                gapVertical:    <?php echo $gap_ver;?>,
                animationType: '<?php echo $animation_type;?>',
                gridAdjustment: 'responsive',
                mediaQueries: [{
                    width: 1050,
                    cols: <?php echo esc_attr($column_setting) ;?>
                },  {
                    width: 450,
                    cols: <?php echo esc_attr($column_responsive) ?>
                },{
                    width: 350,
                    cols: 1
                }],
                caption: 'overlayBottomAlong',
                displayType: '<?php echo $display_type;?>',
                displayTypeSpeed: <?php echo $displaytypespeed;?>
            });

        });
    </script>
    <style type="text/css" data-type="vc_custom-css">
        #<?php echo $idf ;?>-filter .cbp-filter-item-active .fl-filter-line{
            background: <?php echo $filter_a_cl?>;
        }
        #<?php echo $idf ;?>-filter .cbp-filter-item-active{
            color: <?php echo $filter_a_cl?>!important;
        }
        #<?php echo $idf ;?>-filter .fl-post-filter-item{
            color: <?php echo $filter_cl?>;
        }
        #<?php echo $idf ;?>-filter .fl-post-filter-item:hover{
            color: <?php echo $filter_a_cl?>;
        }
        #<?php echo $idf ;?>-filter .fl-post-filter-item:hover .fl-filter-line{
            background: <?php echo $filter_a_cl?>;
        }
        <?php if($fl_btn_hv_color_enable !=='disable'){ ?>
        #<?php echo $idf ;?>-btn:hover{
            background-color: <?php echo $btn_hv_bg_cl;?>!important;
            color: <?php echo $btn_hv_text_cl ;?>!important;
        }
        <?php } ?>
        <?php if($pagination =='standard'){ ?>
        #<?php echo $idf ;?>-simple-pagination .page-numbers{
        <?php
            if($btn_text_cl){
                echo 'color:'.$btn_text_cl.'!important;';
            }
            if($btn_style =='fl_btn_bg'){
                if($btn_cl){
                   echo 'background:'.$btn_cl.'!important;';
                }
            }
            if($btn_style =='fl_btn_br'){
                if($btn_cl_br){
                    echo 'border-color:'.$btn_cl_br.'!important;';
                }
                if($width_border){
                    echo 'border-width:'.$width_border.'px solid!important;';
                }
            }?>
        }
        #<?php echo $idf ;?>-simple-pagination .page-numbers:hover{
        <?php
            if($btn_sp_hv_bg_cl){
                echo 'color:'.$btn_sp_hv_bg_cl.'!important;';
            }
            if($btn_style =='fl_btn_bg'){
                if($btn_sp_hv_text_cl){
                   echo 'background:'.$btn_sp_hv_text_cl.'!important;';
                }
            }
            if($btn_style =='fl_btn_br'){
                if($btn_sp_hv_text_cl){
                    echo 'border-color:'.$btn_sp_hv_text_cl.'!important;';
                }
            }?>
        }
        #<?php echo $idf ;?>-simple-pagination .current ,.page-numbers:focus{
        <?php
            if($btn_sp_hv_bg_cl){
                echo 'color:'.$btn_sp_hv_bg_cl.'!important;';
            }
            if($btn_style =='fl_btn_bg'){
                if($btn_sp_hv_text_cl){
                   echo 'background:'.$btn_sp_hv_text_cl.'!important;';
                }
            }
            if($btn_style =='fl_btn_br'){
                if($btn_sp_hv_text_cl){
                    echo 'border-color:'.$btn_sp_hv_text_cl.'!important;';
                }
            }?>
        }
        <?php } ?>
    </style>


    <?php

    return ob_get_clean();
}

add_action('vc_before_init', 'vc_fl_posts_shortcode');

function vc_fl_posts_shortcode() {

    if(function_exists('vc_map')) {
        vc_map( array(
            'name'            => esc_html__( 'Blog posts', 'fl-themes-helper' ),
            'base'            => 'vc_fl_posts',
            'category'        => esc_html__( 'Fl Theme', 'fl-themes-helper' ),
            'icon'            => 'fl-icon icon-fl-blog',
            'controls'        => 'full',
            'weight'          => 900,
            'params' => array(
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Items Count", "fl-themes-helper" ),
                    "description"       => esc_html__( "Specify the items count or insert '-1' to show all posts.", "fl-themes-helper" ),
                    "param_name"        => "count",
                    'admin_label'       => true,
                    'value'             => 8,
                    'min'               => -1,
                    'max'               => 999999,
                    'step'              => 1,
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Blog post style", "fl-themes-helper" ),
                    'std'               => 'standard',
                    'admin_label'       => true,
                    "param_name"        => "blog_style",
                    "value" => array(
                        'Standard Blog Style'              => 'standard',
                        'Grid Blog Style'                  => 'grid',
                        'Masonry Blog Style'               => 'masonry',
                    ),
                    "description"       => esc_html__( "Select the Grid layout style.", "fl-themes-helper" )
                ),

                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Column", "fl-themes-helper" ),
                    'std'               => '3',
                    'group'             => esc_html__( 'Column Setting', 'fl-themes-helper'),
                    "param_name"        => "column_grid_masonry",
                    'admin_label'       => true,
                    "value" => array(
                        'Two Columns'                       => '2',
                        'Three Columns'                     => '3',
                    ),
                    'dependency'        => array(
                        'element'       => 'blog_style',
                        'value'         => array('masonry','grid'),
                    ),
                    "description"       => esc_html__( "Select how many columns to display posts.", "fl-themes-helper" )
                ),

                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Number of Words in Description", "fl-themes-helper" ),
                    "param_name"        => "excerpt_limit",
                    'admin_label'       => true,
                    'value'             => 15,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'description'       => esc_html__('Specify the Number of Words for Description blog per post.', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Horizontal Gap ", "fl-themes-helper" ),
                    "param_name"        => "hor_gap",
                    'group'             => esc_html__( 'Column Setting', 'fl-themes-helper'),
                    'admin_label'       => true,
                    'value'             => 30,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'dependency'        => array(
                        'element'       => 'blog_style',
                        'value'         => array('masonry','grid'),
                    ),
                    'edit_field_class'  => 'vc_col-sm-3',
                    'description'       => esc_html__('Horizontal gap between items.', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Vertical Gap ", "fl-themes-helper" ),
                    "param_name"        => "ver_gap",
                    'group'             => esc_html__( 'Column Setting', 'fl-themes-helper'),
                    'admin_label'       => true,
                    'value'             => 30,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'edit_field_class'  => 'vc_col-sm-3',
                    'description'       => esc_html__('Vertical gap between items.', 'fl-themes-helper'),
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Filter", "fl-themes-helper" ),
                    'std'               => 'disable',
                    "param_name"        => "filter",
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                    "value" => array(
                        'Enable'                              => 'enable',
                        'Disable'                             => 'disable',
                    ),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Filter Margin top", "fl-themes-helper" ),
                    "param_name"        => "filter_mr_top",
                    'value'             => 15,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Filter Margin bottom", "fl-themes-helper" ),
                    "param_name"        => "filter_mr_bt",
                    'value'             => 15,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Filter color', 'fl-themes-helper'),
                    'param_name'        => 'filter_cl',
                    'value'             => '',
                    'std'               => '#1f1f1f',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Active filter color', 'fl-themes-helper'),
                    'param_name'        => 'filter_a_cl',
                    'value'             => '',
                    'std'               => '#000000',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                ),

                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Filter Animation', 'fl-themes-helper'),
                    'description'       => esc_html__('Animate the appearance of the following elements.', 'fl-themes-helper'),
                    'param_name'        => 'animation_type',
                    'std'               => 'fadeOut',
                    'value' => array(
                        esc_html__('Slide Left', 'fl-themes-helper')                => 'slideLeft',
                        esc_html__('Fade Out', 'fl-themes-helper')                  => 'fadeOut',
                        esc_html__('Quick Sand', 'fl-themes-helper')                => 'quicksand',
                        esc_html__('Fade Out Top', 'fl-themes-helper')              => 'fadeOutTop',
                        esc_html__('Sequentially', 'fl-themes-helper')              => 'sequentially',
                        esc_html__('Skew', 'fl-themes-helper')                      => 'skew',
                        esc_html__('Bounce Left', 'fl-themes-helper')               => 'bounceLeft',
                        esc_html__('Bounce Top', 'fl-themes-helper')                => 'bounceTop',
                        esc_html__('Bounce Bottom', 'fl-themes-helper')             => 'bounceBottom',
                        esc_html__('Move Left', 'fl-themes-helper')                 => 'moveLeft',
                        esc_html__('Scale Sides', 'fl-themes-helper')               => 'scaleSides',
                        esc_html__('Front Row', 'fl-themes-helper')                 => 'frontRow',
                        esc_html__('3D Flip', 'fl-themes-helper')                   => '3dflip',
                        esc_html__('Rotate Sides', 'fl-themes-helper')              => 'rotateSides',
                        esc_html__('Flip Out Delay', 'fl-themes-helper')            => 'flipOutDelay',
                        esc_html__('Flip Out', 'fl-themes-helper')                  => 'flipOut',
                        esc_html__('Unfold', 'fl-themes-helper')                    => 'unfold',
                        esc_html__('Fold Left', 'fl-themes-helper')                 => 'foldLeft',
                        esc_html__('Scale Down', 'fl-themes-helper')                => 'scaleDown',
                        esc_html__('Flip Bottom', 'fl-themes-helper')               => 'flipBottom',
                        esc_html__('Rotate Room', 'fl-themes-helper')               => 'rotateRoom',
                    ),
                    'dependency'        => array(
                        'element'       => 'filter',
                        'value'         => 'enable',
                    ),
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Select filter style", "fl-themes-helper" ),
                    'std'               => 'fl_filter_style_one',
                    "param_name"        => "filter_style",
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'dependency'        => array(
                        'element'       => 'filter',
                        'value'         => 'enable',
                    ),
                    "value" => array(
                        'Style One'                                 => 'fl_filter_style_one',
                        'Style Two'                                 => 'fl_filter_style_two',
                    ),
                ),

                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Filter counter", "fl-themes-helper" ),
                    'std'               => 'disable',
                    "param_name"        => "filter_counter",
                    'edit_field_class'  => 'vc_col-sm-6',
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                    "value" => array(
                        'Enable'                              => 'enable',
                        'Disable'                             => 'disable',
                    ),
                    'dependency'        => array(
                        'element'       => 'filter',
                        'value'         => 'enable',
                    ),
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Counter animation", "fl-themes-helper" ),
                    'std'               => '',
                    'group'             => esc_html__( 'Filter Setting', 'fl-themes-helper'),
                    "param_name"        => "animation_count",
                    "value" => array(
                        'Static'                             => '',
                        'TopForButton'                       => 'animation_counter_2',
                        'Opacity'                            => 'animation_counter_3',
                    ),
                    'dependency'        => array(
                        'element'       => 'filter_counter',
                        'value'         => 'enable',
                    ),
                ),

                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Pagination on page", "fl-themes-helper" ),
                    "param_name"        => "pagination",
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'std'               => array('load_more'),
                    "value" => array(
                        esc_html__('Load More Button','fl-themes-helper')       => 'load_more',
                        esc_html__('Infinite Scroll','fl-themes-helper')        => 'infinite',
                        esc_html__('Standard','fl-themes-helper')               => 'standard'
                    ),
                    "description"       => esc_html__( "Select how many columns to display posts.", "fl-themes-helper" )
                ),
                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Button Style', 'fl-themes-helper' ),
                    'description'            => esc_html__( 'Select button style.', 'fl-themes-helper' ),
                    'param_name'             => 'btn_style',
                    'std'                    => 'fl_btn_bg',
                    'value'                  => array(
                        esc_html__( 'Background', 'fl-themes-helper' )     => 'fl_btn_bg',
                        esc_html__( 'Border', 'fl-themes-helper' )         => 'fl_btn_br',
                    ),
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value_not_equal_to'        => 'none',
                    ),
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Button Margin bottom", "fl-themes-helper" ),
                    "param_name"        => "btn_mr_bt",
                    'value'             => 0,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value_not_equal_to'        => 'none',
                    ),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Button Margin top", "fl-themes-helper" ),
                    "param_name"        => "btn_mr_top",
                    'value'             => 35,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value_not_equal_to'        => 'none',
                    ),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Button background color', 'fl-themes-helper'),
                    'param_name'        => 'btn_cl',
                    'value'             => '',
                    'std'               => '#1f1f1f',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'btn_style',
                        'value'        => 'fl_btn_bg',
                    ),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Button border color', 'fl-themes-helper'),
                    'param_name'        => 'btn_cl_br',
                    'value'             => '',
                    'std'               => '#1f1f1f',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'btn_style',
                        'value'                     => 'fl_btn_br',
                    ),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Button text color', 'fl-themes-helper'),
                    'param_name'        => 'btn_text_cl',
                    'value'             => '',
                    'std'               => '#ffffff',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value_not_equal_to'        => 'none',
                    ),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Button border wight", "fl-themes-helper" ),
                    "param_name"        => "width_border",
                    'value'             => 1,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'btn_style',
                        'value'                     => 'fl_btn_br',
                    ),
                ),


                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Shape', 'fl-themes-helper' ),
                    'description'            => esc_html__( 'Select button shape.', 'fl-themes-helper' ),
                    'param_name'             => 'shape',
                    'std'                    => 'fl_btn_square',
                    'value'                  => array(
                        esc_html__( 'Rounded', 'fl-themes-helper' )     => 'fl_btn_rounded',
                        esc_html__( 'Square', 'fl-themes-helper' )      => 'fl_btn_square',
                        esc_html__( 'Round', 'fl-themes-helper' )       => 'fl_btn_round',
                    ),
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4',
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value_not_equal_to'        => 'none',
                    ),
                ),
                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Button hover effects', 'fl-themes-helper' ),
                    'description'            => esc_html__( 'Select button hover effects.', 'fl-themes-helper' ),
                    'param_name'             => 'fl_btn_effects',
                    'value'                  => array(
                        esc_html__( 'None', 'fl-themes-helper' )        => '',
                        esc_html__( 'ZoomOut', 'fl-themes-helper' )     => 'fl_btn_hr_style_1',
                        esc_html__( 'ZoomIn', 'fl-themes-helper' )      => 'fl_btn_hr_style_2',
                        esc_html__( 'MoveUP', 'fl-themes-helper' )      => 'fl_btn_hr_style_3',
                        esc_html__( 'Opacity', 'fl-themes-helper' )     => 'fl_btn_hr_style_4',
                    ),
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4',
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value'                     => 'load_more',
                    ),
                ),
                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Button hover color', 'fl-themes-helper' ),
                    'param_name'             => 'fl_btn_hv_color_enable',
                    'std'                    => 'disable',
                    'value'                  => array(
                        esc_html__( 'Disable', 'fl-themes-helper' )          => 'disable',
                        esc_html__( 'Enable', 'fl-themes-helper' )           => 'enable',
                    ),
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4',
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value'                     => 'load_more',
                    ),
                ),
                array(
                    'type'                      => 'colorpicker',
                    'heading'                   => esc_html__( 'Hover text color', 'fl-themes-helper' ),
                    'param_name'                => 'btn_hv_text_cl',
                    'value'                     => '',
                    'dependency'             => array(
                        'element'               => 'fl_btn_hv_color_enable',
                        'value'                 => 'enable',
                    ),
                    'std'                       => '#1f1f1f',
                    'edit_field_class'          => 'vc_col-sm-4',
                    'group'                     => esc_html__( 'Pagination', 'fl-themes-helper'),
                ),
                array(
                    'type'                      => 'colorpicker',
                    'heading'                   => esc_html__( 'Hover background color', 'fl-themes-helper' ),
                    'param_name'                => 'btn_hv_bg_cl',
                    'value'                     => '',
                    'dependency'             => array(
                        'element'               => 'fl_btn_hv_color_enable',
                        'value'                 => 'enable',
                    ),
                    'edit_field_class'          => 'vc_col-sm-4',
                    'std'                       => '#1f1f1f',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                ),
                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Button width', 'fl-themes-helper' ),
                    'param_name'             => 'button_block',
                    'description'            => esc_html__( 'Select button width: Normal or Full Width.', 'fl-themes-helper' ),
                    'std'                    => '',
                    'edit_field_class'       => 'vc_col-sm-6',
                    'value'                  => array(
                        esc_html__( 'Normal', 'fl-themes-helper' )      => '',
                        esc_html__( 'Full Width', 'fl-themes-helper' )  => 'fl_btn_full',
                    ),
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value_not_equal_to'        => 'standard',
                    ),
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                ),
                array(
                    'type'                   => 'dropdown',
                    'heading'                => esc_html__( 'Size', 'fl-themes-helper' ),
                    'param_name'             => 'size',
                    'description'            => esc_html__( 'Select button display size.', 'fl-themes-helper' ),
                    'std'                    => 'fl_btn_medium',
                    'edit_field_class'       => 'vc_col-sm-6',
                    'value'                  => array(
                        esc_html__( 'S', 'fl-themes-helper' )           => 'fl_btn_small',
                        esc_html__( 'M', 'fl-themes-helper' )           => 'fl_btn_medium',
                        esc_html__( 'L', 'fl-themes-helper' )           => 'fl_btn_large',
                    ),
                    'dependency' => array(
                        'element'                   => 'pagination',
                        'value_not_equal_to'        => 'none',
                    ),
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                ),
                array(
                    'type'                      => 'colorpicker',
                    'heading'                   => esc_html__( 'Hover and active text color', 'fl-themes-helper' ),
                    'param_name'                => 'btn_sp_hv_text_cl',
                    'value'                     => '',
                    'dependency'             => array(
                        'element'               => 'pagination',
                        'value'                 => 'standard',
                    ),
                    'std'                       => '#1f1f1f',
                    'edit_field_class'          => 'vc_col-sm-4',
                    'group'                     => esc_html__( 'Pagination', 'fl-themes-helper'),
                ),
                array(
                    'type'                      => 'colorpicker',
                    'heading'                   => esc_html__( 'Hover and active background color', 'fl-themes-helper' ),
                    'param_name'                => 'btn_sp_hv_bg_cl',
                    'value'                     => '',
                    'dependency'             => array(
                        'element'               => 'pagination',
                        'value'                 => 'standard',
                    ),
                    'edit_field_class'          => 'vc_col-sm-4',
                    'std'                       => '#f1f1f1',
                    'group'             => esc_html__( 'Pagination', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Display Type', 'fl-themes-helper'),
                    'description'       => esc_html__('Animate the appearance of the following elements.', 'fl-themes-helper'),
                    'param_name'        => 'display_type',
                    'std'               => 'default',
                    'value' => array(
                        esc_html__('Default', 'fl-themes-helper')                   => 'default',
                        esc_html__('Bottom to Top', 'fl-themes-helper')             => 'bottomToTop',
                        esc_html__('Fade In Top', 'fl-themes-helper')               => 'fadeInToTop',
                        esc_html__('Fade In', 'fl-themes-helper')                   => 'fadeIn',
                        esc_html__('Sequentially', 'fl-themes-helper')              => 'sequentially',
                    ),
                    'group'             => esc_html__( 'Style Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Display Type Speed", "fl-themes-helper" ),
                    "description"       => esc_html__( "Default speed 150ms.", "fl-themes-helper" ),
                    "param_name"        => "displaytypespeed",
                    'edit_field_class'  => 'vc_col-sm-3',
                    'admin_label'       => true,
                    'value'             => 150,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 50,
                    'group'             => esc_html__( 'Style Setting', 'fl-themes-helper'),
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
