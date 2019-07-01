<?php

/*
 * Shortcode team
 * */

add_shortcode('vc_fl_accordion_row', 'vc_fl_accordion_row_function');

function vc_fl_accordion_row_function($atts, $content = null) {

	extract(shortcode_atts(array(
        'icon_style'        => 'arrow',
        'acco_text_color'   => '#FFFFFF',
        'acco_bg_color'     => '#363636',
        'align'             => 'left',
        'acco_background'   => 'background',
        'i_align'           => 'fl_ico_right',
        'acco_text'         => 'Accordion Title',
        'class'             => '',
        'vc_css'            => '',
	), $atts));

    $class .= fl_get_css_tab_class($atts);


    $text_cl ='';

    if($acco_text_color){
        $text_cl ='color:'.$acco_text_color.';';
    }



    if($acco_background == 'border_bottom'){
        $accordion_border = 'fl_acco_border_on';
        if($acco_bg_color) {
            $bg_color = 'border-color:'.$acco_bg_color.';';
        }
    } else {
        $accordion_border = '';
        if($acco_bg_color) {
            $bg_color = 'background-color:'.$acco_bg_color.';';
        }
    }

    $acco_style_css = ( $text_cl  || $bg_color) ? 'style='. esc_attr($text_cl). $bg_color .'' : '';

    if($icon_style =='arrow'){
        $icon = '<i class="fa fa-chevron-down '.$i_align.'" ></i>';
    } else {
        $icon = '<div class="fl_icon_plus '.$i_align.'"><span class="fl_line_1" style="background-color: '.$acco_text_color.'"></span><span class="fl_line_2" style="background-color: '.$acco_text_color.'"></span></div>';
    }

    $return ='';

    $return .='<li class="fl-accordion_li '.fl_sanitize_class($class).' cf">';

    $return .='<div class="fl_accordion_toggle '.$align.' '.$accordion_border.'" '.$acco_style_css.'>'.$acco_text.' '.$icon.'</div>';

    $return .='<div class="fl-accordion_div inner cf">';

    $return .= do_shortcode($content);

    $return .= '</div>';

    $return .= '</li>';

    return $return;
}

add_action('vc_before_init', 'vc_fl_accordion_row_shortcode');

function vc_fl_accordion_row_shortcode() {

	vc_map(array(
		'name'                  => esc_html__('Accordion row', 'fl-themes-helper'),
		'base'                  => 'vc_fl_accordion_row',
        'icon'                  => 'fl-icon icon-fl-accordion-row',
        'as_child'              => array(
            'only' => 'vc_fl_accordion_parrent'
        ),
		'category'              => esc_html__('Fl Theme', 'fl-themes-helper'),
        'weight'                => 10000,
        'controls'              => 'full',
        "is_container"          => true,
        "content_element"       => true,
        "js_view"               => 'VcColumnView',
		'params' => array(
            array(
                "type"          => "textarea",
                "holder"        => "div",
                "class"         => "",
                "heading"       => esc_html__( "Accordion Header Text", "fl-themes-helper" ),
                "param_name"    => "acco_text",
                "value"         => '',
                "description"   => esc_html__( "Enter your content.", "fl-themes-helper" ),
                'std'           => 'Accordion Title',
            ),
            array(
                'type'          => 'colorpicker',
                'heading'       => esc_html__('Text color', 'fl-themes-helper'),
                'param_name'    => 'acco_text_color',
                'value'         => '',
                'std'           => '#FFFFFF',
            ),

            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Accordion background style', 'fl-themes-helper' ),
                'param_name'    => 'acco_background',
                'std'           => 'background',
                'value'         => array(
                        esc_html__( 'Background', 'fl-themes-helper' ) => 'background',
                        esc_html__( 'Border bottom', 'fl-themes-helper' ) => 'border_bottom',
                ),
            ),

            array(
                'type'          => 'colorpicker',
                'heading'       => esc_html__('Background color', 'fl-themes-helper'),
                'param_name'    => 'acco_bg_color',
                'value'         => '',
                'std'           => '#363636',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Alignment', 'fl-themes-helper' ),
                'param_name'    => 'align',
                'description'   => esc_html__( 'Select text alignment.', 'fl-themes-helper' ),
                'std'           => 'left',
                'value'         => array(
                        esc_html__( 'Left', 'fl-themes-helper' )    => 'left',
                        esc_html__( 'Right', 'fl-themes-helper' )   => 'right',
                        esc_html__( 'Center', 'fl-themes-helper' )  => 'center',
                ),
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Icon Style', 'fl-themes-helper' ),
                'description'   => esc_html__( 'Select icon style.', 'fl-themes-helper' ),
                'param_name'    => 'icon_style',
                'value' => array(
                        esc_html__( 'Arrow', 'fl-themes-helper' )   => 'arrow',
                        esc_html__( 'Plus', 'fl-themes-helper' )    => 'plus',
                ),
                'std'           => 'arrow',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Icon Alignment', 'fl-themes-helper' ),
                'description'   => esc_html__( 'Select icon alignment.', 'fl-themes-helper' ),
                'param_name'    => 'i_align',
                'value'         => array(
                      esc_html__( 'Left', 'fl-themes-helper' )      => 'fl_ico_left',
                      esc_html__( 'Right', 'fl-themes-helper' )     => 'fl_ico_right',
                      esc_html__( 'Float None', 'fl-themes-helper' )=> '',
                ),
                'std'           => 'fl_ico_right',
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Custom Classes', 'fl-themes-helper'),
                'param_name'    => 'class',
                'value'         => '',
                'description'   => '',
            ),
            array(
                'type'          => 'css_editor',
                'heading'       => esc_html__( 'CSS', 'fl-themes-helper'),
                'param_name'    => 'vc_css',
                'group'         => esc_html__( 'Design Options', 'fl-themes-helper'),
            )
		),
	));


}