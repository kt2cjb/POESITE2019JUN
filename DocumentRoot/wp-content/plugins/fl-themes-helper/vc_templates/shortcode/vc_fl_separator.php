<?php
/*
 * Shortcode Alert
 * */

add_shortcode('vc_fl_separator', 'vc_fl_separator_function');

function vc_fl_separator_function($atts, $content = null) {

    extract(shortcode_atts(array(
       'separator_align'            => 'left',
       'separator_style'            => 'line',
       'separator_style_line'       => 'line',
       'sp_width'                   => '100px',
       'separator_line_height'      => 'fl_small_line',
       'separator_line'             => 'enable',
       'separator_img'              => '',
       'separator_img_position'     => 'left',
       'img_mg'                     => '10px',
       'sp_color'                   => '#f1f1f1',
       'sp_color_line_one'          => '#f1f1f1',
       'sp_color_line_two'          => '#929292',
       'icon_type'                  => 'none',
       'icon_fontawesome'           => '',
       'icon_openiconic'            => '',
       'icon_typicons'              => '',
       'icon_entypo'                => '',
       'icon_linecons'              => '',
       'icon_elusive'               => '',
       'icon_etline'                => '',
       'icon_iconmoon'              => '',
       'icon_linearicons'           => '',
       'icon_flicon'                => '',
       'icon_iconic'                => '',
       'icon_size'                  => '18px',
       'icon_color'                 => '#1f1f1f',
       'icon_mg'                    => '10px',
       'class'                      => '',
       'vc_css'                     => '',
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
    $icon_fs ='';
    $cl_icon ='';
    $mg_icon ='';
    if($icon_size){
        $icon_fs = 'font-size:'.$icon_size.';line-height:'.$icon_size.';';
    }
    if($icon_color){
        $cl_icon = 'color:'.$icon_color.';';
    }
    if($icon_mg){
        $mg_icon = 'margin-left:'. $icon_mg.';margin-right:'.$icon_mg.';';

    }

    $icon_style_css = ( $icon_fs || $cl_icon || $mg_icon ) ? 'style='.  $icon_fs  . $cl_icon . $mg_icon. '' : '';

    $vc_icon = '';
    if ($icon_type != 'none') {
        $vc_icon .= '<i class="fl-separator-icon  ' . $icon . '" '.$icon_style_css.'></i>';
    }
    $mg_ing ='';
    if($img_mg) {
        $mg_ing = 'margin-right:'.$img_mg.';margin-left:'.$img_mg.';';
    }

    $img_style_css = ( $mg_ing ) ? 'style='.  $mg_ing  . '' : '';

    $sp_wth = '';
    if($sp_width){
        $sp_wth ='max-width:'.$sp_width.';';
    }

    switch ($separator_style_line) {
        case 'line' :
            $line_style = '';
            if($sp_color){
                $color_sp = 'background-color:'.$sp_color.';';
            }
            break;
        case 'doted' :
            $line_style = 'fl_line_dotted';
            if($sp_color){
                $color_sp = 'border-color:'.$sp_color.';';
            }
            break;
        case 'dashed' :
            $line_style = 'fl_line_dashed';
            if($sp_color){
                $color_sp = 'border-color:'.$sp_color.';';
            }
            break;
    }


    if($separator_line =='disable') {
        $line_inner_disable = 'fl_line_disable';
        switch ($separator_img_position) {
            case 'left' :
                $separator_img_align = 'fl_img_left';
                break;
            case 'center' :
                $separator_img_align = 'fl_img_center';
                break;
            case 'right' :
                $separator_img_align = 'fl_img_right';
                break;
        }
    } else {
        $separator_img_align ='';
        $line_inner_disable ='';
    }

    $attachment = fl_get_attachment($separator_img, 'full');
    if($separator_img){
        $separator_img = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_separator_img '.$line_inner_disable.'" '.$img_style_css.'>';
    }



    $separator_style_css = ( $sp_wth ) ? 'style='.  $sp_wth  . '' : '';

    $separator_line_style_css = ( $color_sp ) ? 'style='. $color_sp . '' : '';

    $color_sp_one = $color_sp_two = '';

    if($sp_color_line_one){
        $color_sp_one = 'background-color:'.$sp_color_line_one.';';
    }
    if($sp_color_line_two){
        $color_sp_two = 'background-color:'.$sp_color_line_two.';';
    }

    $separator_line_style_css_one = ( $color_sp_one ) ? 'style='. $color_sp_one . '' : '';

    $separator_line_style_css_two = ( $color_sp_two ) ? 'style='. $color_sp_two . '' : '';

    switch ($separator_align) {
        case 'left' :
            $separator_position_align = 'fl_separator_left';
            break;
        case 'center' :
            $separator_position_align = 'fl_separator_center';
            break;
        case 'right' :
            $separator_position_align = 'fl_separator_right';
            break;
    }

    switch ($separator_style) {
        case 'line' :
            $separator_inner = '<div class="fl_inner_separator" '.$separator_style_css.'><span class="fl-separator-line '.$line_style.'" '.$separator_line_style_css.'></span></div>';
            break;
        case 'line_icon' :
            $separator_inner = '<div class="fl_inner_separator_icon" '.$separator_style_css.'><span class="fl-separator-line-left '.$line_style.'" '.$separator_line_style_css.'></span>'.$vc_icon.'<span class="fl-separator-line-right '.$line_style.'" '.$separator_line_style_css.'></span></div>';
            break;
        case 'custom_img' :
            $separator_inner = '<div class="fl_inner_separator_img '.$separator_img_align.'" '.$separator_style_css.'>';
            if($separator_line !='disable') {
                $separator_inner .= '<span class="fl-separator-line-left '.$line_style.'" '.$separator_line_style_css.'></span>';
            }

            $separator_inner .= $separator_img;

            if($separator_line !='disable') {
                $separator_inner .= '<span class="fl-separator-line-right '.$line_style.'" '.$separator_line_style_css.'></span>';
            }
            $separator_inner .= '</div>';
            break;
        case 'title_separator':
            $separator_inner = '<div class="fl_inner_separator_title_style" '.$separator_style_css.'><span class="fl-separator-line-big" '.$separator_line_style_css_one.'></span><span class="fl-separator-line-small" '.$separator_line_style_css_two.'></span></div>';
        break;
    }


    $result = '';



    $result .= '<div class="fl-separator '.$separator_position_align.' '.$separator_line_height.' '.esc_attr( fl_sanitize_class($class) ).'">';

    $result .= $separator_inner;

    $result.= '</div>';

    return $result;
}
add_action('vc_before_init', 'vc_fl_separator_shortcode');

function vc_fl_separator_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'                  => esc_html__('Separator', 'fl-themes-helper'),
            'base'                  => 'vc_fl_separator',
            'category'              => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'                  => 'fl-icon icon-fl-separator',
            'controls'              => 'full',
            'weight'                => 200,
            'params'=> array(
                array(
                    'type'                  => 'dropdown',
                    'heading'               => esc_html__('Separator position align', 'fl-themes-helper'),
                    'param_name'            => 'separator_align',
                    'value'                 => array(
                        esc_attr__("Default Left","fl-themes-helper")           => "left",
                        esc_attr__("Center","fl-themes-helper")                 => "center",
                        esc_attr__("Right","fl-themes-helper")                  => "right",
                    ),
                    'std'                   => 'left'
                ),
                array(
                    'type'                  => 'dropdown',
                    'heading'               => esc_html__('Separator Style', 'fl-themes-helper'),
                    'param_name'            => 'separator_style',
                    'value'                 => array(
                        esc_attr__("Default Line","fl-themes-helper")           => "line",
                        esc_attr__("Line and icon","fl-themes-helper")          => "line_icon",
                        esc_attr__("Custom img","fl-themes-helper")             => "custom_img",
                        esc_attr__("Tittle Separator","fl-themes-helper")       => "title_separator",
                    ),
                    'std'                   => 'line'
                ),
                array(
                    'type'                  => 'dropdown',
                    'heading'               =>  esc_html__('Separator line', 'fl-themes-helper'),
                    'param_name'            => 'separator_line',
                    'value'                 => array(
                        esc_attr__("Enable","fl-themes-helper")                   => "enable",
                        esc_attr__("Disable","fl-themes-helper")                  => "disable",
                    ),
                    'dependency' => array(
                        'element'                                     => 'separator_style',
                        'value'                                       => 'custom_img'
                    ),
                    'std'                   => 'enable'
                ),
                array(
                    'type'                  => 'attach_image',
                    'heading'               =>  esc_html__('Separator img', 'fl-themes-helper'),
                    'param_name'            => 'separator_img',
                    'value'                 => '',
                    'dependency' => array(
                        'element'                                    => 'separator_style',
                        'value'                                      => 'custom_img'
                    ),
                    'std'                   => 'enable'
                ),
                array(
                    'type'                  => 'dropdown',
                    'heading'               => esc_html__('Img position', 'fl-themes-helper'),
                    'param_name'            => 'separator_img_position',
                    'value'                 => array(
                        esc_attr__("Left","fl-themes-helper")                    => "left",
                        esc_attr__("Center","fl-themes-helper")                  => "center",
                        esc_attr__("Right","fl-themes-helper")                   => "right",
                    ),
                    'dependency' => array(
                        'element'                                    => 'separator_line',
                        'value'                                      => 'disable'
                    ),
                    'std'                   => 'left'
                ),
                array(
                    'type'                  => 'dropdown',
                    'heading'               => esc_html__('Separator Style line', 'fl-themes-helper'),
                    'param_name'            => 'separator_style_line',
                    'value'                 => array(
                        esc_attr__("Default Line","fl-themes-helper")           => "line",
                        esc_attr__("Doted","fl-themes-helper")                  => "doted",
                        esc_attr__("Dashed","fl-themes-helper")                 => "dashed",
                    ),
                    'dependency' => array(
                        'element'                                    => 'separator_style',
                        'value_not_equal_to'                         => 'title_separator'
                    ),
                    'std'                   => 'line'
                ),
                array(
                    'type'                  => 'dropdown',
                    'heading'               => esc_html__('Separator line height', 'fl-themes-helper'),
                    'param_name'            => 'separator_line_height',
                    'value'                 => array(
                        esc_attr__("Default Small","fl-themes-helper")           => "fl_small_line",
                        esc_attr__("Medium","fl-themes-helper")                  => "fl_medium_line",
                        esc_attr__("Large","fl-themes-helper")                   => "fl_large_line",
                    ),
                    'std'                   => 'fl_small_line'
                ),
                array(
                    'type'                  => 'colorpicker',
                    'heading'               => esc_html__('Separator color', 'fl-themes-helper'),
                    'param_name'            => 'sp_color',
                    'value'                 => '',
                    'std'                   => '#f1f1f1',
                    'description'           => '',
                    'dependency' => array(
                        'element'                               => 'separator_style',
                        'value'                                 => array( 'line','line_icon','text' ),
                    ),
                    array(
                        'element'                                    => 'separator_style',
                        'value_not_equal_to'                         => 'title_separator'
                    ),
                    'group'                 => 'Style setting',
                ),

                array(
                    'type'                  => 'colorpicker',
                    'heading'               => esc_html__('Big Separator color', 'fl-themes-helper'),
                    'param_name'            => 'sp_color_line_one',
                    'value'                 => '',
                    'std'                   => '#f1f1f1',
                    'description'           => '',
                    'dependency' => array(
                        'element'                                    => 'separator_style',
                        'value'                                      => 'title_separator'
                    ),
                    'group'                 => 'Style setting',
                ),
                array(
                    'type'                  => 'colorpicker',
                    'heading'               => esc_html__('Small Separator color', 'fl-themes-helper'),
                    'param_name'            => 'sp_color_line_two',
                    'value'                 => '',
                    'std'                   => '#929292',
                    'description'           => '',
                    'dependency' => array(
                        'element'                                    => 'separator_style',
                        'value'                                      => 'title_separator'
                    ),
                    'group'                 => 'Style setting',
                ),

                array(
                    'type'                  => 'textfield',
                    'heading'               => esc_html__('Separator width', 'fl-themes-helper'),
                    'param_name'            => 'sp_width',
                    'value'                 => '',
                    'std'                   => '100px',
                    'description'           => '',
                    'group'                 => 'Style setting',
                ),
                array(
                    'type'                  => 'textfield',
                    'heading'               => esc_html__('Img margin left and right', 'fl-themes-helper'),
                    'param_name'            => 'img_mg',
                    'value'                 => '',
                    'std'                   => '10px',
                    'dependency' => array(
                        'element'                               => 'separator_style',
                        'value'                                 => 'custom_img'
                    ),
                    'group'                 => 'Style setting',
                ),
                array(
                    'type'                  => 'dropdown',
                    'heading'               => esc_html__('Icon library', 'fl-themes-helper'),
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
                    'param_name'            => 'icon_type',
                    'description'           => esc_html__('Select icon library', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                               => 'separator_style',
                        'value'                                 => 'line_icon'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_fontawesome',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'fontawesome'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_openiconic',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'openiconic',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'openiconic'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_typicons',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'typicons',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'typicons'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_entypo',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'entypo',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'entypo'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_linecons',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'linecons',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'linecons'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_etline',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'etline',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'etline'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_iconmoon',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'iconmoon',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'iconmoon'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_linearicons',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'linearicons',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'linearicons'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_elusive',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'elusive',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'elusive'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_flicon',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'flicon',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'flicon'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'iconpicker',
                    'heading'               => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name'            => 'icon_iconic',
                    'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'iconic',
                        'iconsPerPage'                          => 300
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'iconic'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'colorpicker',
                    'heading'               => esc_html__('Icon color', 'fl-themes-helper'),
                    'param_name'            => 'icon_color',
                    'value'                 => '',
                    'std'                   => '#1f1f1f',
                    'dependency' => array(
                        'element'                               => 'separator_style',
                        'value'                                 => 'line_icon'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'textfield',
                    'heading'               => esc_html__('Icon size', 'fl-themes-helper'),
                    'param_name'            => 'icon_size',
                    'value'                 => '',
                    'std'                   => '18px',
                    'dependency' => array(
                        'element'                               => 'separator_style',
                        'value'                                 => 'line_icon'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'textfield',
                    'heading'               => esc_html__('Icon margin left and right', 'fl-themes-helper'),
                    'param_name'            => 'icon_mg',
                    'value'                 => '',
                    'std'                   => '10px',
                    'dependency' => array(
                        'element'                               => 'separator_style',
                        'value'                                 => 'line_icon'
                    ),
                    'group'                 => 'Icon'
                ),
                array(
                    'type'                  => 'textfield',
                    'heading'               => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'            => 'class',
                    'value'                 => '',
                    'description'           => '',
                ),
                array(
                    'type'                  => 'css_editor',
                    'heading'               => esc_html__('CSS', 'fl-themes-helper'),
                    'param_name'            => 'vc_css',
                    'group'                 => esc_html__('Design Options', 'fl-themes-helper'),
                )
            ),
        ));
    }
}