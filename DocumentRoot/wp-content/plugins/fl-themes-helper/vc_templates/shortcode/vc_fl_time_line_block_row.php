<?php

add_shortcode('vc_fl_time_line_block_row', 'vc_fl_time_line_block_row_function');

function vc_fl_time_line_block_row_function($atts, $content = null) {

	
	extract(shortcode_atts(array(
    'title'             => '2017-2018',
    'img'               => '',
    'img_size'          => 'size_1170x668_crop',
    'line_tl_color'     => '#f1f1f1',
    'title_tl_color'    => '#1f1f1f',
    'circle_tl_color'   => '#f1f1f1',
	), $atts));

	$result = '';


    if($img){
        $attachment = fl_get_attachment($img, $img_size);
    } else{
        $attachment = '';
    }



    if($img){
        $img = '<div class="fl-time-line-img"><img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_single-img"></div>';
    }



        $result .= '<div class="fl-time-line-item cf">';

        $result .= '<span class="fl-line" style="background-color:'.$line_tl_color.'"></span>';

        $result .= '<div class="fl-time-line-content">';

        $result .= '<h5 class="fl-time-line-title" style="color:'.$title_tl_color.'"><span class="fl-title-circle" style="background-color:'.$circle_tl_color.'"></span>'.$title.'</h5>';

        $result .=  $img;

        $result .=  fl_js_remove_wpautop($content, true);

        $result .=  '</div>';

        $result .=  '</div>';



	return $result;
	
}

add_action('vc_before_init', 'vc_fl_time_line_block_row_shortcode');
function vc_fl_time_line_block_row_shortcode()
{
	vc_map(array(
		'name'          => esc_html__('Time Line Row', 'fl-themes-helper'),
		'base'          => 'vc_fl_time_line_block_row',
        'icon'          => 'fl-icon icon-fl-time-line-block-row',
		'as_child' => array(
			'only' => 'vc_fl_time_line_block'
		),
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
                'std'               => '2017-2018',
                'description'       => ''
            ),
            array(
                'type'              => 'textarea_html',
                'heading'           => esc_html__('Text', 'fl-themes-helper'),
                'param_name'        => 'content',
                'value'             => '',
                'holder'            => 'div',
                'std'               => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                "description"       => esc_html__( "Enter your content.", "fl-themes-helper" )
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Line color', 'fl-themes-helper'),
                'param_name'        => 'line_tl_color',
                'value'             => '',
                'std'               => '#f1f1f1',
                'group'             => 'Color Settings',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Title color', 'fl-themes-helper'),
                'param_name'        => 'title_tl_color',
                'value'             => '',
                'std'               => '#1f1f1f',
                'group'             => 'Color Settings',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Circle color', 'fl-themes-helper'),
                'param_name'        => 'circle_tl_color',
                'value'             => '',
                'std'               => '#f1f1f1',
                'group'             => 'Color Settings',
            ),

		)
	));
}