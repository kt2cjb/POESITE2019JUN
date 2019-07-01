<?php

add_shortcode('vc_fl_title', 'vc_fl_title_function');

function vc_fl_title_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'title'                  => 'Title text',
        'title_text_align'       => 'text-left',
        'title_style'            => 'h4',
        'title_mt'               => '',
        'title_mb'               => '20px',
        'title_color'            => '#1f1f1f',
        'custom_font_size'       => 'disable',
        'title_font_size'        => '',
        'title_line_height'      => '',
        'sub_title_style_font'   => 'font_two sub_title_header',
        'sub_title'              => '',
        'sub_title_position'     => 'after',
        'sub_title_color'        => '',
        'sub_title_font_size'    => '16px',
        'sub_title_mt'           => '',
        'sub_title_mb'           => '',
        'class'                  => '',
        'vc_css'                 => '',
    ), $atts));


    $result = '';

    $class .= fl_get_css_tab_class($atts);

    $sub_tl_color   ='';
    $sub_ft_size    ='';
    $sub_mt         ='';
    $sub_mb         ='';
    if($sub_title_color){
        $sub_tl_color       = 'color:'.$sub_title_color.';';
    }
    if($sub_title_font_size){
        $sub_ft_size          = 'font-size:'.$sub_title_font_size.';';
    }
    if($sub_title_mt){
        $sub_mt             = 'margin-top:'.$sub_title_mt.';';
    }
    if($sub_title_mb){
        $sub_mb             = 'margin-bottom:'.$sub_title_mb.';';
    }
    $sub_title_style_css    = ( $sub_tl_color  || $sub_ft_size || $sub_mt || $sub_mb) ? 'style='. esc_attr($sub_tl_color). $sub_ft_size . $sub_mb . $sub_mt.'' : '';


    $tl_color   ='';
    $ft_size    ='';
    $mt         ='';
    $mb         ='';
    $lh         ='';
    $tl_line_h  ='';
    if($title_color){
        $tl_color       ='color:'.$title_color.';';
    }
    if($title_line_height){
        $tl_line_h = 'line-height:'.$title_line_height.';';
    }
    if($custom_font_size){
        if($title_font_size){
            $ft_size    ='font-size:'.$title_font_size.';';
            $lh         ='line-height:'.$title_font_size.';';
        }
    }
    if($title_mt){
        $mt             ='margin-top:'.$title_mt.';';
    }
    if($title_mb){
        $mb             ='margin-bottom:'.$title_mb.';';
    }

    $title_style_css   = ( $tl_color  || $ft_size || $mt || $mb || $lh || $tl_line_h) ? 'style='. esc_attr($tl_color). $ft_size . $mb . $mt. $lh. $tl_line_h.'' : '';



    $result .= '<div class="fl-custom-title '.esc_attr( fl_sanitize_class($class) ).' '.$title_text_align.'">';

    if($sub_title_position =='before'){

        $result .= '<div class="fl-custom-pre-title " '.$sub_title_style_css.'><span class="'.$sub_title_style_font.'">'.$sub_title.'</span></div>';

    }

    $result .= '<'.$title_style.' class="fl-title_custom" '.$title_style_css.'>'.$title.'</'.$title_style.'>';

    if($sub_title_position =='after'){

        $result .= '<div class="fl-custom-pre-title " '.$sub_title_style_css.'><span class="'.$sub_title_style_font.'">'.$sub_title.'</span></div>';

    }

    $result.= '</div>';

    return $result;
}
add_action('vc_before_init', 'vc_fl_title_shortcode');

