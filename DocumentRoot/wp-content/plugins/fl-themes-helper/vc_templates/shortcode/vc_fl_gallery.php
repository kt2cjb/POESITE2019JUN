<?php
/*
 * Shortcode Blog
 * */

add_shortcode('vc_fl_gallery', 'vc_fl_gallery_function');

function vc_fl_gallery_function($atts, $content = null) {
    extract(shortcode_atts(array(
        'animation_type'            => 'fadeOut',
        'displaytypespeed'          => '150',
        'display_type'              => 'default',
        'grid'                      => 'grid',
        'grid_column_setting'       => 'three_column',
        'hor_gap'                   => 30,
        'ver_gap'                   => 30,
        'images'                    => '',
        'img_style'                 => 'standard',
        'fl_img_effects'            => '',
        'masonry_style'             => 'one',
        'class'                     => '',
        'vc_css'                    => '',
    ), $atts));



    $idf = uniqid('fl-gallery');

    $class .= fl_get_css_tab_class($atts);



    switch ($grid_column_setting) {
        case 'one_column' :
            $column_setting = '1';
            break;
        case 'two_column' :
            $column_setting = '2';
            break;
        case 'three_column' :
            $column_setting = '3';
            break;
        case 'four_column' :
            $column_setting = '4';
            break;
    }


    if($masonry_style == 'two'){
        $hor_gap  = '25';
        $ver_gap = '25';
    }

    $i = '0';

    $array_images = explode(',', $images);
    $images_str = '';

    foreach ($array_images as $attachment_id ) {
        $i = $i+1;
        $attachment = '';
        $attachment_full =  fl_get_attachment($attachment_id, 'full');
        switch ($grid) {
            case 'grid' :
                $attachment =  fl_get_attachment($attachment_id, 'size_1170x1170_crop');
                break;
            case 'masonry' :
                if($column_setting == '1'){
                    if ($i == 1 || $i == 3 || $i == 6 ) {
                        $attachment = fl_get_attachment( $attachment_id, 'size_800x1000_crop' ) ;
                    } else {
                        $attachment = fl_get_attachment( $attachment_id, 'size_1000x800_crop' ) ;
                    }
                } elseif ($column_setting == '2'){
                    if($masonry_style == 'one'){
                        if ($i == 12) {
                            $i='0';
                        }
                        if ($i == 1 || $i == 3 || $i == 5 || $i == 7 || $i == 9 || $i == 11) {
                            $attachment = fl_get_attachment( $attachment_id, 'size_800x1000_crop' ) ;
                        } else {
                            $attachment = fl_get_attachment( $attachment_id, 'size_1000x800_crop' ) ;
                        }
                    } else {
                        if ($i == 12) {
                            $i='0';
                        }
                        if ($i == 2 || $i == 6 ) {
                            $attachment = fl_get_attachment( $attachment_id, 'size_480x995_crop' ) ;
                        } else {
                            $attachment = fl_get_attachment( $attachment_id, 'size_480x480_crop' ) ;
                        }
                    }

                } elseif ($column_setting == '3'){
                    if($masonry_style == 'one'){
                        if ($i == 12) {
                            $i='0';
                        }
                        if ($i == 2 || $i == 4 || $i == 5 || $i == 8 || $i == 10 || $i == 11) {
                            $attachment = fl_get_attachment( $attachment_id, 'size_800x1000_crop' ) ;
                        } else {
                            $attachment = fl_get_attachment( $attachment_id, 'size_1000x800_crop' ) ;
                        }
                    } else {
                        if ($i == 10) {
                            $i='0';
                        }
                        if ($i == 3 || $i == 6 ) {
                            $attachment = fl_get_attachment( $attachment_id, 'size_480x995_crop' ) ;
                        } else {
                            $attachment = fl_get_attachment( $attachment_id, 'size_480x480_crop' ) ;
                        }
                    }
                } else {
                    if($masonry_style == 'one'){
                        if ($i == 8) {
                            $i='0';
                        }
                        if ( $i == 1 || $i == 3 || $i == 5 || $i == 6 ) {
                            $attachment = fl_get_attachment($attachment_id, 'size_800x1000_crop' ) ;
                        } else {
                            $attachment = fl_get_attachment( $attachment_id, 'size_1000x800_crop' ) ;
                        }
                    } else {
                        if ($i == 12) {
                            $i='0';
                        }
                        if ( $i == 1 || $i == 4 || $i == 9 || $i == 10 ) {
                            $attachment = fl_get_attachment( $attachment_id, 'size_480x995_crop' ) ;
                        } else {
                            $attachment = fl_get_attachment( $attachment_id, 'size_480x480_crop' ) ;
                        }
                    }
                }
                break;
            case 'rectangles' :
                $attachment = fl_get_attachment($attachment_id, 'size_1024x768_crop');
                break;
        }

        if (fl_check_option($attachment)) {
            if ($img_style == 'standard') {

                $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl-gallery-img cf ">';

            } elseif ($img_style == 'lightbox') {

                $image = '<a href="' . esc_url($attachment_full['src']) . '" data-lightbox="'.$idf.'" data-title="">
                                  <img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl-gallery-img cf">  
                          </a>';
            }
            $images_str .= '<div class="fl-gallery-img-box cbp-item item">
                                <div class="cf '.$fl_img_effects.'"> 
                                    '. $image . ' 
                                </div>
                            </div>';
        }
    }
        ob_start();
    ?>



    <div class="fl-gallery-box cf <?php echo fl_sanitize_class($class)?>">
        <div class="fl-gallery cf  cbp cf " id="<?php echo $idf;?>-container">
            <?php echo $images_str;?>
        </div>
    </div>
    <script type="text/javascript">
        jQuery.noConflict()(document).ready( function() {
            jQuery('#<?php echo $idf ;?>-container').cubeportfolio({
                filters: '#container-<?php echo $idf?>-filter',
                layoutMode: 'grid',
                defaultFilter: '*',
                gapHorizontal:  <?php echo $ver_gap;?>,
                gapVertical:    <?php echo $hor_gap;?>,
                animationType: '<?php echo $animation_type;?>',
                gridAdjustment: 'responsive',
                mediaQueries: [{
                    width: 800,
                    cols: <?php echo esc_attr($column_setting) ?>
                },  {
                    width: 450,
                    cols: 2
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

    <?php


    return ob_get_clean();

}

add_action('vc_before_init', 'vc_fl_gallery_shortcode');

function vc_fl_gallery_shortcode() {

    if(function_exists('vc_map')) {
        vc_map( array(
            'name'            => esc_html__( 'Gallery Image', 'fl-themes-helper' ),
            'base'            => 'vc_fl_gallery',
            'category'        => esc_html__( 'Fl Theme', 'fl-themes-helper' ),
            'icon'            => 'fl-icon icon-fl-work',
            'controls'        => 'full',
            'weight'          => 500,
            'params' => array(
                array(
                    "type"              => "dropdown",
                    "heading"           => esc_html__( "Image Grid Style", "fl-themes-helper" ),
                    'std'               => 'grid',
                    'admin_label'       => true,
                    "param_name"        => "grid",
                    "value" => array(
                        'Grid'                              => 'grid',
                        'Masonry'                           => 'masonry',
                        'Rectangles Wide'                   => 'rectangles',
                    ),
                    "description"       => esc_html__( "Select the Gallery layout style.", "fl-themes-helper" )
                ),

                array(
                    'type'              => 'attach_images',
                    'heading'           => esc_html__('Select Images', 'fl-themes-helper'),
                    'param_name'        => 'images',
                    'admin_label'       => false
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Column Setting', 'fl-themes-helper'),
                    'param_name'  => 'grid_column_setting',
                    'std'         => 'three_column',
                    'group'             => esc_html__( 'Column Setting', 'fl-themes-helper'),
                    'value'       => array(
                        esc_html__('One Column', 'fl-themes-helper')            => 'one_column',
                        esc_html__('Two Column', 'fl-themes-helper')            => 'two_column',
                        esc_html__('Three Column', 'fl-themes-helper')          => 'three_column',
                        esc_html__('Four Column', 'fl-themes-helper')           => 'four_column',
                    ),
                    'description' => ''
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Masonry Style', 'fl-themes-helper'),
                    'param_name'  => 'masonry_style',
                    'std'         => 'three_column',
                    'group'       => esc_html__( 'Column Setting', 'fl-themes-helper'),
                    'value'       => array(
                        esc_html__('One', 'fl-themes-helper')            => 'one',
                        esc_html__('Two', 'fl-themes-helper')            => 'two',
                    ),
                    'dependency' =>array(
                        'element' => 'grid',
                        'value' => 'masonry',
                    ),
                    array(
                        'element' => 'grid',
                        'value_not_equal_to' => array('grid','rectangles')
                    ),
                    'description' => ''
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
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Images Style', 'fl-themes-helper'),
                    'param_name'  => 'img_style',
                    'std'         => 'standard',
                    'value'       => array(
                        esc_html__('Default', 'fl-themes-helper')               => 'standard',
                        esc_html__('Light box', 'fl-themes-helper')             => 'lightbox',
                    ),
                    'description' => '',
                    'group'             => 'Image Setting'
                ),

                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__( 'Image effects', 'fl-themes-helper' ),
                    'description'       => esc_html__( 'Select image hover effects.', 'fl-themes-helper' ),
                    'param_name'        => 'fl_img_effects',
                    'value' => array(
                        esc_html__( 'None', 'fl-themes-helper' )                        => '',
                        esc_html__( 'ZoomIn', 'fl-themes-helper' )                      => 'fl_img_zoom_in',
                        esc_html__( 'ZoomOut', 'fl-themes-helper' )                     => 'fl_img_zoom_out',
                        esc_html__( 'GrayScaleIn', 'fl-themes-helper' )                 => 'fl_img_gray',
                        esc_html__( 'GrayScaleOut', 'fl-themes-helper' )                => 'fl_img_gray_out',
                        esc_html__( 'BrightnessIn', 'fl-themes-helper' )                => 'fl_img_brightness_in',
                        esc_html__( 'BrightnessOut', 'fl-themes-helper' )               => 'fl_img_brightness_out',
                        esc_html__( 'Blur', 'fl-themes-helper' )                        => 'fl_img_blur',
                    ),
                    'group' => 'Image Setting'
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
                    'group' => 'Image Setting'
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
                    'group' => 'Image Setting'
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