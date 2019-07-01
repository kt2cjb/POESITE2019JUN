<?php

/*
 * Shortcode Image slider
 * */

add_shortcode('vc_fl_image_slider', 'vc_fl_image_slider_function');

function vc_fl_image_slider_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'images_size'       => 'size_1170x668_crop',
        'img_style'         => 'standard',
        'images'            => '',
        'arrow'             => 'true',
        'arrow_style'       => 'one',
        'arrow_background'  =>'#ffffff',
        'dots'              => 'false',
        'dots_color'        => '#ffffff',
        'dots_style'        => 'style_one',
        'dots_position'     => 'dots_in_slider',
        'img_on_page'       => '1',
        'autoplay'          => 'true',
        'autoplay_speed'    => '3000',
        'slider_speed'      => '900',
        'infinite'          => 'false',
        'fl_img_effects'    => '',
        'class'             => '',
        'vc_css'            => '',
    ), $atts));

    $class .= fl_get_css_tab_class($atts);
    $result = '';
    $idf = uniqid('fl_image_slider_');


        $array_images = explode(',', $images);
        $images_str = '';
        foreach ($array_images as $attachment_id) {
            $attachment = fl_get_attachment($attachment_id, $images_size);
            if (fl_check_option($attachment)) {
                if ($img_style == 'standard') {
                    $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_slider-img">
                    ';
                } elseif ($img_style == 'lightbox') {
                    $image = '<a href="' . esc_url($attachment['src']) . '" data-lightbox="' . esc_url($attachment['src']) . '" data-title="">
                                  <img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl-slider-img">  
                               </a>';
                }
                $images_str .= '<div class="fl-slider-img-div fl_slick_slide">
                                    <div class="cf '.$fl_img_effects.'">
                                        ' . $image . '
                                    </div>
                                </div>';
            }
        }

        if($img_on_page == '2'){
           $margin_slider = 'fl_two_item';
        } elseif ($img_on_page =='3'){
            $margin_slider = 'fl_three_item';
        } else {
            $margin_slider = '';
        }


    $result .= '';

    $result .= '<script type="text/javascript">
        jQuery.noConflict()(document).ready( function() {
            var img_slider = jQuery("#'.$idf.'");
            img_slider.imagesLoaded(function() {
                img_slider.slick({
                    autoplay: '.$autoplay.',
                    autoplaySpeed: '.$autoplay_speed.',
                    speed: '.$slider_speed.',
                    infinite: '.$infinite.',
                    slidesToShow: '.$img_on_page.', 
                    slidesToScroll: '.$img_on_page.', 
                    arrows: '.$arrow.',
                    dots: '.$dots.',
                    dotsClass: "fl-slider-dots",
                    appendDots: "#fl-dots-'.$idf.'",
                    prevArrow: jQuery("#btn-'.$idf.' .fl-prev_slide_div .fl-prev"),
                    nextArrow: jQuery("#btn-'.$idf.' .fl-next_slide_div .fl-next"),
                    responsive: [
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });
        });
    </script>';



    $result .= '<div class="fl_slider_box '.fl_sanitize_class($class).' '.$dots_position.' cf">';

    $result .= '<div class="fl-slider-img fl_slick_box '.$margin_slider.'" id="'.$idf.'">';

    $result .= $images_str;

    $result .= '</div>';

    if($arrow =='true'){
        if($arrow_style =='one'){
            $result .= '
            <div class="fl-button-slider" id="btn-'.$idf.'">
                <div class="fl-prev_slide_div cf"><a class="fl-slide_button fl-prev"><span style="background:'.$arrow_background.'"></span><span style="background:'.$arrow_background.'"></span></a></div>
                <div class="fl-next_slide_div cf"><a class="fl-slide_button fl-next"><span style="background:'.$arrow_background.'"></span><span style="background:'.$arrow_background.'"></span></a></div>
            </div>';
        } elseif ($arrow_style =='two'){
            $result .= '
            <div class="fl-button-slider arrow_style_two" id="btn-'.$idf.'">
                <div class="fl-prev_slide_div cf"><a class="fl-slide_button fl-prev"><i class="fa fa-angle-left" style="color:'.$arrow_background.'"></i></a></div>
                <div class="fl-next_slide_div cf"><a class="fl-slide_button fl-next"><i class="fa fa-angle-right" style="color:'.$arrow_background.'"></i></a></div>
            </div>';
        }
    }

    if($dots =='true'){
        $result .= ' <div class="fl-dots '.$dots_style.' '.$dots_position.'" id="fl-dots-'.$idf.'"></div>';


        if($dots_style =='style_default'){
            $result .= '<style type="text/css">.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button{background: '.$dots_color.';}.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li button{border: 2px solid '.$dots_color.';}</style>';
        } elseif($dots_style =='style_one'){
            $result .= '<style type="text/css">.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button{background: '.$dots_color.';}.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li button{border: 2px solid '.$dots_color.';}</style>';
        } elseif ($dots_style =='style_two'){
            $result .= '<style type="text/css">.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button{box-shadow:inset 0 0 0 9px '.$dots_color.';}.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li button{box-shadow: inset 0 0 0 2px '.$dots_color.';}</style>';
        } elseif ($dots_style =='style_line'){
            $result .= '<style type="text/css">.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li button{background:'.$dots_color.';}</style>';
        } else {
            $result .= '<style type="text/css">.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button{background:'.$dots_color.';}.fl_slider_box #fl-dots-'.$idf.' ul.fl-slider-dots li button{border: 2px solid '.$dots_color.';}</style>';
        }


    }

    $result .= '</div>';

    return $result;

}

add_action('vc_before_init', 'vc_fl_image_slider_shortcode');

function vc_fl_image_slider_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Image Slider', 'fl-themes-helper'),
		'base'          => 'vc_fl_image_slider',
        'icon'          => 'fl-icon icon-fl-img-slider',
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'controls'      => 'full',
        'weight'        => 500,
		'params' => array(
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Img on Page', 'fl-themes-helper'),
                'param_name'        => 'img_on_page',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('One Default', 'fl-themes-helper')           => '1',
                        esc_attr__('Two', 'fl-themes-helper')                   => '2',
                        esc_attr__('Three', 'fl-themes-helper')                 => '3',
                ),
                'std'               => 'true',
            ),
            array(
                'type'              => 'attach_images',
                'heading'           => esc_html__('Select Images', 'fl-themes-helper'),
                'param_name'        => 'images',
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
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Arrow', 'fl-themes-helper'),
                'param_name'        => 'arrow',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('True Standard', 'fl-themes-helper')         => 'true',
                        esc_attr__('False', 'fl-themes-helper')                 => 'false',
                ),
                'std'               => 'true',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Arrow Style', 'fl-themes-helper'),
                'param_name'        => 'arrow_style',
                'admin_label'       => true,
                'dependency'    => array(
                        'element'               => 'arrow',
                        'value'                 => array( 'true' ),
                ),
                'value' => array(
                        esc_attr__('Arrow Style Standard', 'fl-themes-helper')  => 'one',
                        esc_attr__('Arrow Style Two', 'fl-themes-helper')       => 'two',
                ),
                'std'               => 'one',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Dots', 'fl-themes-helper'),
                'param_name'        => 'dots',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('True', 'fl-themes-helper')                           => 'true',
                        esc_attr__('False', 'fl-themes-helper')                          => 'false',
                ),
                'std'               => 'false',
            ),

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Dots Style', 'fl-themes-helper'),
                'param_name'        => 'dots_style',
                'admin_label' => true,
                'dependency'    => array(
                        'element'                                   => 'dots',
                        'value'                                     => array( 'true' ),
                ),
                'value' => array(
                        esc_attr__('Style Default', 'fl-themes-helper')         => 'style_default',
                        esc_attr__('Style Jelly Default', 'fl-themes-helper')   => 'style_one',
                        esc_attr__('Style Fill In', 'fl-themes-helper')         => 'style_two',
                        esc_attr__('Style Scale', 'fl-themes-helper')           => 'style_three',
                        esc_attr__('Style Line', 'fl-themes-helper')            => 'style_line',
                ),
                'std'       => 'style_one',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Dots Style', 'fl-themes-helper'),
                'param_name'        => 'dots_position',
                'admin_label'       => true,
                'dependency'    => array(
                        'element'                                   => 'dots',
                        'value'                                     => array( 'true' ),
                ),
                'value' => array(
                        esc_attr__('Style Dots In Slider Default', 'fl-themes-helper')  => 'dots_in_slider',
                        esc_attr__('Style Dots Before Slider', 'fl-themes-helper')      => 'dots_before_slider',
                ),
                'std'               => 'dots_in_slider',
            ),


            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Custom Classes', 'fl-themes-helper'),
                'param_name'        => 'class',
                'value'             => '',
                'description'       => '',
            ),
            array(
                'type'              => 'colorpicker',
                'param_name'        => 'arrow_background',
                'heading'           => esc_html__('Arrow Color', 'test'),
                'value'             => '',
                'std'               => '#ffffff',
                'dependency' => array(
                        'element'                   => 'arrow',
                        'value'                     => array( 'true' ),
                ),
                'group'             => esc_html__( 'Color setting', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'colorpicker',
                'param_name'        => 'dots_color',
                'heading'           => esc_html__('Dots Color', 'test'),
                'value'             => '',
                'dependency' => array(
                        'element'                   => 'dots',
                        'value'                     => array( 'true' ),
                ),
                'edit_field_class'  => 'vc_col-sm-3',
                'std'               => '#ffffff',
                'group'             => esc_html__( 'Color setting', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'dropdown',
                'param_name'        => 'infinite',
                'heading'           => esc_html__('Infinite Scroll', 'test'),
                'value' => array(
                        esc_attr__('True', 'fl-themes-helper')      => 'true',
                        esc_attr__('False', 'fl-themes-helper')     => 'false',
                ),
                'std'               => 'false',
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'dropdown',
                'param_name'        => 'autoplay',
                'heading'           => esc_html__('Auto play', 'test'),
                'value' => array(
                        esc_attr__('True', 'fl-themes-helper')      => 'true',
                        esc_attr__('False', 'fl-themes-helper')     => 'false',
                ),
                'std'               => 'true',
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'textfield',
                'param_name'        => 'autoplay_speed',
                'heading'           => esc_html__('Auto play Speed', 'test'),
                'std'               => '3000',
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
                'description'       => esc_html__( 'Standard Auto play speed 3000ms', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'textfield',
                'param_name'        => 'slider_speed',
                'heading'           => esc_html__('Slider Speed', 'test'),
                'std'               => '900',
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
                'description'       => esc_html__( 'Standard Slider speed 900ms', 'fl-themes-helper'),
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