<?php

/*
 * Shortcode testimonial Parent
 * */

add_shortcode('vc_fl_testimonial_parent', 'vc_fl_testimonial_parent_function');

function vc_fl_testimonial_parent_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'speed'                 => 750,
        'testimonial_show'      => 'three',
        'dots'                  => 'false',
        'dots_style'            => 'style_one',
        'dots_color'            => '#1f1f1f',
        'infinite'              => 'false',
        'autoplay'              => 'false',
        'slider_speed'          => '900',
        'margin_dots'           => '40px',
        'img_style'             => '',
        'autoplay_speed'        => '3000',
        'class'                 => '',
        'vc_css'                => '',
    ), $atts));


    $idf = uniqid('fl_testimonial_slider_');

    $class .= fl_get_css_tab_class($atts);

    $mr_dt = '';
    if($margin_dots){
        $mr_dt = 'margin-top:'.$margin_dots.';';
    }

    $style_dots_css = ( $mr_dt ) ? 'style='. $mr_dt. '' : '';

    if ($testimonial_show == 'three') {
        $show_item = '3';
    } elseif ($testimonial_show == 'two') {
        $show_item = '2';
    } else {
        $show_item = '1';
    }
    $result = '';

    $result .= '<script type="text/javascript">
        jQuery.noConflict()(document).ready( function($) {
            var testimonial_slider = $("#' . $idf . '");
            testimonial_slider.imagesLoaded(function() {
                testimonial_slider.slick({
                    autoplay: '.$autoplay.',
                    autoplaySpeed: '.$autoplay_speed.',
                    speed: '.$slider_speed.',
                    infinite: '.$infinite.',
                    slidesToShow: '.$show_item.',
                    slidesToScroll: '.$show_item.',
                    arrows: false,
                    dots: '.$dots.',
                    dotsClass: "fl-testimonial-dots",
                    appendDots: "#fl-dots-'.$idf.'",
                    responsive: [
                        {
                            breakpoint: 1170,
                            settings: {
                                slidesToShow: '.$show_item.',
                                slidesToScroll: '.$show_item.'
                            }
                        },
                        {
                            breakpoint: 700,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        },

                        {
                            breakpoint: 550,
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

    $result .='<div class="fl_testimonial_slider_box cf ' .fl_sanitize_class($class).'">';

    $result .= '<div class="fl-testimonial-slider fl_slick_box '.$img_style.' cf " id="'.$idf.'">';

    $result .= do_shortcode($content);

    $result .= '</div>';

    if($dots =='true'){
        $result .= ' <div class="fl-dots '.$dots_style.' " id="fl-dots-'.$idf.'" '.$style_dots_css.'></div>';

        if($dots_style =='style_default'){
            $result .= '<style type="text/css" data-type="vc_custom-css">.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li.slick-active button{background: '.$dots_color.';}.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li button{border: 2px solid '.$dots_color.';}</style>';
        } elseif($dots_style =='style_one'){
            $result .= '<style type="text/css" data-type="vc_custom-css">.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li.slick-active button{background: '.$dots_color.';}.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li button{border: 2px solid '.$dots_color.';}</style>';
        } elseif ($dots_style =='style_two'){
            $result .= '<style type="text/css" data-type="vc_custom-css">.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li.slick-active button{box-shadow:inset 0 0 0 9px '.$dots_color.';}.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li button{box-shadow: inset 0 0 0 2px '.$dots_color.';}</style>';
        } elseif ($dots_style =='style_line'){
            $result .= '<style type="text/css" data-type="vc_custom-css">.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li button{background:'.$dots_color.';}</style>';
        } else {
            $result .= '<style type="text/css" data-type="vc_custom-css">.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li.slick-active button{background:'.$dots_color.';}.fl_testimonial_slider_box #fl-dots-'.$idf.' ul.fl-testimonial-dots li button{border: 2px solid '.$dots_color.';}</style>';
        }
    }
    $result .= '</div>' ;

    return $result;
}

add_action('vc_before_init', 'vc_fl_testimonial_parent_shortcode');

function vc_fl_testimonial_parent_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Testimonial', 'fl-themes-helper'),
		'base'          => 'vc_fl_testimonial_parent',
        'as_parent' => array(
            'only' => 'vc_fl_testimonial_row',
        ),
        'icon'          => 'fl-icon icon-fl-testimonial',
		'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'js_view'       => 'VcColumnView',
        'controls'      => 'full',
        'weight'        => 100,
		'params' => array(
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Testimonial show on pages', 'fl-themes-helper'),
                'param_name'        => 'testimonial_show',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Default Three', 'fl-themes-helper')         => 'three',
                        esc_attr__('Two', 'fl-themes-helper')                   => 'two',
                        esc_attr__('One', 'fl-themes-helper')                   => 'one',
                ),
                'std'               => 'four'
            ),

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Image Style', 'fl-themes-helper'),
                'param_name'        => 'img_style',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Default', 'fl-themes-helper')               => '',
                        esc_attr__('Rounded', 'fl-themes-helper')               => 'testimonial_img_rounded',
                ),
                'std'       => ''
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
                'group'             => esc_html__( 'Dots', 'fl-themes-helper'),
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
                'group'             => esc_html__( 'Dots', 'fl-themes-helper'),
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
                'std'               => '#1f1f1f',
                'group'             => esc_html__( 'Dots', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'textfield',
                'param_name'        => 'margin_dots',
                'heading'           => esc_html__( 'Margin Dots', 'test'),
                'std'               => '40px',
                'group'             => esc_html__( 'Dots', 'fl-themes-helper'),
                'description'       => esc_html__( 'Type margin-top. Example: 50px.', 'fl-themes-helper'),
                'dependency'    => array(
                    'element'                                   => 'dots',
                    'value'                                     => array( 'true' ),
                ),
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
                'std'               => 'false',
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'fl_number',
                'param_name'        => 'autoplay_speed',
                'heading'           => esc_html__('Auto play Speed', 'test'),
                'value'             => '3000',
                "min"               => 0,
                "max"               => 5000,
                "step"              => 10,
                'dependency' => array(
                    'element'                   => 'autoplay',
                    'value'                     => array( 'true' ),
                ),
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
                'description'       => esc_html__( 'Standard Auto play speed 3000ms', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'fl_number',
                'heading'           => esc_html__('Slider Speed', 'test'),
                'param_name'        => 'slider_speed',
                'admin_label'       => true,
                'value'             => 900,
                'min'               => 300,
                'max'               => 5000,
                'step'              => 5,
                'group'             => esc_html__( 'Slider setting', 'fl-themes-helper'),
                'description'       => esc_html__( 'Standard Slider speed 900ms', 'fl-themes-helper'),
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