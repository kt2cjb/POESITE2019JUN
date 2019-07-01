<?php

/*
 * Shortcode Partner Row
 * */

add_shortcode('vc_fl_work_info_row', 'vc_fl_work_info_row_function');

function vc_fl_work_info_row_function($atts, $content = null) {

	extract(shortcode_atts(array(
	'list_style'            => 'one',
    'li_title'              => 'Client:',
    'title_font_size'       => 15,
    'title_color'           => '#1f1f1f',
    'content_color'         => '#5e5e5e',
    'content_font_size'     => 15,
    'title_mb'              => '',
    'class'                 => '',
    'vc_css'                => '',
	), $atts));


    $class .= fl_get_css_tab_class($atts);

    $tl_fz=$tl_cl=$cn_fz=$cn_cl=$tl_mb='';
	if($title_color){
	    $tl_cl = 'color:'.$title_color.';';
    }
    if($title_font_size){
        $tl_fz = 'font-size:'.$title_font_size.'px;';
    }

    if($title_mb){
        $tl_mb = 'margin-bottom:'.$title_mb.'px;';
    }

    if($content_color){
        $cn_cl = 'color:'.$content_color.';';
    }
    if($content_font_size){
        $cn_fz = 'font-size:'.$content_font_size.'px;';
    }



    $title_style = ( $tl_fz || $tl_cl || $tl_mb ) ? 'style='. $tl_fz . $tl_cl . $tl_mb. '' : '';

    $content_style = ( $cn_fz || $cn_cl  ) ? 'style='. $cn_fz . $cn_cl  . '' : '';

    $result = '';

    if($list_style =='one'){

        $result .= '<li class="fl-li-work-info fl-work-info-style-one '.fl_sanitize_class($class).'">';

        $result .= '<span class="fl-work-info-title fl-width-30" '.$title_style.'><strong>'.$li_title.'</strong></span>';

        $result .= '<div class="fl-work-info-content" '.$content_style.'>'.fl_js_remove_wpautop($content, true).'</div>';

        $result .= '</li>';



    } else {

        $result .= '<li class="fl-li-work-info fl-work-info-style-two '.fl_sanitize_class($class).'">';

        $result .= '<div class="fl-work-info-title" '.$title_style.'><strong>'.$li_title.'</strong></div>';

        $result .= '<div class="fl-work-info-content" '.$content_style.'>'.fl_js_remove_wpautop($content, true).'</div>';

        $result .= '</li>';

    }




    return $result;

}

add_action('vc_before_init', 'vc_fl_work_info_row_shortcode');

function vc_fl_work_info_row_shortcode() {
	
	vc_map(array(
		'name'          => esc_html__('Work Info Row', 'fl-themes-helper'),
		'base'          => 'vc_fl_work_info_row',
        'icon'          => 'fl-icon icon-fl-list-row',
        'as_child' => array(
            'only' => 'vc_fl_work_info_table'
        ),
		'params'        => array(
            array(
                "type"              => "dropdown",
                "heading"           => esc_html__( "Style", "fl-themes-helper" ),
                'std'               => 'one',
                "param_name"        => "list_style",
                "value" => array(
                    'One'                              => 'one',
                    'Two'                              => 'two',
                ),
            ),
            array(
                'type'                  => 'textfield',
                'heading'               => esc_html__('Title', 'fl-themes-helper'),
                'param_name'            => 'li_title',
                'std'                   => 'Client:',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'              => 'textarea_html',
                'heading'           => esc_html__('Content', 'fl-themes-helper'),
                'param_name'        => 'content',
                'value'             => '',
                'holder'            => 'div',
                'std'               => 'Jason Griffith',
            ),

            array(
                'type'                  => 'colorpicker',
                'heading'               => esc_html__('Title color', 'fl-themes-helper'),
                'param_name'            => 'title_color',
                'std'                   => '#1f1f1f',
                'edit_field_class'      => 'vc_col-sm-3',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'                  => 'colorpicker',
                'heading'               => esc_html__('Content color', 'fl-themes-helper'),
                'param_name'            => 'content_color',
                'std'                   => '#5e5e5e',
                'edit_field_class'      => 'vc_col-sm-3',
                'value'                 => '',
                'description'           => '',
            ),
            array(
                'type'              => 'fl_number',
                'heading'           => esc_html__('Title font size', 'fl-themes-helper'),
                "param_name"        => "title_font_size",
                'value'             => 15,
                'min'               => 0,
                'max'               => 999999,
                'step'              => 1,
                'suffix'            => 'px',
            ),
            array(
                'type'              => 'fl_number',
                'heading'           => esc_html__('Title Margin bottom', 'fl-themes-helper'),
                "param_name"        => "title_mb",
                'value'             => '',
                'min'               => 0,
                'max'               => 999999,
                'step'              => 1,
                'suffix'            => 'px',
                'dependency'  => array(
                    'element'                           => 'list_style',
                    'value'                             => array( 'two' ),
                ),
            ),

            array(
                'type'              => 'fl_number',
                'heading'           => esc_html__('Content font size', 'fl-themes-helper'),
                "param_name"        => "content_font_size",
                'value'             => 15,
                'min'               => 0,
                'max'               => 999999,
                'step'              => 1,
                'suffix'            => 'px',
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