<?php


add_shortcode('vc_fl_icon_single', 'vc_fl_icon_single_function');

function vc_fl_icon_single_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'full_width_icon_box'   => 'full_width_disable',
        'icon_position'         => 'text-left',
        'icon_border'           => '',
        'url'                   => '#',
        'target'                => '_self',
        'icon_color'            => '#1f1f1f',
        'icon_bg'               => '',
        'icon_hover_bg'         => '',
        'icon_hover_color'      => '',
        'icon_border_color'     => '',
        'icon_font_size'        => '22px',
        'icon_style'            => 'default',
        'icon_size'             => 'icon-single-small',
        'link_icon'             => 'link_icon_no',
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
        'class'                 => '',
        'vc_css'                => '',
    ), $atts));


    $class .= fl_get_css_tab_class($atts);


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

    $idf = uniqid('fl_single_icon_');


    $result = '';

    $icn_color= '';
    $icn_size= '';
    $bg_icon= '';
    $bd_cl_icon= '';
    if($icon_color) {
        $icn_color = 'color:'.$icon_color.';';
    }
    if($icon_size) {
        $icn_size = 'font-size:'.$icon_font_size.';line-height:'.$icon_font_size.';';
    }
    if($icon_bg) {
        $bg_icon = 'background:'.$icon_bg.';';
    }
    if($icon_border_color) {
        $bd_cl_icon = 'border-color:'.$icon_border_color.';';
    }
    if($icon_style !=='default'){
        $size_icon = $icon_size;
        $icon_sigle_style =  ( $icn_color || $bg_icon || $bd_cl_icon ) ? 'style='.esc_attr($bd_cl_icon).esc_attr($bg_icon). esc_attr($icn_color). '' : '';
    } else {
        $size_icon = '';
        $icon_sigle_style =  ( $icn_color || $icn_size  ) ? 'style='. esc_attr($icn_color). esc_attr($icn_size) . '' : '';
    }



    $vc_icon_single_output = '';

    if ($icon_type != 'none') {
        $vc_icon_single_output .= '<i class="fl-single-icon ' . $icon . '" ></i>';
    }

    if($icon_hover_bg || $icon_hover_color){
        $result .= '<style type="text/css">#'.$idf.':hover{ background:'.$icon_hover_bg.'!important;}#'.$idf.':hover i {color:'.$icon_hover_color.'!important;}</style>';
    }

    if($full_width_icon_box == 'full_width'){
        $result .= '<div class="fl-icon-single-full-width '.$icon_position.'">';
    } else {
        $result .= '';
    }

    $result .= '<div class="fl-icon-single ' .fl_sanitize_class($class).' '.$icon_style.' '.$size_icon.' '.$icon_border.'" id="'.$idf.'" '.$icon_sigle_style.'>';

    if($link_icon !=='link_icon_no'){
    $result .= '<a class="fl-single-icon-link" href="' . $url . '" target="' . $target . '>';
        $result .= $vc_icon_single_output;
    $result .= '</a>';
    } else {
        $result .= $vc_icon_single_output;
    }
    if($full_width_icon_box == 'full_width'){
        $result .= '</div>';
    } else {
        $result .= '';
    }

    $result .= '</div>';


    return $result;

}




add_action('vc_before_init', 'vc_fl_icon_single_shortcode');

