<?php

/*
 * Shortcode Prodress Bar
 * */

add_shortcode('vc_fl_progress_bar', 'vc_fl_progress_bar_function');

function vc_fl_progress_bar_function($atts, $content = null) {
    $class = '';
    extract(shortcode_atts(array(
       'progress_bar_style'                 => '1',
       'progress_bar_height'                => 'fl_height_normal',
       'title_text'                         => 'Design',
       'heading_color'                      => '#474747',
       'title_size'                         => '16px',
       'progress_value'                     => '56',
       'progress_bar_color'                 => '#1f1f1f',
       'progress_background_track_color'    => '#e8e8e8',
       'mark_background_transparent'        => 'no',
       'mark_background_color'              => '#1f1f1f',
       'mark_text_color'                    => '#ffffff',
       'progress_border'                    => 'false',
       'progress_duration'                  => '1200',
       'class'                              => '',
       'vc_css'                             => '',
    ), $atts));

    $class .= fl_get_css_tab_class($atts);

    if($progress_border == 'true'){
        $border_style = 'progress_border';
    } else {
        $border_style = '';
    }

    $track_background_style= ' style= background-color:'.$progress_bar_color.';width:'.$progress_value.'%;';


     $progress_background_track_color_style =  ' style= background-color:'.$progress_background_track_color.';';

     //Title style
    $color_heading = '';
    $font_title_size = '';
    if($heading_color){
        $color_heading = 'color:'.$heading_color.';';
    }
    if($title_size){
        $font_title_size ='font-size:'.$title_size.';';
    }

     $progress_title_style = ( $color_heading || $font_title_size ) ? 'style='. esc_attr($font_title_size) . esc_attr($color_heading) . '' : '';



    //Progress_number_mark
    $mark_bacground = '';
    $left_mark  = '';

    if($progress_bar_style == '1'){
        $progress_style= '';

        if($mark_background_transparent == 'yes'){
          $mark_bacground = 'background:transparent;margin-bottom:-6px;';
        } else {
          $mark_bacground = 'background:'.$mark_background_color.';';
        }
    } elseif ($progress_bar_style== '2') {
        $progress_style= 'fl_progress_number_bottom';

        if($mark_background_transparent == 'yes'){
            $mark_bacground = 'background:transparent;margin-top:-6px;';
        } else {
            $mark_bacground = 'background:'.$mark_background_color.';';
        }

    } else {
        $progress_style= 'fl_progress_number_right';

        if($mark_background_transparent == 'yes'){
            $mark_bacground = 'background:transparent;margin-top:-6px;';
        } else {
            $mark_bacground = 'background:'.$mark_background_color.';';
        }
    }

    $left_mark = 'left:'.$progress_value.'%;';

    $fl_progress_number_mark_style = ( $mark_bacground || $left_mark ) ? 'style='. esc_attr($mark_bacground) . esc_attr($left_mark) . '' : '';

    //Down arrow style
    if($progress_bar_style == '1') {

        if ($mark_background_transparent == 'yes') {
            $border_arrow_color = 'border-top: 3px solid';
            $arrow_border = 'transparent';
        } else {
            $border_arrow_color = 'border-top: 3px solid';
            $arrow_border = $mark_background_color;
        }
    } elseif ($progress_bar_style== '2') {
        if ($mark_background_transparent == 'yes') {
            $border_arrow_color = 'border-bottom: 3px solid';
            $arrow_border = 'transparent';
        } else {
            $border_arrow_color = 'border-bottom: 3px solid';
            $arrow_border = $mark_background_color;
        }
    }

    $result = '';

    $result .= '<div class="fl-progress-bar cf '.$progress_bar_height .' '.$border_style.' '.$progress_style.' '.fl_sanitize_class($class).'" data-duration="'.$progress_duration.'" data-fl-percentage-one="'.$progress_value.'%" >';

    if($progress_bar_style == '1'){
    $result .= '<div class="fl-progress-title-holder">';

    $result .= '<span class="fl-progress-title" '.$progress_title_style.'>'.$title_text.'</span>';

    $result .= '<span class="fl-progress-number-wrapper">';

    $result .= '<span class="fl-progress-number-mark" '.$fl_progress_number_mark_style.'>';

    $result .= '<span class="fl-percent" style="color:'.$mark_text_color.'">'.$progress_value.'%</span>';

    $result .= '<span class="fl-down-arrow" style="'.$border_arrow_color.' '.$arrow_border.'"></span>';

    $result .= '</span>';

    $result .= '</span>';

    $result .= '</div>';

    $result .= '<div class="fl-progress-content-outter" '.$progress_background_track_color_style.'>';

    $result .= '<div class="fl-progress-content" '.$track_background_style.'></div>';

    $result .= '</div>';

    } elseif ($progress_bar_style == '2') {

    $result .= '<div class="fl-progress-title-box">';

    $result .= '<span class="fl-progress-title" ' . $progress_title_style . '>' . $title_text . '</span>';

    $result .= '</div>';

    $result .= '<div class="fl-progress-content-outter" ' . $progress_background_track_color_style . '>';

    $result .= '<div class="fl-progress-content" ' . $track_background_style . '></div>';

    $result .= '</div>';

    $result .= '<div class="fl-progress-title-holder">';

    $result .= '<span class="fl-progress-number-wrapper">';

    $result .= '<span class="fl-progress-number-mark" ' . $fl_progress_number_mark_style . '>';

    $result .= '<span class="fl-percent" style="color:' . $mark_text_color . '">' . $progress_value . '%</span>';

    $result .= '<span class="fl-down-arrow" style="' . $border_arrow_color . ' ' . $arrow_border . '"></span>';

    $result .= '</span>';

    $result .= '</span>';

    $result .= '</div>';

    } elseif ($progress_bar_style == '3') {

    $result .= '<div class="fl-progress-title-box">';

    $result .= '<span class="fl-progress-title" ' . $progress_title_style . '>' . $title_text . '</span>';

    $result .= '</div>';

    $result .= '<div class="fl-progress-track-box">';

    $result .= '<div class="fl-progress-content-outter" ' . $progress_background_track_color_style . '>';

    $result .= '<div class="fl-progress-content" ' . $track_background_style . '></div>';

    $result .= '</div>';

    $result .= '<div class="fl-progress-number-box">';

    $result .= '<span class="fl-percent-right">' . $progress_value . '%</span>';

    $result .= '</div>';

    $result .= '</div>';

    }

    $result .= '</div>';

    return $result;
}
add_action('vc_before_init', 'vc_fl_progress_bar_shortcode');

