<?php
/*
 * Shortcode counters
 * */

add_shortcode('vc_fl_counters', 'vc_fl_counters_function');

function vc_fl_counters_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'text_position'         => 'text-center',
    'count_font_style'      => 'fl-h-style',
    'suffix'                => '',
    'preffix'               => '',
    'count'                 => 988,
    'refresh_interval'      => 5,
    'duration'              => 2000,
    'count_font_size'       => 25,
    'count_margin_bottom'   => 20,
    'margin_top'            => '',
    'count_text_color'      => '',
    'title_position'        => 'by',
    'title_text_color'      => '#1f1f1f',
    'title_style'           => 'h5',
    'title_margin_bottom'   => '',
    'title_text'            => 'Title Text',
    'title_fz'              => 19,
    'icon_type'             => 'none',
    'icon_fontawesome'      => '',
    'icon_openiconic'       => '',
    'icon_typicons'         => '',
    'icon_entypo'           => '',
    'icon_linecons'         => '',
    'icon_elusive'          => '',
    'icon_etline'           => '',
    'icon_iconmoon'         => '',
    'icon_linearicons'      => '',
    'icon_flicon'           => '',
    'icon_iconic'           => '',
    'icon'                  => '',
    'icon_font_size'        => 20,
    'icon_color'            => '#1f1f1f',
    'class'                 => '',
    'vc_css'                => '',
    ), $atts));



    switch ($icon_type) {
        case 'fontawesome':
            $icon = $atts['icon_fontawesome'];
            break;
        case 'openiconic':
            $icon = $atts['icon_openiconic'];
            break;
        case 'typicons':
            $icon = $atts['icon_typicons'];
            break;
        case 'entypo':
            $icon = $atts['icon_entypo'];
            break;
        case 'linecons':
            $icon = $atts['icon_linecons'];
            break;
        case 'elusive':
            $icon = $atts['icon_elusive'];
            break;
        case 'etline':
            $icon = $atts['icon_etline'];
            break;
        case 'iconmoon':
            $icon = $atts['icon_iconmoon'];
            break;
        case 'linearicons':
            $icon = $atts['icon_linearicons'];
            break;
        case 'flicon':
            $icon = $atts['icon_flicon'];
            break;
        case 'iconic':
            $icon = $atts['icon_iconic'];
            break;
    }

    vc_icon_element_fonts_enqueue($icon_type);


    $class .= fl_get_css_tab_class($atts);

    $ct_t_c=$ct_fz= $ct_mt= $ct_mb= $icon_cl=$icon_fz=$tl_cl=$tl_mb=$tl_fz='';
    if($count_text_color){
        $ct_t_c = 'color:'.$count_text_color.';';
    }

    if($count_font_size){
        $ct_fz = 'font-size:'.$count_font_size.'px;';
    }

    if($margin_top){
        $ct_mt = 'margin-top:'.$margin_top.'px;';
    }
    if($count_margin_bottom){
        $ct_mb = 'margin-bottom:'.$count_margin_bottom.'px;';
    }
    $counter_number_style_css   = ( $ct_t_c||$ct_fz||$ct_mt||$ct_mb) ? 'style='.$ct_t_c.$ct_fz.$ct_mt.$ct_mb.'' : '';

    if($icon_font_size){
        $icon_fz = 'font-size:'.$icon_font_size.'px;';
    }
    if($icon_color){
        $icon_cl = 'color:'.$icon_color.';';
    }
    $icon_style_css   = ( $icon_fz||$icon_cl) ? 'style='.$icon_fz.$icon_cl.'' : '';

    if($title_text_color){
        $tl_cl = 'color:'.$title_text_color.';';
    }
    if($title_margin_bottom){
        $tl_mb = 'margin-bottom:'.$title_margin_bottom.';';
    }
    if($title_style =='fl-custom-title-size'){
        if($title_fz){
            $tl_fz = 'font-size:'.$title_fz.'px;';
        }

    }

    $title_style_css = ( $tl_cl||$tl_mb||$tl_fz) ? 'style='.$tl_cl.$tl_mb.$tl_fz.'' : '';





    $result = '';
    $icon_output = '';

    if ( $icon_type != 'none' ) {

        $icon_output .= '<i class="fl-counter-icon ' . $icon . '" '.$icon_style_css.'></i>';
    }


    $result .= '<div class="fl-counters'.' ' .esc_attr( $text_position .' ' . fl_sanitize_class($class) ).'" data-counter-duration="'.$duration.'">';
    if($title_text){
        if ( $title_position == 'before' ) {
            $result .= '<div class="fl-counter-title '.$title_style.'" '.$title_style_css.'>' . $title_text . '</div>';
        }
    }

    $result .= $icon_output;

    $result.= '<div class="fl-counter-number '.$count_font_style.'" '.$counter_number_style_css.'>';
    $result .= '<span class="fl-counter-preffix">'.$preffix.' </span>'.'<span class="fl-counter" data-to="'.$count.'" data-speed = "'.$duration.'" data-refresh-interval ="'.$refresh_interval.'">'.$count.'</span>'.'<span class="fl-counter-suffix">'.$suffix.' </span>';
    $result.= '</div>';
    if($title_text) {
        if ( $title_position == 'by' ) {
            $result .= '<div class="fl-counter-title '.$title_style.'" '.$title_style_css.'>' . $title_text . '</div>';
        }
    }
    $result .= '</div>';


    return $result;
}
add_action('vc_before_init', 'vc_fl_counters_shortcode');

