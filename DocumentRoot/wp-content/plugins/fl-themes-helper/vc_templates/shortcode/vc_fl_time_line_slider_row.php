<?php

/*
 * Shortcode Testimonial Row
 * */

add_shortcode('vc_fl_time_line_slider_row', 'vc_fl_time_line_slider_row_function');

function vc_fl_time_line_slider_row_function($atts, $content = null) {

	
	extract(shortcode_atts(array(
    'title'     => '2017',
    'img'       => '',
    'img_size'  => 'size_1170x668_crop',
	), $atts));

	$result = '';



    $attachment = fl_get_attachment($img, $img_size);
    $img = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_single-img">';




        $result .= '<div class="fl-time-line-item fl_slick_slide cf">';

        $result .= '<div class="fl-time-line-img col-xl-5 col-lg-5 col-sm-12">';

        $result .= $img;

        $result .=  '</div>';

        $result .= '<div class="fl-time-line-content col-xl-7 col-lg-7 col-sm-12">';

        $result .= '<h4 class="fl-time-line-title">'.$title.'</h4>';

        $result .=  fl_js_remove_wpautop($content);

        $result .=  '</div>';

        $result .=  '</div>';



	return $result;
	
}

add_action('vc_before_init', 'vc_fl_time_line_slider_row_shortcode');
function vc_fl_time_line_slider_row_shortcode()
{
	vc_map(array(
		'name'              => esc_html__('Time Line Row', 'fl-themes-helper'),
		'base'              => 'vc_fl_time_line_slider_row',
        'icon'              => 'fl-icon icon-fl-time-line-slider-row',
		'as_child' => array(
			'only' => 'vc_fl_time_line_slider'
		),
        "content_element"   => true,
        "is_container"      => false,
		'params' => array(
            array(
                'type'              => 'attach_image',
                'param_name'        => 'img',
                'std'               => '',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Images Size', 'fl-themes-helper'),
                'param_name'        => 'img_size',
                'std'               => 'size_1170x668_crop',
                'value'             => fl_get_image_sizes(),
                'description'       => ''
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Title', 'fl-themes-helper'),
                'param_name'        => 'title',
                'std'               => '2017',
                'description'       => ''
            ),
            array(
                "type"              => "textarea_html",
                "holder"            => "div",
                "class"             => "",
                "heading"           => esc_html__( "Content", "fl-themes-helper" ),
                "param_name"        => "content",
                "value"             => '',
                'std'               => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                "description"       => esc_html__( "Enter your content.", "fl-themes-helper" )
            ),

		)
	));
}