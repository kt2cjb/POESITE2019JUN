<?php
/*
 * Shortcode Alert
 * */

add_shortcode('vc_fl_video_box', 'vc_fl_video_box_function');

function vc_fl_video_box_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'img'               => '',
        'images_size'       => 'full',
        'icon_color'        => '#ffffff',
        'icon_size'         => 'normal',
        'layer_thickness'   => '4',
        'attach_image'      => '',
        'video_mask_bg'     => '',
        'video_link'        => 'rgba(0,0,0,0.4)',
        'icon_type'         => 'default',
        'time_video'        => '',
        'name_video'        => '',
        'name_font_size'    => 19,
        'time_font_size'    => 15,
        'name_color' 	    => '#1f1f1f',
        'time_color' 	    => '#5e5e5e',
        'name_mr_bt'	    => 0,
        'name_mr_tp'	    => 0,
        'class'             => '',
        'vc_css'            => '',
    ), $atts));

    $idf = uniqid('fl_video_box_');

    switch ($icon_type) {
        case 'flvideo':
            $icon = $atts['icon_flvideo'];
            break;
    }

    vc_icon_element_fonts_enqueue($icon_type);


    if($icon_size =='small'){
        $size_icon = '50px';
    } elseif ($icon_size=='normal'){
        $size_icon = '70px';
    }else {
        $size_icon = '100px';
    }

    $result = '';
    $class .= fl_get_css_tab_class($atts);

    $parallax_img = '';
    $data_speed = '';
    $data_android = '';
    $data_ios = '';

    if($img){
    $attachment = fl_get_attachment($img, $images_size);
    $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_single-img"><div class="fl_video-box-mask" style="background: '.$video_mask_bg.'"></div>';
    } else {
        $image ='';
    }

    if ($icon_type == 'flvideo') {
        $vc_icon = '<a class="venobox fl-video-link vbox-item cf" data-vbtype="youtube" href="'.$video_link.'">
                        <i class="fl-video-box-icon  ' . $icon . '" style="color:'.$icon_color.';font-size:'.$size_icon.' "></i>
                    </a>';
    } else {
        $vc_icon = '<a class="venobox fl-video-link vbox-item cf" data-vbtype="youtube" href="'.$video_link.'">
                        <svg x="0px" y="0px" width="'.$size_icon.'" height="'.$size_icon.'" viewBox="0 0 215.7 215.7" enable-background="new 0 0 215.7 215.7" xml:space="preserve" style="stroke:'.$icon_color.';">
                        <polygon class="fl-play-button-video"  fill="none" stroke-width="'.$layer_thickness.'" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "/>
                        <circle class="fl-border-button-play" id="'.$idf.'-icon" fill="none"  stroke-width="'.$layer_thickness.'" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke:'.$icon_color.';" />
                        </svg>
                    </a>';

    }


    $fz_name = $cl_name = $mb_name = $mt_name ='';

    if($name_font_size){
       $fz_name = 'font-size:'.$name_font_size.'px;';
    }

    if($name_color){
        $cl_name = 'color:'.$name_color.';';
    }
    if($name_mr_bt){
        $mb_name = 'margin-bottom:'.$name_mr_bt.'px;';
    }

    if($name_mr_tp){
        $mt_name = 'margin-top:'.$name_mr_tp.'px;';
    }

    $video_name_css_style= ( $fz_name || $cl_name ) ? 'style='.$fz_name.$cl_name.$mb_name.$mt_name.'' : '';


    $fz_time = $cl_time ='';
    if($time_font_size){
        $fz_time = 'font-size:'.$time_font_size.'px;';
    }

    if($time_color){
        $cl_time = 'color:'.$time_color.';';
    }

    $video_time_css_style= ( $fz_time || $cl_time ) ? 'style='.$fz_time. $cl_time.'' : '';


    $video_name = $video_time = '';

    if ($name_video) {
        $video_name = '<div class="fl-video-box-name h4" '.$video_name_css_style.'>'.$name_video.'</div>';
    }

    if ($time_video) {
        $video_time = '<div class="fl-video-box-time" '.$video_time_css_style.'>'.$time_video.'</div>';
    }


    $result .= '<div class="fl-video-box'. fl_sanitize_class($class) .$parallax_img.'" '.$data_speed. $data_android. $data_ios.' id="'.$idf.'">';

    $result .= $image;

    $result .= '<div class="fl-video-link-box">';

    $result .= $vc_icon;

    $result .= $video_name;

    $result .= $video_time;

    $result .= '</div>';

    $result .= '</div>';


    return $result;
}
add_action('vc_before_init', 'vc_fl_video_box_shortcode');