function vc_fl_icon_single_shortcode() {

    vc_map(array(
        'name'          => esc_html__('Single Icon', 'fl-themes-helper'),
        'base'          => 'vc_fl_icon_single',
        'icon'          => 'fl-icon icon-fl-single-icon',
        'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'controls'      => 'full',
        'weight'        => 200,
        'params'        => array(
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Full width icon box', 'fl-themes-helper'),
                'param_name'        => 'full_width_icon_box',
                'admin_label'       => true,
                'value' => array(
                        esc_attr__('Full width', 'fl-themes-helper')            => 'full_width',
                        esc_attr__('Full width disable', 'fl-themes-helper')    => 'full_width_disable',
                ),

                'std'               => 'full_width_disable'

            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon position', 'fl-themes-helper'),
                'param_name'        => 'icon_position',
                'value' => array(
                        esc_attr__('Left', 'fl-themes-helper')              => 'text-left',
                        esc_attr__('Center', 'fl-themes-helper')            => 'text-center',
                        esc_attr__('Right', 'fl-themes-helper')             => 'text-right',
                ),
                'std'               => 'text-left',
                'dependency' => array(
                        'element'               => 'full_width_icon_box',
                        'value'                 => 'full_width'
                ),

            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Link for icon', 'fl-themes-helper'),
                'param_name'        => 'link_icon',
                'value' => array(
                        esc_attr__('Enable link', 'fl-themes-helper')       => 'link_icon',
                        esc_attr__('Disable link', 'fl-themes-helper')      => 'link_icon_no',
                ),
                'std'               => 'link_icon_no'
            ),

            array(
                'type'              => 'textfield',
                'admin_label'       => true,
                'param_name'        => 'url',
                'heading'           => esc_html__('URL', 'fl-themes-helper'),
                'value'             => '#',
                'dependency' => array(
                        'element'           => 'link_icon',
                        'value'             => 'link_icon'
                ),
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Target', 'fl-themes-helper'),
                'param_name'        => 'target',
                'std'               => '_self',
                'value' => array(
                        esc_attr__('In this tab', 'fl-themes-helper')       => '_self',
                        esc_attr__('In new tab', 'fl-themes-helper')        => '_blank',
                ),
                'dependency' => array(
                        'element'       => 'link_icon',
                        'value'         => 'link_icon'
                ),
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon library', 'fl-themes-helper'),
                'value' => array(
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
                        esc_attr__('Iconic', 'fl-themes-helper')            => 'iconic',
                        esc_attr__('Fl', 'fl-themes-helper')                => 'flicon',
                ),
                'param_name'        => 'icon_type',
                'description'       => esc_html__('Select icon library', 'fl-themes-helper'),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_fontawesome',
                'settings' => array(
                        'emptyIcon'             => false,
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'fontawesome'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_openiconic',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'openiconic',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'openiconic'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_typicons',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'typicons',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'typicons'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_entypo',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'entypo',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'entypo'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_linecons',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'linecons',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'linecons'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_etline',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'etline',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'etline'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_iconmoon',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'iconmoon',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'iconmoon'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_linearicons',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'linearicons',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'linearicons'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_elusive',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'elusive',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'elusive'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_flicon',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'flicon',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'flicon'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_iconic',
                'settings' => array(
                        'emptyIcon'             => false,
                        'type'                  => 'iconic',
                        'iconsPerPage'          => 300
                ),
                'dependency' => array(
                        'element'               => 'icon_type',
                        'value'                 => 'iconic'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon color', 'fl-themes-helper'),
                'param_name'        => 'icon_color',
                'edit_field_class'  => 'vc_col-sm-3',
                'value'             => '',
                'group'             => 'Icon',
                'std'               => '#1f1f1f',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon hover color', 'fl-themes-helper'),
                'edit_field_class'  => 'vc_col-sm-3',
                'param_name'        => 'icon_hover_color',
                'value'             => '',
                'std'               => '',
                'dependency' => array(
                        'element'               => 'icon_style',
                        'value'                 => array( 'fl_icon_single_style_round','fl_icon_single_style_rounded','fl_icon_single_style_square' ),
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon Border color', 'fl-themes-helper'),
                'edit_field_class'  => 'vc_col-sm-3',
                'param_name'        => 'icon_border_color',
                'value'             => '',
                'std'               => '',
                'dependency' => array(
                        'element'               => 'icon_border',
                        'value'                 => array( 'fl_icon_single_style_border_solid','fl_icon_single_style_border_dashed'),
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon background color', 'fl-themes-helper'),
                'param_name'        => 'icon_bg',
                'value'             => '',
                'std'               => '',
                'dependency' => array(
                        'element'               => 'icon_style',
                        'value'                 => array( 'fl_icon_single_style_round','fl_icon_single_style_rounded','fl_icon_single_style_square' ),
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon background hover color', 'fl-themes-helper'),
                'param_name'        => 'icon_hover_bg',
                'value'             => '',
                'std'               => '',
                'dependency' => array(
                        'element'               => 'icon_style',
                        'value'                 => array( 'fl_icon_single_style_round','fl_icon_single_style_rounded','fl_icon_single_style_square' ),
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon style', 'fl-themes-helper'),
                'param_name'        => 'icon_style',
                'group'             => 'Icon',
                'value' => array(
                        esc_attr__('Default', 'fl-themes-helper')       => 'default',
                        esc_attr__('Round', 'fl-themes-helper')         => 'fl_icon_single_style_round',
                        esc_attr__('Rounded', 'fl-themes-helper')       => 'fl_icon_single_style_rounded',
                        esc_attr__('Square', 'fl-themes-helper')        => 'fl_icon_single_style_square',
                ),
                'std'               => 'default',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon border style', 'fl-themes-helper'),
                'param_name'        => 'icon_border',
                'dependency' => array(
                        'element'                               => 'icon_style',
                        'value'                                 => array( 'fl_icon_single_style_round','fl_icon_single_style_rounded','fl_icon_single_style_square' ),
                ),
                'value' => array(
                        esc_attr__('None', 'fl-themes-helper')              => '',
                        esc_attr__('Border Solid', 'fl-themes-helper')      => 'fl_icon_single_style_border_solid',
                        esc_attr__('Border Dashed', 'fl-themes-helper')     => 'fl_icon_single_style_border_dashed',
                ),
                'std'               => '',
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Icon size in px', 'fl-themes-helper'),
                'param_name'        => 'icon_font_size',
                'dependency' => array(
                        'element'                               => 'icon_style',
                        'value'                                 => array( 'default'),
                ),
                'value'             => '',
                'group'             => 'Icon',
                'std'               => '22px'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon size', 'fl-themes-helper'),
                'param_name'        => 'icon_size',
                'dependency' => array(
                        'element'                               => 'icon_style',
                        'value'                                 => array( 'fl_icon_single_style_round','fl_icon_single_style_rounded','fl_icon_single_style_square' ),
                ),
                'value' => array(
                        esc_attr__('Ultra small', 'fl-themes-helper')       => 'icon-single-ultra-small',
                        esc_attr__('Small', 'fl-themes-helper')             => 'icon-single-small',
                        esc_attr__('Normal', 'fl-themes-helper')            => 'icon-single-normal',
                        esc_attr__('Medium', 'fl-themes-helper')            => 'icon-single-medium',
                        esc_attr__('Large', 'fl-themes-helper')             => 'icon-single-large',
                ),
                'group'             => 'Icon',
                'std'               => 'icon-single-small',
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
        )

    ));
}
