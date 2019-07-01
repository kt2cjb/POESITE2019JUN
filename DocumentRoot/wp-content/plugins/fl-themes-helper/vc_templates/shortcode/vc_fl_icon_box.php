<?php


add_shortcode('vc_fl_icon_box', 'vc_fl_icon_box_function');

function vc_fl_icon_box_function($atts, $content = null)
{

    extract(shortcode_atts(array(
        'icon_style'            => 'default',
        'icon_hover_color'      => '',
        'icon_bg_hover_color'   => '',
        'icon_border'           => '',
        'icon_border_color'     => '',
        'icon_font_size'        => '22px',
        'icon_size'             => 'icon-small',
        'icon_line_height'      => '40px',
        'icon_position'         => 'text-center',
        'icon_box_position'     => 'fl_icon_box_icon_position_top',
        'url'                   => '#',
        'target'                => '_self',
        'icon_color'            => '#1f1f1f',
        'link_icon'             => 'link_icon_no',
        'icon_type'             => 'none',
        'icon_margin_right'     => '',
        'icon_margin_left'      => '',
        'icon_margin_bottom'    => '',
        'icon_margin_top'       => '',
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
        'title_style'           => 'h5',
        'title_color'           => '#1f1f1f',
        'text_position'         => 'text-center',
        'title_content'         => 'Some Text',
        'title_margin_bottom'   => '10px',
        'title_margin_top'      => '',
        'icon_bg_color'         => '#1f1f1f',
        'icon_text_content'     => 'Suspendisse imperdiet augue eu neque semper lobortis.',
        'content_color'         => '#1f1f1f',
        'font_size_content'     => '',
        'line_height_content'   => '',
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

    $idf = uniqid('fl_icon_box_');

    $result = '';

    //Title Style
    $icon_title_color = '';
    $icon_title_margin_bottom = '';
    $icon_title_margin_top = '';
    if($title_color){
        $icon_title_color = 'color:'.$title_color.';';
    }

    if($title_margin_bottom){
        $icon_title_margin_bottom = 'margin-bottom:'.$title_margin_bottom.';';
    }

    if($title_margin_top){
        $icon_title_margin_top = 'margin-top:'.$title_margin_top.';';
    }

    //Icon Style
    $icon_font_color = '';
    if($icon_color){
        $icon_font_color = 'color:'.$icon_color.';';
    }

    $icon_margin_bottom_css ='';
    $icon_margin_top_css ='';
    $icon_margin_left_css ='';
    $icon_margin_right_css ='';
    $bg_color_icon ='';
    $border_color ='';
    if($icon_margin_bottom){
        $icon_margin_bottom_css = 'margin-bottom:'.$icon_margin_bottom.';';
    }
    if($icon_margin_top){
        $icon_margin_top_css = 'margin-top:'.$icon_margin_top.';';
    }

    if($icon_margin_left){
        $icon_margin_left_css = 'margin-left:'.$icon_margin_left.';';
    }
    if($icon_margin_right){
        $icon_margin_right_css = 'margin-right:'.$icon_margin_right.';';
    }

    if( $icon_border_color ){
        $border_color = 'border-color:'.$icon_border_color .';';
    }
    if($icon_style !=="default"){
        if($icon_bg_color){
            $bg_color_icon = 'background:'.$icon_bg_color.';';
        }
    }
    $font_size_icon ='';
    if( $icon_style =='default' ){
        if($icon_font_size) {
            $font_size_icon = 'font-size:'.$icon_font_size.';line-height:'.$icon_font_size.';';
        } else {
            $font_size_icon = '';
        }


    }

    if( $icon_style !=='default' ){
        $size_icon = $icon_size;
        $icon_style_css   = ( $icon_font_color ) ? 'style='. esc_attr($icon_font_color). '' : '';
    } else {
        $size_icon= '';
        $icon_style_css   = ( $icon_font_color  || $font_size_icon) ? 'style='. esc_attr($icon_font_color). $font_size_icon .'' : '';
    }




    $title_style_css   = ( $icon_title_color || $icon_title_margin_bottom  || $icon_title_margin_top ) ? 'style='. esc_attr($icon_title_color) . esc_attr($icon_title_margin_bottom). esc_attr($icon_title_margin_top) . '' : '';

    $icon_box_icon_style =  ( $border_color || $bg_color_icon  || $icon_margin_bottom_css || $icon_margin_top_css  || $icon_margin_left_css || $icon_margin_right_css ) ? 'style='.esc_attr($border_color).esc_attr($bg_color_icon) . esc_attr($icon_margin_bottom_css) . esc_attr($icon_margin_top_css). esc_attr($icon_margin_left_css). esc_attr($icon_margin_right_css) . '' : '';

    $vc_icon_box_output = '';

    if ($icon_type != 'none') {
        $vc_icon_box_output .= '<div class="fl-icon-inner-box '.$icon_style.' '.$icon_border.' '.$size_icon.'" '.$icon_box_icon_style.'><i class="fl-box-icon  ' . $icon . '" '.$icon_style_css.'></i></div>';
    }
    $color_content = '';
    $content_font_size = '';
    $content_line_height = '';
    if($content_color){
        $color_content = 'color:'.$content_color.';';
    }
    if($font_size_content){
        $content_font_size= 'font-size:'.$font_size_content.';';
    }
    if($line_height_content){
      $content_line_height ='line-height:'.$line_height_content.';';
    }

    $content_style_css   = ( $color_content  || $content_font_size ||$content_line_height ) ? 'style='. $color_content. $content_font_size .$content_line_height.'' : '';

    $result .= '<div class="fl-icon-box '.$icon_box_position.' ' .fl_sanitize_class($class).' cf" id ="'.$idf.'">';

    $result .= '<div class="fl-icon_box_icon '.$icon_position.'">';

    $result .= $vc_icon_box_output;

    $result .= '</div>';

    $result .= '<div class="fl-icon_box_content '.$text_position.'">';

    $result .= '<'.$title_style.' class="fl_icon_box_title" '.$title_style_css.'>';

    $result .= $title_content;

    $result .= '</'.$title_style.'>';

    $result .= '<p class="fl_icon_box_content" '.$content_style_css.'>'.$icon_text_content.'</p>';

    $result .= '</div>';

    $result .= '</div>';

    if($icon_bg_hover_color or $icon_hover_color ){

    $result .= '<style type="text/css">#'.$idf.':hover .fl-icon_box_icon .fl-icon-inner-box { background:'.$icon_bg_hover_color.'!important;}#'.$idf.':hover .fl-icon_box_icon .fl-icon-inner-box i {color:'.$icon_hover_color.'!important;}</style>';

    }


    return $result;

}



add_action('vc_before_init', 'vc_fl_icon_box_shortcode');

function vc_fl_icon_box_shortcode() {

    vc_map(array(
        'name'          => esc_html__('Icon Box', 'fl-themes-helper'),
        'base'          => 'vc_fl_icon_box',
        'icon'          => 'fl-icon icon-fl-box-icon',
        'controls'      => 'full',
        'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
        'weight'        => 500,
        'params'        => array(
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon position in box', 'fl-themes-helper'),
                'param_name'        => 'icon_box_position',
                'value'=> array(
                        esc_attr__('Top Default', 'fl-themes-helper')       => 'fl_icon_box_icon_position_top',
                        esc_attr__('Bottom', 'fl-themes-helper')            => 'fl_icon_box_icon_position_bottom',
                        esc_attr__('Right', 'fl-themes-helper')             => 'fl_icon_box_icon_position_right',
                        esc_attr__('Left', 'fl-themes-helper')              => 'fl_icon_box_icon_position_left',
                ),
                'std'               => 'fl_icon_box_icon_position_top'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Content text position', 'fl-themes-helper'),
                'param_name'        => 'text_position',
                'value' => array(
                        esc_attr__('Center Default', 'fl-themes-helper')    => 'text-center',
                        esc_attr__('Left', 'fl-themes-helper')              => 'text-left',
                        esc_attr__('Right', 'fl-themes-helper')             => 'text-right',
                ),
                'std'               => 'text-center',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Title style', 'fl-themes-helper'),
                'param_name'        => 'title_style',
                'value' => array(
                        esc_attr__("Default H4","fl-themes-helper")         => "h4",
                        esc_attr__("H1","fl-themes-helper")                 => "h1",
                        esc_attr__("H2","fl-themes-helper")                 => "h2",
                        esc_attr__("H3","fl-themes-helper")                 => "h3",
                        esc_attr__("H5","fl-themes-helper")                 => "h5",
                        esc_attr__("H6","fl-themes-helper")                 => "h6",
                        esc_attr__("p","fl-themes-helper")                  => "p",
                ),
                'std'               => 'h5'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Title Text', 'fl-themes-helper'),
                'param_name'        => 'title_content',
                'value'             => '',
                'std'               => 'Some Text'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Title color', 'fl-themes-helper'),
                'param_name'        => 'title_color',
                'value'             => '',
                'std'               => '#1f1f1f',
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Title margin bottom', 'fl-themes-helper'),
                'param_name'        => 'title_margin_bottom',
                'value'             => '',
                'std'               => '10px'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Title margin top', 'fl-themes-helper'),
                'param_name'        => 'title_margin_top',
                'value'             => '',
                'std'               => ''
            ),
            array(
                'type'              => 'textarea',
                'heading'           => esc_html__('Icon box content', 'fl-themes-helper'),
                'param_name'        => 'icon_text_content',
                'value'             => '',
                'std'               => 'Suspendisse imperdiet augue eu neque semper lobortis.'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Content font size', 'fl-themes-helper'),
                'param_name'        => 'font_size_content',
                'description'       => 'Enter content font size (number + px).Example: 15px.',
                'value'             => '',
                'std'               => '',
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Content line height', 'fl-themes-helper'),
                'param_name'        => 'line_height_content',
                'description'       => 'Enter content line height (number + px).Example: 15px.',
                'value'             => '',
                'std'               => '',
            ),

            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Text content color', 'fl-themes-helper'),
                'param_name'        => 'content_color',
                'value'             => '',
                'std'               => '#1f1f1f',
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
                        'emptyIcon'         => false,
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'fontawesome'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_openiconic',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'openiconic',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'openiconic'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_typicons',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'typicons',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'typicons'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_entypo',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'entypo',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'entypo'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_linecons',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'linecons',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'linecons'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_etline',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'etline',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'etline'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_iconmoon',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'iconmoon',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'iconmoon'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_linearicons',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'linearicons',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'linearicons'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_elusive',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'elusive',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'elusive'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_flicon',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'flicon',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'flicon'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_iconic',
                'settings' => array(
                        'emptyIcon'         => false,
                        'type'              => 'iconic',
                        'iconsPerPage'      => 300
                ),
                'dependency' => array(
                        'element'           => 'icon_type',
                        'value'             => 'iconic'
                ),
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon color', 'fl-themes-helper'),
                'edit_field_class'  => 'vc_col-sm-4',
                'param_name'        => 'icon_color',
                'value'             => '',
                'std'               => '#1f1f1f',
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon hover color', 'fl-themes-helper'),
                'edit_field_class'  => 'vc_col-sm-4',
                'param_name'        => 'icon_hover_color',
                'value'             => '',
                'std'               => '',
                'dependency' => array(
                        'element'           => 'icon_style',
                        'value'             => array( 'fl_icon_style_round','fl_icon_style_rounded','fl_icon_style_square' ),
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
                        esc_attr__('Round', 'fl-themes-helper')         => 'fl_icon_style_round',
                        esc_attr__('Rounded', 'fl-themes-helper')       => 'fl_icon_style_rounded',
                        esc_attr__('Square', 'fl-themes-helper')        => 'fl_icon_style_square',
                ),
                'std'               => 'default',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon border style', 'fl-themes-helper'),
                'param_name'        => 'icon_border',
                'dependency' => array(
                        'element'           => 'icon_style',
                        'value'             => array( 'fl_icon_style_round','fl_icon_style_rounded','fl_icon_style_square' ),
                ),
                'value' => array(
                        esc_attr__('None', 'fl-themes-helper')              => '',
                        esc_attr__('Border Solid', 'fl-themes-helper')      => 'fl_icon_style_border_solid',
                        esc_attr__('Border Dashed', 'fl-themes-helper')     => 'fl_icon_style_border_dashed',
                ),
                'std'               => '',
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Icon size', 'fl-themes-helper'),
                'param_name'        => 'icon_font_size',
                'dependency' => array(
                        'element'           => 'icon_style',
                        'value'             => array( 'default'),
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
                        'element'           => 'icon_style',
                        'value'             => array( 'fl_icon_style_round','fl_icon_style_rounded','fl_icon_style_square' ),
                ),
                'value' => array(
                        esc_attr__('Ultra small', 'fl-themes-helper')   => 'icon-ultra-small',
                        esc_attr__('Small', 'fl-themes-helper')         => 'icon-small',
                        esc_attr__('Normal', 'fl-themes-helper')        => 'icon-normal',
                        esc_attr__('Medium', 'fl-themes-helper')        => 'icon-medium',
                        esc_attr__('Large', 'fl-themes-helper')         => 'icon-large',
                ),
                'group'             => 'Icon',
                'std'               => 'icon-small',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon background color', 'fl-themes-helper'),
                'param_name'        => 'icon_bg_color',
                'value'             => '',
                'edit_field_class'  => 'vc_col-sm-4',
                'dependency' => array(
                        'element'           => 'icon_style',
                        'value'             => array( 'fl_icon_style_round','fl_icon_style_rounded','fl_icon_style_square' ),
                ),
                'std'               => '#1f1f1f',
                'group'             => 'Icon'
            ),

            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon background hover color', 'fl-themes-helper'),
                'param_name'        => 'icon_bg_hover_color',
                'edit_field_class'  => 'vc_col-sm-4',
                'value'             => '',
                'dependency' => array(
                        'element'           => 'icon_style',
                        'value'             => array( 'fl_icon_style_round','fl_icon_style_rounded','fl_icon_style_square' ),
                ),
                'std'               => '',
                'group'             => 'Icon'
            ),

            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Icon border color', 'fl-themes-helper'),
                'param_name'        => 'icon_border_color',
                'edit_field_class'  => 'vc_col-sm-4',
                'value'             => '',
                'dependency' => array(
                        'element'           => 'icon_border',
                        'value'             => array( 'fl_icon_style_border_solid','fl_icon_style_border_dashed' ),
                ),
                'std'               => '',
                'group'             => 'Icon'
            ),


            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Icon block position', 'fl-themes-helper'),
                'param_name'        => 'icon_position',
                'value' => array(
                        esc_attr__('Center Default', 'fl-themes-helper')        => 'text-center',
                        esc_attr__('Left', 'fl-themes-helper')                  => 'text-left',
                        esc_attr__('Right', 'fl-themes-helper')                 => 'text-right',
                ),
                'std'               => 'text-center',
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Icon margin bottom', 'fl-themes-helper'),
                'param_name'        => 'icon_margin_bottom',
                'value'             => '',
                'std'               => '',
                'description'       => 'Default margin is 0px.If you want to change the default value write (Your Number)+px. Example: 10px',
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Icon margin top', 'fl-themes-helper'),
                'param_name'        => 'icon_margin_top',
                'value'             => '',
                'std'               => '',
                'description'       => 'Default margin is 0px.If you want to change the default value write (Your Number)+px. Example: 10px',
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Icon margin left', 'fl-themes-helper'),
                'param_name'        => 'icon_margin_left',
                'value'             => '',
                'std'               => '',
                'description'       => 'Default margin is 0px.If you want to change the default value write (Your Number)+px. Example: 10px',
                'group'             => 'Icon'
            ),
            array(
                'type'              => 'textfield',
                'heading'           => esc_html__('Icon margin right', 'fl-themes-helper'),
                'param_name'        => 'icon_margin_right',
                'value'             => '',
                'std'               => '',
                'description'       => 'Default margin is 0px.If you want to change the default value write (Your Number)+px. Example: 10px',
                'group'             => 'Icon'
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