function vc_fl_video_box_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Video Box', 'fl-themes-helper'),
            'base'          => 'vc_fl_video_box',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'          => 'fl-icon icon-fl-video-box',
            'weight'        => 90,
            'controls'      => 'full',
            'params'        => array(
                array(
                    "type"              => "textfield",
                    "heading"           => esc_html__( "Video Link", "fl-themes-helper" ),
                    "param_name"        => "video_link",
                    "value"             => '',
                    "description"       => esc_html__( "Paste here a video from youtube. ex - ", "fl-themes-helper" )
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Select your icon', 'fl-themes-helper'),
                    'value'             => array(
                            esc_attr__('Default', 'fl-themes-helper')               => 'default',
                            esc_attr__('Custom', 'fl-themes-helper')                => 'flvideo',
                    ),
                    'param_name'        => 'icon_type',
                    'std'               => 'default',
                    'group'             => 'Icon'
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Line thickness', 'fl-themes-helper'),
                    'value' => array(
                            esc_attr__('Thin Default', 'fl-themes-helper')          => '4',
                            esc_attr__('Normal', 'fl-themes-helper')                => '7',
                            esc_attr__('Fatty', 'fl-themes-helper')                 => '10',
                    ),
                    'dependency' => array(
                            'element'                                   => 'icon_type',
                            'value'                                     => 'default'
                    ),
                    'param_name'        => 'layer_thickness',
                    'std'               => '4',
                    'group'             => 'Icon'
                ),
                array(
                    'type'              => 'iconpicker',
                    'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'        => 'icon_flvideo',
                    'settings' => array(
                            'emptyIcon'                                 => false,
                            'type'                                      => 'flvideo',
                            'iconsPerPage'                              => 300
                    ),
                    'dependency' => array(
                        'element'       => 'icon_type',
                        'value'         => 'flvideo'
                    ),
                    'group'             => 'Icon'
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Icon color', 'fl-themes-helper'),
                    'param_name'        => 'icon_color',
                    'admin_label'       => true,
                    'group'             => 'Icon',
                    'std'               => '#ffffff'
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Icon size', 'fl-themes-helper'),
                    'param_name'        => 'icon_size',
                    'admin_label'       => true,
                    'value' => array(
                            esc_attr__('Small', 'fl-themes-helper')                 => 'small',
                            esc_attr__('Normal', 'fl-themes-helper')                => 'normal',
                            esc_attr__('Large', 'fl-themes-helper')                 => 'large',
                    ),
                    'group'             => 'Icon',
                    'std'               => 'normal'
                ),
                array(
                    'type'              => 'attach_image',
                    'heading'           => esc_html__('Select Images', 'fl-themes-helper'),
                    'param_name'        => 'img',
                    'admin_label'       => false
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Img mask color', 'fl-themes-helper'),
                    'param_name'        => 'video_mask_bg',
                    'admin_label'       => true,
                    'std'               => 'rgba(0,0,0,0.4)'
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Images Size', 'fl-themes-helper'),
                    'param_name'        => 'images_size',
                    'std'               => 'full',
                    'value'             => fl_get_image_sizes(),
                    'description'       => ''
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'        => 'class',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    "type"              => "textfield",
                    'heading'           => esc_html__('Title name video', 'fl-themes-helper'),
                    "param_name"        => "name_video",
                    "value"             => esc_html__("", 'fl-themes-helper'),
                    "description"       => esc_html__("", 'fl-themes-helper'),
                    'std'               => '',
                    'group'             => 'Video Info',
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Name margin top", "fl-themes-helper" ),
                    "param_name"        => "name_mr_tp",
                    'value'             => 0,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Video Info',
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Name margin bottom", "fl-themes-helper" ),
                    "param_name"        => "name_mr_bt",
                    'value'             => 0,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Video Info',
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Name font size", "fl-themes-helper" ),
                    "param_name"        => "name_font_size",
                    'value'             => 19,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Video Info',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Name text color', 'fl-themes-helper'),
                    'param_name'        => 'name_color',
                    'value'             => '',
                    'std'               => '#363636',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Video Info',
                ),

                array(
                    "type"              => "textfield",
                    'heading'           => esc_html__('Time video', 'fl-themes-helper'),
                    "param_name"        => "time_video",
                    "value"             => esc_html__("", 'fl-themes-helper'),
                    "description"       => esc_html__("", 'fl-themes-helper'),
                    'std'               => '',
                    'group'             => 'Video Info',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Time text color', 'fl-themes-helper'),
                    'param_name'        => 'time_color',
                    'value'             => '',
                    'std'               => '#363636',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Video Info',
                ),
                array(
                    'type'              => 'fl_number',
                    "heading"           => esc_html__( "Time font size", "fl-themes-helper" ),
                    "param_name"        => "time_font_size",
                    'value'             => 15,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'group'             => 'Video Info',
                ),

                array(
                    'type'              => 'css_editor',
                    'heading'           => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'        => 'vc_css',
                    'group'             => esc_html__('Design Options', 'fl-themes-helper'),
                )
            ),
        ));
    }
}