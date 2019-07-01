<?php

/*
 * Shortcode testimonial Parent
 * */

add_shortcode('vc_fl_time_line_slider', 'vc_fl_time_line_slider_function');

function vc_fl_time_line_slider_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'speed'         => 750,
        'dots_color'    => '#1f1f1f',
        'dots_style'    => 'style_one',
        'extra_class'   => ''
    ), $atts));


    $idf = uniqid('fl_time_line_slider_');

    $result = '';

    $result .= '<script type="text/javascript">
        jQuery.noConflict()(document).ready( function($) {
            var time_line_slider = $("#' . $idf . '");
           time_line_slider.imagesLoaded(function() {
                time_line_slider.slick({
                    fade: true,
                    autoplay: false,
                    autoplaySpeed: 3000,
                    speed: 900,
                    infinite: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false ,
                    dots: true,
                    dotsClass: "fl-slider-dots",
                    appendDots: "#fl-dots-'.$idf.'"               
                });
            });
        });
    </script>';

    $result .= '<div class="fl-time-line-slider-box cf">';

    if($dots_style =='style_one'){
        $result .= '<style type="text/css">#fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button{background: '.$dots_color.';}#fl-dots-'.$idf.' ul.fl-slider-dots li button{border: 2px solid '.$dots_color.';}</style>';
    } elseif ($dots_style =='style_two'){
        $result .= '<style type="text/css">#fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button{box-shadow:inset 0 0 0 9px '.$dots_color.';}#fl-dots-'.$idf.' ul.fl-slider-dots li button{box-shadow: inset 0 0 0 2px '.$dots_color.';}#fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button:after{background:'.$dots_color.';}</style>';
    } else {
        $result .= '<style type="text/css">#fl-dots-'.$idf.' ul.fl-slider-dots li.slick-active button{background:'.$dots_color.';}#fl-dots-'.$idf.' ul.fl-slider-dots li button{border: 2px solid '.$dots_color.';}</style>';
    }

    $result .= '<div class="fl-dots-time-line '.$dots_style.'" id="fl-dots-'.$idf.'"></div>';

    $result .= '<div class="fl-time-line fl_style_slider fl_slick_box cf" id="'.$idf.'">';

    $result .= do_shortcode($content);

    $result .= '</div>';

    $result .= '</div>';
    return $result;

}

add_action('vc_before_init', 'vc_fl_time_line_slider_shortcode');

function vc_fl_time_line_slider_shortcode() {
	
	vc_map(array(
		'name'              => esc_html__('Time Line slider', 'fl-themes-helper'),
		'base'              => 'vc_fl_time_line_slider',
        'as_parent'         => array(
            'only' => 'vc_fl_time_line_slider_row',

        ),
        'controls'          => 'full',
        'icon'              => 'fl-icon icon-fl-time-slider',
		'category'          => esc_html__('Fl Theme', 'fl-themes-helper'),
        'js_view'           => 'VcColumnView',
        'weight'            => 100,
        "is_container"      => true,
		'params' => array(
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Dots color', 'fl-themes-helper'),
                'param_name'        => 'dots_color',
                'std'               => '#1f1f1f'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Dots Style', 'fl-themes-helper'),
                'param_name'        => 'dots_style',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Style Jelly Default', 'fl-themes-helper')           => 'style_one',
                        esc_attr__('Style Fill In', 'fl-themes-helper')                 => 'style_two',
                        esc_attr__('Style Scale', 'fl-themes-helper')                   => 'style_three',
                ),
                'std'               => 'style_one',
            ),
		),
	));
	
	
}