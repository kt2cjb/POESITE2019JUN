<?php

/*
 * Shortcode Image single
 * */

add_shortcode('vc_fl_image_single', 'vc_fl_image_single_function');

function vc_fl_image_single_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'images_size'       => 'size_1170x668_crop',
        'fl_img_effects'    => '',
        'img_style'         => 'standard',
        'attach_image'      => '',
        'parallax_android'  => 'false',
        'parallax_ios'      => 'false',
        'parallax_speed'    => '0.6',
        'link'              => '',
        'img'               => '',
        'class'             => '',
        'vc_css'            => '',
    ), $atts));

    $class .= fl_get_css_tab_class($atts);
    $result = '';
    $idf = uniqid('fl_image_');

    $link_start = '';
    $link_str_end = '';
    $parallax_img = '';
    $data_speed = '';
    $data_android = '';
    $data_ios = '';
    if($img_style == 'standard'){
        $attachment = fl_get_attachment($img, $images_size);
        if($attachment['alt']){
            $attachment_alt = $attachment['alt'];
        } else {
            $attachment_alt = ' ';
        }
        $image = '<img src="' . esc_url($attachment['src']) . '" alt=" ' . esc_attr($attachment_alt) . ' " class="fl_single-img">';
    } elseif ($img_style == 'parallax'){
        $data_speed = 'data-speed="'.$parallax_speed.'"';
        $data_android = 'data-android-parallax="'.$parallax_android.'"';
        $data_ios = 'data-ios-parallax="'.$parallax_ios.'"';
        $parallax_img = 'fl-jarallax';
        $attachment = fl_get_attachment($img, $images_size);
        if($attachment['alt']){
            $attachment_alt = $attachment['alt'];
        } else {
            $attachment_alt = ' ';
        }

        $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment_alt) . '" class="fl_single-img-save" > 
                  <img  src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment_alt) . '" class="jarallax-img" >';
    } elseif ($img_style == 'link'){
        $attachment = fl_get_attachment($img, $images_size);
        if($attachment['alt']){
            $attachment_alt = $attachment['alt'];
        } else {
            $attachment_alt = ' ';
        }
        $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment_alt) . '" class="fl_single-img">';
        if ( fl_check_option($link) && function_exists('vc_build_link')) {
            $link = vc_build_link($link);
            if (fl_check_option($link)) {
                if($link['url']){
                    $link_url = $link['url'];
                }else {
                    $link_url = '#';
                }
                if($link['title']){
                    $link_title = $link['title'];
                } else {
                    $link_title = ' ';
                }
                if($link['target']){
                    $link_target = $link['target'];
                }else{
                    $link_target = '_self';
                }
                $link_start =' <a class="img_single " href="'.$link_url.'" title="'.$link_title.'"  target="'.$link_target.'" >';
                $link_str_end = '</a>';
            }
        }
    } else {
        $attachment = fl_get_attachment($img, $images_size);
        $image = '<a href="' . esc_url($attachment['src']) . '" data-lightbox="' . esc_url($attachment['src']) . '" data-title=" " class="fl_single-img-link">
                    <img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_single-img">  
                  </a>';
    }


    if($img_style !=='parallax'){
        $img_hover_effect = $fl_img_effects;
    } else {
        $img_hover_effect = '';
    }


    $result .= '<div class="fl-single-img cf '.$parallax_img. fl_sanitize_class($class). $img_hover_effect.'" id="'.$idf.'" '.$data_speed. $data_android. $data_ios.' >';

    $result.= $link_start;

    $result .= $image;

    $result.= $link_str_end;

    $result .= '</div>';

    return $result;

}

add_action('vc_before_init', 'vc_fl_image_single_shortcode');

function vc_fl_image_single_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Image single', 'fl-themes-helper'),
		'base'          => 'vc_fl_image_single',
        'icon'          => 'fl-icon icon-fl-img-single',
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'weight'        => 500,
		'params' => array(
            array(
                'type'              => 'attach_image',
                'heading'           => esc_html__('Select Images', 'fl-themes-helper'),
                'param_name'        => 'img',
                'admin_label'       => false
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Images Size', 'fl-themes-helper'),
                'param_name'        => 'images_size',
                'std'               => 'size_1170x668_crop',
                'value'             => fl_get_image_sizes(),
                'description'       => ''
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
                'dependency' => array(
                    'element'                   => 'img_style',
                    'value_not_equal_to'        => array( 'parallax' ),
                ),
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Parallax in android device', 'fl-themes-helper'),
                'param_name'        => 'parallax_android',
                'admin_label'       => false,
                'value' => array(
                        esc_attr__('Default Enable', 'fl-themes-helper')        => 'false',
                        esc_attr__('Disable', 'fl-themes-helper')               => 'true',
                ),
                'dependency' => array(
                        'element'                   => 'img_style',
                        'value'                     => array( 'parallax' ),
                ),
                'group'             => 'Parallax Setting',
                'std'               => 'false',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Parallax speed', 'fl-themes-helper'),
                'param_name'        => 'parallax_speed',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Default 0.6', 'fl-themes-helper')           => '0.6',
                        '0.1'                                       => '0.1',
                        '0.2'                                       => '0.2',
                        '0.3'                                       => '0.3',
                        '0.4'                                       => '0.4',
                        '0.5'                                       => '0.5',
                        '0.7'                                       => '0.7',
                        '0.8'                                       => '0.8',
                        '0.9'                                       => '0.9'
                ),
                'dependency' => array(
                        'element'               => 'img_style',
                        'value'                 => array( 'parallax' ),
                ),
                'description'       => 'Parallax speed: the greater the value, the slower',
                'group'             => 'Parallax Setting',
                'std'               => '0.6',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Parallax in IOS device', 'fl-themes-helper'),
                'param_name'        => 'parallax_ios',
                'admin_label'       => false,
                'value' => array(
                        esc_attr__('Default Enable', 'fl-themes-helper')        => 'false',
                        esc_attr__('Disable', 'fl-themes-helper')               => 'true',
                ),
                'dependency' => array(
                        'element'               => 'img_style',
                        'value'                 => array( 'parallax' ),
                ),
                'group'             => 'Parallax Setting',
                'std'               => 'false',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Partner img style', 'fl-themes-helper'),
                'param_name'        => 'img_style',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Default Standard', 'fl-themes-helper')      => 'standard',
                        esc_attr__('Lightbox', 'fl-themes-helper')              => 'lightbox',
                        esc_attr__('Link', 'fl-themes-helper')                  => 'link',
                        esc_attr__('Parallax', 'fl-themes-helper')              => 'parallax',
                ),
                'std'               => 'standard',
            ),
            array(
                'type'              => 'vc_link',
                'heading'           => esc_html__('Link', 'fl-themes-helper'),
                'param_name'        => 'link',
                'dependency' => array(
                        'element'           => 'img_style',
                        'value'             => array( 'link' ),
                ),
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
	));
	
	
}