function vc_fl_title_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Title', 'fl-themes-helper'),
            'base'          => 'vc_fl_title',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'weight'        => 90,
            'icon'          => 'fl-icon icon-fl-title',
            'controls'      => 'full',
            'params'        => array(
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Text align', 'fl-themes-helper'),
                    'param_name'        => 'title_text_align',
                    'value'             => array(
                        esc_attr__("Default Left","fl-themes-helper")           => "text-left",
                        esc_attr__("Center","fl-themes-helper")                 => "text-center",
                        esc_attr__("Right","fl-themes-helper")                  => "text-right",
                    ),
                    'std' => 'text-left'
                ),
                array(
                    'type'              => 'textarea',
                    'heading'           => esc_html__('Title', 'fl-themes-helper'),
                    'param_name'        => 'title',
                    'std'               => 'Title Text',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    'type'              => 'textarea',
                    'heading'           => esc_html__('Sub Title', 'fl-themes-helper'),
                    'param_name'        => 'sub_title',
                    'std'               => '',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Title style', 'fl-themes-helper'),
                    'param_name'        => 'title_style',
                    'value'             => array(
                        esc_attr__("Default h4","fl-themes-helper")         => "h4",
                        esc_attr__("H1","fl-themes-helper")                 => "h1",
                        esc_attr__("H2","fl-themes-helper")                 => "h2",
                        esc_attr__("H3","fl-themes-helper")                 => "h3",
                        esc_attr__("H5","fl-themes-helper")                 => "h5",
                        esc_attr__("H6","fl-themes-helper")                 => "h6",
                        esc_attr__("p","fl-themes-helper")                  => "p",
                        esc_attr__("span","fl-themes-helper")               => "span",
                    ),
                    'group'             => esc_html__('Title Style Options', 'fl-themes-helper'),
                    'std' => 'h4'
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Title Color', 'fl-themes-helper'),
                    'param_name'        => 'title_color',
                    'std'               => '#1f1f1f',
                    'value'             => '',
                    'description'       => '',
                    'group'             => esc_html__('Title Style Options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Title margin top', 'fl-themes-helper'),
                    'param_name'        => 'title_mt',
                    'std'               => '',
                    'value'             => '',
                    'description'       => 'Default margin top is 0px.If you want to change the default value write (Your Number)+px. Example: 10px',
                    'edit_field_class'  => 'vc_col-sm-6',
                    'group'             => esc_html__('Title Style Options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Title margin bottom', 'fl-themes-helper'),
                    'param_name'        => 'title_mb',
                    'std'               => '20px',
                    'value'             => '',
                    'description'       => 'Default margin bottom is 20px.If you want to change the default value write (Your Number)+px. Example: 10px',
                    'edit_field_class'  => 'vc_col-sm-6',
                    'group'             => esc_html__('Title Style Options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Custom Title line height', 'fl-themes-helper'),
                    'param_name'        => 'title_line_height',
                    'std'               => '',
                    'value'             => '',
                    'description'       => 'If you want to change title line-height write (Your Number)+px. Example: 35px',
                    'group'             => esc_html__('Title Style Options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Custom Title font size', 'fl-themes-helper'),
                    'param_name'        => 'custom_font_size',
                    'value' => array(
                        esc_attr__("Enable","fl-themes-helper")         => "enable",
                        esc_attr__("Disable","fl-themes-helper")        => "disable",
                    ),
                    'group'             => esc_html__('Title Style Options', 'fl-themes-helper'),
                    'std' => 'disable'
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Title font size', 'fl-themes-helper'),
                    'param_name'        => 'title_font_size',
                    'std'               => '',
                    'value'             => '',
                    'description'       => 'If you want to change title default font-size write (Your Number)+px. Example: 35px',
                    'dependency' => array(
                        'element'                   => 'custom_font_size',
                        'value'                     => array( 'enable'),
                    ),
                    'group'             => esc_html__('Title Style Options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Sub title font style', 'fl-themes-helper'),
                    'param_name'        => 'sub_title_style_font',
                    'value'             => array(
                        esc_attr__("Default","fl-themes-helper")            => "font_two sub_title_header",
                        esc_attr__("H","fl-themes-helper")                  => "h4 sub_title_header",
                        esc_attr__("Default text font","fl-themes-helper")  => "sub_title sub_title_header",
                    ),
                    'group'             => esc_html__('Sub title style options', 'fl-themes-helper'),
                    'std' => ''
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Sub Title position', 'fl-themes-helper'),
                    'param_name'        => 'sub_title_position',
                    'value' => array(
                        esc_attr__("Before title","fl-themes-helper")           => "before",
                        esc_attr__("After title","fl-themes-helper")            => "after",
                    ),
                    'group'             => esc_html__('Sub title style options', 'fl-themes-helper'),
                    'std' => 'after'
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Sub title color', 'fl-themes-helper'),
                    'param_name'        => 'sub_title_color',
                    'std'               => '#1f1f1f',
                    'value'             => '',
                    'description'       => '',
                    'group'             => esc_html__('Sub title style options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Sub title margin top', 'fl-themes-helper'),
                    'param_name'        => 'sub_title_mt',
                    'std'               => '',
                    'value'             => '',
                    'description'       => 'Default margin top is 0px.If you want to change the default value write (Your Number)+px. Example: 10px',
                    'edit_field_class'  => 'vc_col-sm-6',
                    'group'             => esc_html__('Sub title style options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Sub title margin bottom', 'fl-themes-helper'),
                    'param_name'        => 'sub_title_mb',
                    'std'               => '',
                    'value'             => '',
                    'description'       => 'Default margin bottom is 0px.If you want to change the default value write (Your Number)+px. Example: 10px',
                    'edit_field_class'  => 'vc_col-sm-6',
                    'group'             => esc_html__('Sub title style options', 'fl-themes-helper'),
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Sub title font size', 'fl-themes-helper'),
                    'param_name'        => 'sub_title_font_size',
                    'std'               => '16px',
                    'value'             => '',
                    'description'       => 'If you want to change the default font-size sub title write (Your Number)+px. Example: 10px',
                    'group'             => esc_html__('Sub title style options', 'fl-themes-helper'),
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
                    'heading'           => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'        => 'vc_css',
                    'group'             => esc_html__('Design Options', 'fl-themes-helper'),
                )
            ),
        ));
    }
}