function vc_fl_progress_bar_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Progress bar', 'fl-themes-helper'),
            'base'          => 'vc_fl_progress_bar',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'          => 'fl-icon icon-fl-progress',
            'controls'      => 'full',
            'weight'        => 300,
            'params'        => array(
                array(
                    "type"              => "dropdown",
                    'heading'           => esc_html__('Progress bar style', 'fl-themes-helper'),
                    'param_name'        => 'progress_bar_style',
                    "value"=> array(
                            esc_html__('Style one Standard : progress number top','fl-themes-helper')   =>  '1',
                            esc_html__('Style Two: progress number bottom','fl-themes-helper')          =>  '2',
                            esc_html__('Style Three : progress number right','fl-themes-helper')        =>  '3',
                    ),
                    'description' => '',
                ),
                array(
                    'type'              => 'textfield',
                    'admin_label'       => true,
                    'heading'           => esc_html__('Duration', 'test'),
                    'param_name'        => 'progress_duration',
                    'value'             => '',
                    'std'               => '1200',
                    'description'       => 'Standard Duration speed is 1200ms'
                ),
                array(
                    "type"              => "dropdown",
                    'heading'           => esc_html__('Progress bar style', 'fl-themes-helper'),
                    'param_name'        => 'progress_bar_height',
                    "value"             => array(
                            esc_html__('Normal','fl-themes-helper')         =>  'fl_height_normal',
                            esc_html__('Slim','fl-themes-helper')           =>  'fl_height_slim',
                            esc_html__('Ultra Slim','fl-themes-helper')     =>  'fl_height_ultra_slim',
                            esc_html__('Large','fl-themes-helper')          =>  'fl_height_large',
                    ),
                    'description' => '',
                ),
                array(
                    "type"              => "dropdown",
                    'heading'           => esc_html__('Border style', 'fl-themes-helper'),
                    'param_name'        => 'progress_border',
                    "value" => array(
                            esc_html__('Yes','fl-themes-helper')            =>  'true',
                            esc_html__('No','fl-themes-helper')             =>  'false',
                    ),
                    'std'               => array('false'),
                    'description'       => '',
                ),
                array(
                    'type'              => 'textfield',
                    'admin_label'       => true,
                    'heading'           => esc_html__('Title', 'test'),
                    'param_name'        => 'title_text',
                    'value'             => '',
                    'std'               => 'Design',
                ),
                array(
                    'type'              => 'textfield',
                    'admin_label'       => true,
                    'heading'           => esc_html__('Progress Value', 'test'),
                    'param_name'        => 'progress_value',
                    'value'             => '',
                    'std'               => '56',
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'progress_bar_color',
                    'heading'           => esc_html__('Progress bar color', 'test'),
                    'value'             => '',
                    'std'               => '#1f1f1f'
                ),

                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'progress_background_track_color',
                    'heading'           => esc_html__('Progress track color', 'test'),
                    'value'             => '',
                    'std'               => '#e8e8e8'
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
                    'param_name'        => 'heading_color',
                    'heading'           => esc_html__('Heading Color', 'test'),
                    'description'       => esc_html__('The color property specifies the color of Heading.', 'test'),
                    'value'             => '',
                    'std'               => '#474747',
                    'group'             => esc_html__( 'Design Heading', 'fl-themes-helper'),
                ),
                array(
                    "type"              => "textfield",
                    'heading'           => esc_html__('Title Size', 'fl-themes-helper'),
                    'param_name'        => 'title_size',
                    "value"             => '16px',
                    'description'       => '',
                    'group'             => esc_html__( 'Design Heading', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'dropdown',
                    'param_name'        => 'mark_background_transparent',
                    'heading'           => esc_html__('Mark transparent background', 'test'),
                    "value"=> array(
                            esc_html__('Yes','fl-themes-helper')        =>  'yes',
                            esc_html__('No','fl-themes-helper')         =>  'no',
                    ),
                    'std'               => 'no',
                    'group'             => esc_html__( 'Design Mark', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'mark_background_color',
                    'heading'           => esc_html__('Mark Background Color', 'test'),
                    'value'             => '',
                    'std'               => '#1f1f1f',
                    'group'             => esc_html__( 'Design Mark', 'fl-themes-helper'),
                    'dependency' => array(
                            'element'                       => 'mark_background_transparent',
                            'value'                         => array( 'no' ),
                    ),
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'mark_text_color',
                    'heading'           => esc_html__('Mark Text Color', 'test'),
                    'value'             => '',
                    'std'               => '#ffffff',
                    'group'             => esc_html__( 'Design Mark', 'fl-themes-helper'),
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
