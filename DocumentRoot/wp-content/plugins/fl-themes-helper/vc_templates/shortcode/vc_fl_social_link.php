<?php

add_shortcode('vc_fl_social_link', 'vc_fl_social_link_function');

function vc_fl_social_link_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'icon_position'         => 'text-left',
        'cl_icon'               => '#1f1f1f',
        'bg_cl_icon'            => '',
        'icon_style'            => 'fl_icon_default',
        'icon_border_style'     => '',
        'icon_cl_thematic'      => '',
        'icon_bg_thematic'      => '',
        'icon_animation'        => '',
        'icon_hover'            => '',
        'hv_cl_icon'            => '#ffffff',
        'hv_bg_icon'            => '#1f1f1f',
        'fb_link'               => '',
        'tw_link'               => '',
        'inst_link'             => '',
        'in_link'               => '',
        'gplus_link'            => '',
        'yt_link'               => '',
        'vm_link'               => '',
        'pn_link'               => '',
        'bh_link'               => '',
        'mail_link'             => '',
        'class'                 => '',
        'vc_css'                => '',
    ), $atts));


    $result = '';
    $icon_color ='';
    $bg_color ='';
    if($cl_icon){
        $icon_color = 'color:'.$cl_icon.';';
    }

    if($icon_style !== 'fl_icon_default' ) {
        if ($icon_bg_thematic != 'fl_icon_bg_thematic') {
            if ($bg_cl_icon) {
                $bg_color = 'style="background-color:' . $bg_cl_icon . ';"';
            }
        }
    }

    if ($icon_style =='fl_icon_border_style'){
        if($bg_cl_icon) {
            $bg_color = 'style="border-color:'.$bg_cl_icon.';"';
        }
    }

    $hover_css = '';
    $hv_bg ='';
    $hv_cl ='';
    $hv_thematic ='';
    if($icon_hover =='custom'){
        if($hv_cl_icon){
            $hv_cl = 'color:'.$hv_cl_icon.'!important;';
        }
        if($hv_bg_icon) {
            $hv_bg ='background-color:'.$hv_bg_icon.'!important;';
        }
        if($icon_style =='fl_icon_border_style'){
            if($hv_bg_icon) {
                $hv_bg ='background-color:'.$hv_bg_icon.';border-color:'.$hv_bg_icon.'!important;';
            }
        }
        if($hv_cl_icon or $hv_bg_icon){
            $hover_css ='<style>.fl_social_link a i:hover{'.$hv_bg.$hv_cl.'}</style>';
        } else{
            $hover_css ='';
        }
    } elseif ($icon_hover =='thematic'){
        $hv_thematic = 'fl_icon_thematic_hover';
    }


    $fb_icon = $tw_icon = $inst_icon = $in_icon = $gplus_icon = $yt_icon = $vm_icon = $pn_icon = $bh_icon = $mail_icon ='';

    if($fb_link){$fb_icon = '<a class="fb_icon" href="'.$fb_link.'"><i class="fa fa-facebook" '.$bg_color.'></i></a>';}
    if($tw_link){$tw_icon = '<a class="tw_icon" href="'.$tw_link.'"><i class="fa fa-twitter" '.$bg_color.'></i></a>';}
    if($inst_link){$inst_icon = '<a class="inst_icon" href="'.$inst_link.'"><i class="fa fa-instagram" '.$bg_color.'></i></a>';}
    if($in_link){$in_icon = '<a class="in_icon" href="'.$in_link.'"><i class="fa fa-linkedin " '.$bg_color.'></i></a>';}
    if($gplus_link){$gplus_icon = '<a class="gplus_icon" href="'.$gplus_link.'"><i class="fa fa-google" '.$bg_color.'></i></a>';}
    if($yt_link){$yt_icon = '<a class="yt_icon" href="'.$yt_link.'"><i class="fa fa-youtube" '.$bg_color.'></i></a>';}
    if($vm_link){ $vm_icon = '<a class="vm_icon" href="'.$vm_link.'"><i class="fa fa-vimeo" '.$bg_color.'></i></a>';}
    if($pn_link){ $pn_icon = '<a class="pn_icon" href="'.$pn_link.'"><i class="fa fa-pinterest-p" '.$bg_color.'></i></a>';}
    if($bh_link){$bh_icon = '<a class="bh_icon" href="'.$bh_link.'"><i class="fa fa-behance" '.$bg_color.'></i></a>';}
    if($mail_link){$mail_icon = '<a class="mail_icon" href="mailto:'.$mail_link.'"><i class="fa fa-envelope" '.$bg_color.'></i></a>';}

    $s_links = ''.$fb_icon.''.$tw_icon.''.$inst_icon.''.$in_icon.''.$gplus_icon.''.$yt_icon.''.$vm_icon.''.$pn_icon.''.$bh_icon.''.$mail_icon.'';

    $class .= fl_get_css_tab_class($atts);


    $result .= '<div class="fl_social_link '.$hv_thematic.' '.$icon_border_style.' '.$icon_animation.' '.$icon_style.' '.$icon_bg_thematic.' '. fl_sanitize_class($class) .' '.$icon_position.'" style="'.$icon_color.'">';

    $result .= $s_links;

    $result.= '</div>';

    $result .= $hover_css;

    return $result;
}
add_action('vc_before_init', 'vc_fl_social_link_shortcode');