function vc_fl_counters_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Counters', 'fl-themes-helper'),
            'base'          => 'vc_fl_counters',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'          => 'fl-icon icon-fl-counters',
            'controls'      => 'full',
            'weight'        => 800,
            'params'        => array(
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Counter Box Text align', 'fl-themes-helper'),
                    'param_name'    => 'text_position',
                    'value'         => array(
                            esc_attr__('Center', 'fl-themes-helper')        => 'text-center',
                            esc_attr__('Right', 'fl-themes-helper')         => 'text-right',
                            esc_attr__('Left', 'fl-themes-helper')          => 'text-left'
                    ),
                    'std'           => 'text-center',
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Counter text style', 'fl-themes-helper'),
                    'param_name'    => 'count_font_style',
                    'value'         => array(
                        esc_attr__("H style","fl-themes-helper")           => "fl-h-style",
                        esc_attr__("Text","fl-themes-helper")              => " ",

                    ),
                    'std'           => 'fl-h-style'
                ),
                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__( "Count Font size", "fl-themes-helper" ),
                    "param_name"        => "count_font_size",
                    'value'             => 25,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-4'
                ),
                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__( "Animation duration", "fl-themes-helper" ),
                    "param_name"        => "duration",
                    'value'             => 2000,
                    'min'               => 100,
                    'max'               => 999999,
                    'step'              => 100,
                    'suffix'            => 'ms',
                    'edit_field_class'  => 'vc_col-sm-4',
                    "description"       => esc_html__( "Standard 2000ms.", "fl-themes-helper" )
                ),
                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__( "Animation duration", "fl-themes-helper" ),
                    "param_name"        => "refresh_interval",
                    'value'             => 5,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'edit_field_class'  => 'vc_col-sm-4',
                    "description"       => esc_html__( "Standard 5.", "fl-themes-helper" )
                ),
                array(
                    "type"          => "textfield",
                    "heading"       => esc_html__("Preffix", 'fl-themes-helper'),
                    "param_name"    => "preffix",
                    "value"         => esc_html__("", 'fl-themes-helper'),
                    "description"   => esc_html__("Enter the preffix for rotate. Use: %, #, ^,& etc.", 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4'
                ),
                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__( "Count", "fl-themes-helper" ),
                    "param_name"        => "count",
                    'value'             => 988,
                    'min'               => 0,
                    'max'               => 9999999999,
                    'step'              => 1,
                    'edit_field_class'  => 'vc_col-sm-4'
                ),
                array(
                    "type"          => "textfield",
                    "heading"       => esc_html__("Suffix", 'fl-themes-helper'),
                    "param_name"    => "suffix",
                    "value"         => esc_html__("", 'fl-themes-helper'),
                    'std'           => '',
                    "description"   => esc_html__("Enter the suffix for rotate. Use: %, #, ^,& etc.", 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4'
                ),
                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__("Counter Margin top", 'fl-themes-helper'),
                    "param_name"        => "margin_top",
                    'value'             => '',
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-4'
                ),
                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__("Counter Margin Bottom", 'fl-themes-helper'),
                    "param_name"        => "count_margin_bottom",
                    'value'             => 20,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'edit_field_class'  => 'vc_col-sm-4'
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'count_text_color',
                    'heading'           => esc_html__('Count color', 'test'),
                    'value'             => '',
                    'std'               => '',
                    'edit_field_class'  => 'vc_col-sm-4'
                ),







                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "heading"       => esc_html__( "Title text", "fl-themes-helper" ),
                    'admin_label'   => true,
                    "param_name"    => "title_text",
                    "value"         => '',
                    'std'           => 'Title Text',
                    'group'         => 'Title setting',
                ),
                array(
                    "type"          => "dropdown",
                    "heading"       => esc_html__( "Title position", "fl-themes-helper" ),
                    "param_name"    => "title_position",
                    'std'           => 'by',
                    "value"         => array(
                            esc_html__('Before counter','fl-themes-helper')         => 'before',
                            esc_html__('By counter','fl-themes-helper')             => 'by',
                    ),
                    'group'         => 'Title setting',
                    'edit_field_class'  => 'vc_col-sm-6',
                    "description"   => esc_html__( "Select title position.", "fl-themes-helper" ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Title size', 'fl-themes-helper'),
                    'param_name'    => 'title_style',
                    'value' => array(
                            'H1'                            => 'h1',
						    'H2'                            => 'h2',
                            'H3'                            => 'h3',
                            'H4'                            => 'h4',
                            'H5'                            => 'h5',
                            'H6'                            => 'h6',
                            'Text style custom size'        => 'fl-custom-title-size',
                    ),
                    'std'           => 'h5',
                    'edit_field_class'  => 'vc_col-sm-6',
                    'group'         => 'Title setting',
                ),
                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__( "Title Margin Bottom", "fl-themes-helper" ),
                    "param_name"        => "title_fz",
                    'value'             => 19,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'group'             => 'Title setting',
                    'dependency'        => array(
                                'element'       => 'title_style',
                                'value'         => 'fl-custom-title-size',
                    ),
                    'edit_field_class'  => 'vc_col-sm-4',
                ),

                array(
                    'type'              => 'fl_number',
                    "class"             => "",
                    "heading"           => esc_html__( "Title Margin Bottom", "fl-themes-helper" ),
                    "param_name"        => "title_margin_bottom",
                    'value'             => '',
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'group'             => 'Title setting',
                    'edit_field_class'  => 'vc_col-sm-4',
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'title_text_color',
                    'heading'           => esc_html__('Title color', 'test'),
                    'value'             => '',
                    'std'               => '',
                    'edit_field_class'  => 'vc_col-sm-4',
                    'group'             => 'Title setting',
                ),


                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Icon library', 'fl-themes-helper'),
                    'value'         => array(
                            esc_attr__('None', 'fl-themes-helper')              => 'none',
                            esc_attr__('Font Awesome', 'fl-themes-helper')      => 'fontawesome',
                            esc_attr__('Open Iconic', 'fl-themes-helper')       => 'openiconic',
                            esc_attr__('Typicons', 'fl-themes-helper')          => 'typicons',
                            esc_attr__('Entypo', 'fl-themes-helper')            => 'entypo',
                            esc_attr__('Linecons', 'fl-themes-helper')          => 'linecons',
                            esc_attr__('Etline', 'fl-themes-helper')            => 'etline',
                            esc_attr__('Iconmoon', 'fl-themes-helper')          => 'iconmoon',
                            esc_attr__('Linearicons', 'fl-themes-helper')       => 'linearicons',
                            esc_attr__('Elusive', 'fl-themes-helper')           => 'elusive',
                            esc_attr__('Fl Icons', 'fl-themes-helper')          => 'flicon',
                            esc_attr__('iconic Icons', 'fl-themes-helper')      => 'iconic',
                    ),
                    'param_name'    => 'icon_type',
                    'description'   => esc_html__('Select icon library', 'fl-themes-helper'),
                    'group'         => 'Icon'
                ),
                array(
                    'type'          => 'iconpicker',
                    'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'    => 'icon_fontawesome',
                    'settings'      => array(
                            'emptyIcon'             => false,
                            'iconsPerPage'          => 300
                    ),
                    'dependency'    => array(
                            'element'               => 'icon_type',
                            'value'                 => 'fontawesome'
                    ),
                    'group'         => 'Icon'
                ),
                array(
                    'type'          => 'iconpicker',
                    'heading'       => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'    => 'icon_openiconic',
                    'settings'      => array(
                            'emptyIcon'             => false,
                            'type'                  => 'openiconic',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'    => array(
                            'element'               => 'icon_type',
                            'value'                 => 'openiconic'
                    ),
                    'group' => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_typicons',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'typicons',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'typicons'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_entypo',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'entypo',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'entypo'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_linecons',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'linecons',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'linecons'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_etline',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'etline',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'etline'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_iconmoon',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'iconmoon',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'iconmoon'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_linearicons',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'linearicons',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'linearicons'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_elusive',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'elusive',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'elusive'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_flicon',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'flicon',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'flicon'
                    ),
                    'group'        => 'Icon'
                ),
                array(
                    'type'         => 'iconpicker',
                    'heading'      => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'   => 'icon_iconic',
                    'settings'     => array(
                            'emptyIcon'             => false,
                            'type'                  => 'iconic',
                            'iconsPerPage'          => 300
                    ),
                    'dependency'   => array(
                            'element'               => 'icon_type',
                            'value'                 => 'iconic'
                    ),
                    'group'        => 'Icon'
                ),

                array(
                    'type'              => 'fl_number',
                    'heading'           => esc_html__('Icon font size', 'test'),
                    'param_name'        => 'icon_font_size',
                    'value'             => 20,
                    'min'               => 0,
                    'max'               => 999999,
                    'step'              => 1,
                    'suffix'            => 'px',
                    'group'             => 'Icon'
                ),
                array(
                    'type'          => 'colorpicker',
                    'param_name'    => 'icon_color',
                    'heading'       => esc_html__('Icon color', 'test'),
                    'value'         => '',
                    'std'           => '#1f1f1f',
                    'group'         => 'Icon'
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
                    'heading'       => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'    => 'vc_css',
                    'group'         => esc_html__('Design Options', 'fl-themes-helper'),
                )
            ),
        ));
    }
}