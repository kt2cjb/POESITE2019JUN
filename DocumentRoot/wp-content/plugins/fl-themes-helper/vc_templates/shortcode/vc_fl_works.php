<?php
/*
 * Shortcode Blog
 * */

add_shortcode('vc_fl_works', 'vc_fl_works_function');

function vc_fl_works_function($atts, $content = null) {
    extract(shortcode_atts(array(
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
        'grid'                      => 'grid',
        'column_count'              => '3',
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
        'size'			            => 'fl_btn_medium',
        'button_block'		        => '',
        'column_gap_hor'            => '30',
        'column_gap_ver'            => '30',
        'display_type'              => 'default',
        'displaytypespeed'          => '300',
        'mask_animation'            => 'fl-mask-animation-one',
        'img_hv_animation'          => '',
        'mask_bg'                   => 'rgba(0, 0, 0, 0.7)',
        'title_fz'                  => 23,
        'title_color'               => '#ffffff',
        'title_mr_bt'               => 15,
        'category_color'            => '#ffffff',
        'cat_fz'                    => 14,
        'mask_text_animation'       => 'fl-mask-txt-animation-one',
        'style_mask'                => '',
        'class'                     => '',
        'vc_css'                    => '',
    ), $atts));



    $idf = uniqid('fl-work-');

    $class .= fl_get_css_tab_class($atts);

    $max_page = new WP_Query( $pages = array('post_type' => 'works', 'posts_per_page'    => $count,));
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $args = array(
        'nonce'                 => wp_create_nonce( 'rest-load-more-work-nonce' ),
        'url'                   => admin_url( 'admin-ajax.php' ),
        'button_text'           => esc_attr__( 'Load More', 'fl-themes-helper' ),
        'button_text_no_post'   => esc_attr__( 'No more', 'fl-themes-helper' ),
        'button_loading'        => esc_attr__( 'Loading...', 'fl-themes-helper' ),
        'post_type'             => 'works',
        'post_status'           => 'publish',
        'works_category'        => 'works-category',
        'maxpage'               => $max_page->max_num_pages,
        'posts_per_page'        => $count,
        'paged'                 => $paged,
    );

    $recent_works = new WP_Query( $args );
    $i = '0';

    $max_page_data = $max_page->max_num_pages;

    if($filter_counter !== 'disable'){
        $counter_filter = '<div class="cbp-filter-counter"></div>';
    }  else {
        $counter_filter = '';
    }


    $output_filter = '';
    $categories = get_categories(array('taxonomy' => 'works-category'));
	foreach ($categories as $category) {
		$output_filter .= '<div data-filter=".works-category-'.$category->slug .'" class="cbp-filter-item fl-work-filter-item"><span>'.$category->name . '</span>'.$counter_filter.'<span class="fl-filter-line"></span></div>';
	}

    $cl_title = '';
    $mr_bt = '';
	if($title_color){
	    $cl_title = 'color:'.$title_color.';';
    }
    if($title_mr_bt){
	    $mr_bt = 'margin-bottom:'.$title_mr_bt.'px;';
    }
    $fz_title = '';
    if($title_fz){
        $fz_title ='font-size:'.$title_fz.'px!important;line-height:'.$title_fz.'px!important;';
    }

    if($style_mask !=='light_box') {
        $title_style_css = ( $cl_title ||  $mr_bt || $fz_title ) ? '#'.$idf.' .fl-work-title {'.$cl_title.$mr_bt.$fz_title. '}' : '';
    } else {
        $title_style_css = '#'.$idf.' i.fl-zoom:before,i.fl-zoom:after {background-color:'.$title_color.';}';
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


    $mr_bt_btn = '';
    if($btn_mr_bt){
        $mr_bt_btn = 'margin-bottom:'.$btn_mr_bt.'px;';
    }
    $mr_top_btn = '';
    if($btn_mr_top){
        $mr_top_btn = 'margin-top:'.$btn_mr_top.'px;';
    }
    $text_cl_btn = '';
    if($btn_text_cl){
        $text_cl_btn = 'color:'.$btn_text_cl.';';
    }
    $cl_btn = '';
    if($btn_style =='fl_btn_bg'){
      if($btn_cl){
          $cl_btn = 'background:'.$btn_cl.';';
      }
    }
    $border_width= '';
    if($btn_style =='fl_btn_br'){
        if($btn_cl_br){
            $cl_btn = 'border-color:'.$btn_cl_br.';';
        }
        if($width_border){
            $border_width = 'border-width:'.$width_border.'px solid;';
        }
    }
    $load_enable = '';
    if($pagination == 'infinite') {
        $load_enable = 'fl-infinite-enable';
    }


    $btn_style_css = ( $mr_bt_btn  ||  $mr_top_btn || $cl_btn || $text_cl_btn || $border_width ) ? 'style='.$mr_bt_btn.$mr_top_btn. $cl_btn. $text_cl_btn. $border_width.'' : '';

    if($column_count >= '2'){
        $responsive_column = '2';
    } else {
        $responsive_column = '1';
    }


    ob_start();
    ?>



    <div class="fl_content_story-vc <?php echo fl_sanitize_class($class)?>">
        <div class="fl_content-vc">

            <?php if($filter !== 'disable') { ?>
                <div class="fl_work_filter <?php echo $filter_style.' '.$animation_count; ?>" id="<?php echo $idf ?>-filter" <?php echo  $filter_style_css;?>>
                    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item fl-work-filter-item"><span><?php echo esc_html_e('All','rest') ;?></span><?php echo $counter_filter ;?><span class="fl-filter-line"></span></div>
                    <?php echo $output_filter;?>
                </div>
            <?php  } ?>

                <div class="fl-work-grid-style <?php echo $load_enable ;?> cbp cf" id="<?php echo $idf; ?>">
                    <?php if ( $recent_works->have_posts() ) {
                        while ( $recent_works->have_posts() ) {
                            $recent_works->the_post(); ?>

                    <article <?php post_class('fl-work-box cbp-item item cf')?> id="work-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                        <div class="fl-work-thumbnail <?php echo $img_hv_animation;?>">
                                    <?php if($grid == 'grid') {
                                        echo get_the_post_thumbnail( $recent_works->ID, 'size_1000x800_crop' );
                                    } elseif($grid == 'masonry'){
                                        if($column_count == '3'){
                                            if ($i == 1 || $i == 3 || $i == 6 ) {
                                                echo get_the_post_thumbnail( $recent_works->ID, 'size_800x1000_crop' ) ;
                                            } else {
                                                echo  get_the_post_thumbnail( $recent_works->ID, 'size_1000x800_crop' ) ;
                                            }
                                        } elseif ($column_count == '2'){
                                            if ($i == 1 || $i == 4  || $i == 7) {
                                                echo get_the_post_thumbnail( $recent_works->ID, 'size_800x1000_crop' ) ;
                                            } else {
                                                echo  get_the_post_thumbnail( $recent_works->ID, 'size_1000x800_crop' ) ;
                                            }
                                        } elseif ($column_count == '4'){
                                            if ($i == 0 || $i == 2 || $i == 4 || $i == 5) {
                                                echo get_the_post_thumbnail( $recent_works->ID, 'size_800x1000_crop' ) ;
                                            } else {
                                                echo  get_the_post_thumbnail( $recent_works->ID, 'size_1000x800_crop' ) ;
                                            }
                                        } else {
                                            if ($i == 0 || $i == 2 || $i == 4 || $i == 5 || $i == 6) {
                                                echo get_the_post_thumbnail( $recent_works->ID, 'size_800x1000_crop' ) ;
                                            } else {
                                                echo  get_the_post_thumbnail( $recent_works->ID, 'size_1000x800_crop' ) ;
                                            }
                                        }
                                    } else  {
                                        echo get_the_post_thumbnail( $recent_works->ID, 'size_1024x768_crop' ) ;
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
                                <a href="<?php echo get_the_post_thumbnail_url( $recent_works->ID, 'full' ); ?>" data-lightbox="<?php echo get_the_post_thumbnail_url( $recent_works->ID, 'full' ); ?>" data-title="<?php esc_attr(the_title()); ?>" class="fl-work-link"></a>
                                <div class="fl-work-mask <?php echo $mask_animation;?>">
                                    <div class="fl-work-info">
                                        <i class="fl-zoom"></i>
                                    </div>
                                </div>
                            <?php }?>
                   </article>


                        <?php wp_reset_postdata();
                        $i ++;
                    } ?>




<?php } else { ?>
      <div class="cbp-item item cf"><span><?php esc_html_e( 'Add some posts in Works section', 'fl-themes-helper' )?></span></div>
 <?php }
    ?>
                </div>
        </div>
            <?php if($pagination == 'load_more'){
                if ( $recent_works->max_num_pages > 1) {
                wp_enqueue_script( 'fl-load-more-work-vc', plugins_url(  '../../assets/js/work_load_more/work-load-more.js', __FILE__  ));
                wp_localize_script( 'fl-load-more-work-vc', 'restloadmoreworkvc', $args  );?>
               <div class="fl-pagination-container">
                    <div class="fl-load-more-btn-work fl-loading-more-enable-vc <?php echo $btn_style .' '.$shape .' '.$fl_btn_effects.' '.$size.' '.$button_block  ;?>" data-max-page="<?php echo $max_page_data; ?>" data-grid="<?php echo $grid; ?>" data-work-per-page="<?php echo $count; ?>" data-works-column="<?php echo $column_count; ?>" data-mask-animation="<?php echo $mask_animation; ?>" data-text-mask="<?php echo $mask_text_animation;?>" data-img-animation="<?php echo $img_hv_animation;?>" data-style-mask="<?php echo $style_mask;?>" <?php echo $btn_style_css;?> id="<?php echo $idf; ?>-btn"><?php echo esc_html_e('Load more','fl-themes-helper'); ?></div>
               </div>
            <?php } ?>
           <?php }  elseif($pagination == 'infinite') {
                if ( $recent_works->max_num_pages > 1) {
                    wp_enqueue_script( 'fl-load-more-infinite-work-vc', plugins_url(  '../../assets/js/work_load_more/work-load-more-infinite.js', __FILE__  ));
                    wp_localize_script( 'fl-load-more-infinite-work-vc', 'restloadmoreinfinite', $args  );?>
                    <div class="fl-pagination-container">
                        <div class="fl-load-more-btn-work fl-loading-enable-infinite-vc <?php echo $btn_style .' '.$shape .' '.$size.' '.$button_block  ;?>" data-max-page="<?php echo $max_page_data; ?>" data-grid="<?php echo $grid; ?>" data-work-per-page="<?php echo $count; ?>" data-works-column="<?php echo $column_count; ?>" data-mask-animation="<?php echo $mask_animation; ?>" data-text-mask="<?php echo $mask_text_animation;?>" data-img-animation="<?php echo $img_hv_animation;?>" data-style-mask="<?php echo $style_mask;?>" <?php echo $btn_style_css;?>><?php echo esc_html_e('Load more','fl-themes-helper'); ?></div>
                    </div>
                <?php } ?>
            <?php } else { ?>

            <?php } ?>

    </div>
        <script type="text/javascript">
            jQuery.noConflict()(document).ready( function() {
                jQuery('#<?php echo $idf ;?>').cubeportfolio({
                    filters: '#<?php echo $idf?>-filter',
                    layoutMode: 'grid',
                    defaultFilter: '*',
                    gapHorizontal:  <?php echo $column_gap_hor;?>,
                    gapVertical:    <?php echo $column_gap_ver;?>,
                    animationType: '<?php echo $animation_type;?>',
                    gridAdjustment: 'responsive',
                    mediaQueries: [{
                        width: 800,
                        cols: <?php echo esc_attr($column_count) ?>
                    },  {
                        width: 450,
                        cols: <?php echo esc_attr($responsive_column) ?>
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
        #<?php echo $idf ;?>-filter .fl-work-filter-item{
            color: <?php echo $filter_cl?>;
        }
        #<?php echo $idf ;?>-filter .fl-work-filter-item:hover{
            color: <?php echo $filter_a_cl?>;
        }
        #<?php echo $idf ;?>-filter .fl-work-filter-item:hover .fl-filter-line{
            background: <?php echo $filter_a_cl?>;
        }
        #<?php echo $idf ;?> .fl-work-category{
           color: <?php echo $category_color;?>;
            font-size: <?php echo $cat_fz;?>px;
        }
        <?php echo $title_style_css;?>
        #<?php echo $idf ;?> .fl-work-mask{
            background: <?php echo $mask_bg;?> ;
        }
        <?php if($fl_btn_hv_color_enable !=='disable'){ ?>
        #<?php echo $idf ;?>-btn:hover{
           background-color: <?php echo $btn_hv_bg_cl;?>!important;
           color: <?php echo $btn_hv_text_cl ;?>!important;
        }
        <?php } ?>
    </style>


    <?php

    return ob_get_clean();
}

add_action('vc_before_init', 'vc_fl_works_shortcode');

function vc_fl_works_shortcode() {

    if(function_exists('vc_map')) {
        vc_map( array(
            'name'            => esc_html__( 'Works post', 'fl-themes-helper' ),
            'base'            => 'vc_fl_works',
            'category'        => esc_html__( 'Fl Theme', 'fl-themes-helper' ),
            'icon'            => 'fl-icon icon-fl-work',
            'controls'        => 'full',
            'weight'          => 80,
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
                    "heading"           => esc_html__( "Work Style", "fl-themes-helper" ),
                    'std'               => 'grid',
                    'admin_label'       => true,
                    "param_name"        => "grid",
                    "value" => array(
                            'Grid'                              => 'grid',
                            'Masonry'                           => 'masonry',
                            'Rectangles Wide'                   => 'rectangles',
                    ),
                    "description"       => esc_html__( "Select the Grid layout style.", "fl-themes-helper" )
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Mask Style", "fl-themes-helper" ),
                    'std'               => 'grid',
                    'admin_label'       => true,
                    "param_name"        => "style_mask",
                    "value" => array(
                        'Link to work'                      => '',
                        'Light Box'                         => 'light_box',
                    ),
                ),

                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Column", "fl-themes-helper" ),
                    'std'               => '3',
                    'group'             => esc_html__( 'Column Setting', 'fl-themes-helper'),
                    "param_name"        => "column_count",
                    'admin_label'       => true,
                    "value" => array(
                            'Two Columns'                       => '2',
                            'Three Columns'                     => '3',
                            'Four Columns'                      => '4',
                            'Five Columns'                      => '5',
                    ),
                    "description"       => esc_html__( "Select how many columns to display posts.", "fl-themes-helper" )
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Horizontal Gap ", "fl-themes-helper" ),
                    "param_name"        => "column_gap_hor",
                    'group'             => esc_html__( 'Column Setting', 'fl-themes-helper'),
                    'admin_label'       => true,
                    'value'             => 30,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'edit_field_class'  => 'vc_col-sm-3',
                    'description'       => esc_html__('Horizontal gap between items.', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Vertical Gap ", "fl-themes-helper" ),
                    "param_name"        => "column_gap_ver",
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
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Hover Text Animation', 'fl-themes-helper'),
                    'param_name'        => 'mask_text_animation',
                    'std'               => 'fl-mask-txt-animation-one',
                    'value' => array(
                        esc_html__('Animation One', 'fl-themes-helper')             => 'fl-mask-txt-animation-one',
                        esc_html__('Animation Two', 'fl-themes-helper')             => 'fl-mask-txt-animation-two',
                        esc_html__('Animation Three', 'fl-themes-helper')           => 'fl-mask-txt-animation-three',
                    ),
                    'group'             => esc_html__( 'Text Settings', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           =>  esc_html__('Title color', 'fl-themes-helper'),
                    'param_name'        => 'title_color',
                    'value'             =>  '',
                    'std'               => '#ffffff',
                    'edit_field_class'  => 'vc_col-sm-4',
                    'group'             => esc_html__( 'Text Settings', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Title font size", "fl-themes-helper" ),
                    "param_name"        => "title_fz",
                    'admin_label'       => true,
                    'value'             => 23,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-4',
                    'group'             => esc_html__( 'Text Settings', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Title Margin bottom", "fl-themes-helper" ),
                    "param_name"        => "title_mr_bt",
                    'admin_label'       => true,
                    'value'             => 15,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-4',
                    'group'             => esc_html__( 'Text Settings', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           =>  esc_html__('Category color', 'fl-themes-helper'),
                    'param_name'        => 'category_color',
                    'value'             =>  '',
                    'std'               => '#ffffff',
                    'edit_field_class'  => 'vc_col-sm-4',
                    'group'             => esc_html__( 'Text Settings', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Category Font size", "fl-themes-helper" ),
                    "param_name"        => "cat_fz",
                    'admin_label'       => true,
                    'value'             => 14,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-4',
                    'group'             => esc_html__( 'Text Settings', 'fl-themes-helper'),
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
                            esc_html__('None','fl-themes-helper')                   => 'none'
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
                        'value_not_equal_to'        => 'none',
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
                    "description"       => esc_html__( "Default speed 300ms.", "fl-themes-helper" ),
                    "param_name"        => "displaytypespeed",
                    'admin_label'       => true,
                    'value'             => 300,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 50,
                    'group'             => esc_html__( 'Style Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Mask hover Animation', 'fl-themes-helper'),
                    'param_name'        => 'mask_animation',
                    'std'               => 'fl-mask-animation-one',
                    'edit_field_class'  => 'vc_col-sm-6',
                    'value' => array(
                        esc_html__('Animation One', 'fl-themes-helper')             => 'fl-mask-animation-one',
                        esc_html__('Animation Two', 'fl-themes-helper')             => 'fl-mask-animation-two',
                        esc_html__('Animation Three', 'fl-themes-helper')           => 'fl-mask-animation-three',
                    ),
                    'group'             => esc_html__( 'Style Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Image hover Animation', 'fl-themes-helper'),
                    'param_name'        => 'img_hv_animation',
                    'std'               => '',
                    'edit_field_class'  => 'vc_col-sm-6',
                    'value' => array(
                        esc_html__( 'None', 'fl-themes-helper' )                    => '',
                        esc_html__( 'ZoomIn', 'fl-themes-helper' )                  => 'fl_img_zoom_in',
                        esc_html__( 'ZoomOut', 'fl-themes-helper' )                 => 'fl_img_zoom_out',
                        esc_html__( 'GrayScaleIn', 'fl-themes-helper' )             => 'fl_img_gray',
                        esc_html__( 'GrayScaleOut', 'fl-themes-helper' )            => 'fl_img_gray_out',
                        esc_html__( 'BrightnessIn', 'fl-themes-helper' )            => 'fl_img_brightness_in',
                        esc_html__( 'BrightnessOut', 'fl-themes-helper' )           => 'fl_img_brightness_out',
                        esc_html__( 'Blur', 'fl-themes-helper' )                    => 'fl_img_blur',
                    ),
                    'group'             => esc_html__( 'Style Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Hover mask color', 'fl-themes-helper'),
                    'param_name'        => 'mask_bg',
                    'value'             => '',
                    'std'               => 'rgba(0, 0, 0, 0.7)',
                    'edit_field_class'  => 'vc_col-sm-3',
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