function vc_fl_social_link_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Social Link', 'fl-themes-helper'),
            'base'          => 'vc_fl_social_link',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'          => 'fl-icon icon-fl-social_link',
            'controls'      => 'full',
            'weight'        => 200,
            'params' => array(
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Icon style', 'fl-themes-helper'),
                    'param_name'    => 'icon_style',
                    'value' => array(
                        esc_attr__('Default', 'fl-themes-helper')           => 'fl_icon_default',
                        esc_attr__('Round', 'fl-themes-helper')             => 'fl_icon_style_round',
                        esc_attr__('Rounded', 'fl-themes-helper')           => 'fl_icon_style_rounded',
                        esc_attr__('Square', 'fl-themes-helper')            => 'fl_icon_style_square',
                        esc_attr__('Border', 'fl-themes-helper')            => 'fl_icon_border_style',
                    ),
                    'std'           => 'fl_icon_default',
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Border style', 'test'),
                    'param_name'    => 'icon_border_style',
                    'value' => array(
                        esc_attr__('Square', 'fl-themes-helper')            => 'fl_border_style_square',
                        esc_attr__('Round', 'fl-themes-helper')             => 'fl_border_style_round',
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_style',
                        'value'                                 => array('fl_icon_border_style'),
                    ),
                    'std'           => '',
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Social icon position', 'test'),
                    'param_name'    => 'icon_position',
                    'value' => array(
                        esc_attr__('Left', 'fl-themes-helper')              => 'text-left',
                        esc_attr__('Center', 'fl-themes-helper')            => 'text-center',
                        esc_attr__('Right', 'fl-themes-helper')             => 'text-right',
                    ),
                    'std'           => 'text-left',
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Background or Border icon', 'test'),
                    'param_name'    => 'icon_bg_thematic',
                    'description'   => '<strong style="color:#B5122C">! Attention</strong> thematic color doesn\'t work with a border style',
                    'value' => array(
                        esc_attr__('Custom', 'fl-themes-helper')            => '',
                        esc_attr__('Thematic', 'fl-themes-helper')          => 'fl_icon_bg_thematic',
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_style',
                        'value'                                 => array( 'fl_icon_style_round' , 'fl_icon_style_rounded' ,'fl_icon_style_square' ,'fl_icon_border_style'),
                    ),
                    'std'           => '',
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Thematic icon hover color', 'test'),
                    'param_name'    => 'icon_cl_thematic',
                    'value' => array(
                        esc_attr__('Disable', 'fl-themes-helper')           => '',
                        esc_attr__('Enable', 'fl-themes-helper')            => 'icon_cl_thematic',
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_style',
                        'value'                                 => array( 'fl_icon_default'),
                    ),
                    'std'           => '',
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__('Icon color', 'fl-themes-helper'),
                    'param_name'    => 'cl_icon',
                    'value'         => '',
                    'std'           => '#1f1f1f',
                    'edit_field_class' => 'vc_col-sm-3',
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__('Icon background or border color', 'fl-themes-helper'),
                    'param_name'    => 'bg_cl_icon',
                    'value'         => '',
                    'dependency' => array(
                        'element'                           => 'icon_bg_thematic',
                        'value'                             => array( ''),
                    ),
                    'std'           => '',
                    'edit_field_class' => 'vc_col-sm-6',

                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Custom Classes', 'fl-themes-helper'),
                    'param_name'        => 'class',
                    'value'             => '',
                    'description'       => '',
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to Facebook page",'fl-themes-helper'),
                    "param_name"        => "fb_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to Twitter page",'fl-themes-helper'),
                    "param_name"        => "tw_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to Instagram page",'fl-themes-helper'),
                    "param_name"        => "inst_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to LinkedIn page",'fl-themes-helper'),
                    "param_name"        => "in_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to Google+ page",'fl-themes-helper'),
                    "param_name"        => "gplus_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to YouTube page",'fl-themes-helper'),
                    "param_name"        => "yt_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to Vimeo page",'fl-themes-helper'),
                    "param_name"        => "vm_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to Pinterest page",'fl-themes-helper'),
                    "param_name"        => "pn_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("URL to Behance page",'fl-themes-helper'),
                    "param_name"        => "bh_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    "type"              => "textfield",
                    "class"             => "",
                    "heading"           => esc_html__("e-mail",'fl-themes-helper'),
                    "param_name"        => "mail_link",
                    "value"             => esc_html__("",'fl-themes-helper'),
                    'dependency' => array(
                        'element'                           => 'team_style',
                        'value'                             => array( 'style_team_two','style_team_three' ),
                    ),
                    'group'             => 'Social Icons Link'
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Social icon hover animation', 'test'),
                    'param_name'        => 'icon_animation',
                    'value' => array(
                        esc_attr__('None', 'fl-themes-helper')          => '',
                        esc_attr__('TransformTop', 'fl-themes-helper')  => 'fl_icon_transform_top',
                        esc_attr__('ScaleIn', 'fl-themes-helper')       => 'fl_icon_transform_scale',
                        esc_attr__('Opacity', 'fl-themes-helper')       => 'fl_icon_hover_opacity',
                    ),
                    'std'               => '',
                    'group'             => 'Social Icons Hover Animation'
                ),
                array(
                    'type'              => 'dropdown',
                    'heading'           => esc_html__('Icon Background hover', 'test'),
                    'param_name'        => 'icon_hover',
                    'value' => array(
                        esc_attr__('None', 'fl-themes-helper')            => '',
                        esc_attr__('Custom', 'fl-themes-helper')          => 'custom',
                        esc_attr__('Thematic', 'fl-themes-helper')        => 'thematic',
                    ),
                    'dependency' => array(
                        'element'                               => 'icon_style',
                        'value'                                 => array( 'fl_icon_style_round' , 'fl_icon_style_rounded' ,'fl_icon_style_square' ,'fl_icon_border_style'),
                    ),
                    'std'               => '',
                    'group'             => 'Social Icons Hover Animation'
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__('Icon hover color', 'fl-themes-helper'),
                    'param_name'    => 'hv_cl_icon',
                    'value'         => '',
                    'dependency' => array(
                        'element'                           => 'icon_hover',
                        'value'                             => 'custom',
                    ),
                    'group'             => 'Social Icons Hover Animation',
                    'edit_field_class'  => 'vc_col-sm-3',
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__('Icon background hover color', 'fl-themes-helper'),
                    'param_name'    => 'hv_bg_icon',
                    'value'         => '',
                    'dependency' => array(
                        'element'                           => 'icon_hover',
                        'value'                             => 'custom',
                    ),
                    'group'             => 'Social Icons Hover Animation',
                    'edit_field_class'  => 'vc_col-sm-6',
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