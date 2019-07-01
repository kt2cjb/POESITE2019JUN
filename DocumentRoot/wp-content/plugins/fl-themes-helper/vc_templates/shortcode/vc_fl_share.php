<?php

add_shortcode('vc_fl_share', 'vc_fl_share_function');

function vc_fl_share_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'sh_plat_fb'            => 'enable',
        'sh_plat_tw'            => 'enable',
        'sh_plat_gplus'         => 'enable',
        'sh_plat_vk'            => '',
        'sh_plat_pn'            => '',
        'sh_plat_rd'            => '',
        'sh_plat_lk'            => '',
        'icon_position'         => 'text-left',
        'cl_icon'               => '#1f1f1f',
        'bg_cl_icon'            => '#f1f1f1',
        'icon_style'            => 'fl_icon_default',
        'icon_border_style'     => '',
        'icon_cl_thematic'      => '',
        'icon_bg_thematic'      => '',
        'icon_animation'        => '',
        'icon_hover'            => '',
        'hv_cl_icon'            => '#ffffff',
        'hv_bg_icon'            => '#1f1f1f',
        'share_platforms_fb'    => 'enable',
        'class'                 => '',
        'vc_css'                => '',
    ), $atts));


    $hover_css =$hv_bg =$hv_cl = $hv_thematic =$result=$icon_color=$bg_color=$hv_cl_class=$twi = $fb = $gplus = $vk = $pin = $red = $lin =$thematic_hv='';


    if($cl_icon){
        $icon_color = 'color:'.$cl_icon.';';
    }

    if($icon_style !== 'fl_icon_default' ) {
        if ($icon_bg_thematic !== 'fl_icon_bg_thematic') {
            if ($bg_cl_icon) {
                $bg_color = 'background-color:' . $bg_cl_icon . ';';
            }
        }
    }

    if ($icon_style =='fl_icon_border_style'){
        if($bg_cl_icon) {
            $bg_color = 'border-color:'.$bg_cl_icon.';';
        }
    }

    $icon_style_css = ( $bg_color || $icon_color  ) ? 'style='. $bg_color . $icon_color  . '' : '';



    if($icon_hover == 'custom'){
        if($hv_cl_icon){
            $hv_cl = 'color:'.$hv_cl_icon.'!important;';
        }
        if($hv_bg_icon) {
            $hv_bg ='background:'.$hv_bg_icon.'!important;';
        }
        if($icon_style =='fl_icon_border_style'){
            if($hv_bg_icon) {
                $hv_bg ='border-color:'.$hv_bg_icon.'!important;';
            }
        }
    } elseif($icon_hover =='thematic') {
        $hv_cl_class = 'fl_icon_hv_thematic';
    }

    if($hv_cl || $hv_bg){
        $hover_css ='<style>.fl_share_link_vc a:hover i{'.$hv_cl.$hv_bg.'}</style>';
    }

    if($icon_cl_thematic == 'enable'){
        $thematic_hv = 'fl-hover-thematic';
    }


    if($sh_plat_tw){ $twi ='<a href="'.rest_get_share('twi').'" class="fl_share_icon_vc tw_icon" onclick="window.open(this.href, \'Share this post\', \'width=600,height=300\'); return false"><i class="fa fa-twitter" aria-hidden="true" '.$icon_style_css.'></i></a>';}
    if($sh_plat_fb){ $fb  ='<a href="'.rest_get_share('fb').'" class="fl_share_icon_vc fb_icon" onclick="window.open(this.href, \'Share this post\', \'width=600,height=300\'); return false"><i class="fa fa-facebook" aria-hidden="true" '.$icon_style_css.'></i></a>';}
    if($sh_plat_gplus){ $gplus  ='<a href="'.rest_get_share('goglp').'" class="fl_share_icon_vc gplus_icon" onclick="window.open(this.href, \'Share this post\', \'width=600,height=300\'); return false"><i class="fa fa-google" aria-hidden="true" '.$icon_style_css.'></i></a>';}
    if($sh_plat_vk){ $vk  ='<a href="'.rest_get_share('vk').'" class="fl_share_icon_vc vk_icon" onclick="window.open(this.href, \'Share this post\', \'width=600,height=300\'); return false"><i class="fa fa-vk" aria-hidden="true" '.$icon_style_css.'></i></a>';}
    if($sh_plat_pn){ $pin  ='<a href="'.rest_get_share('pin').'" class="fl_share_icon_vc pn_icon" onclick="window.open(this.href, \'Share this post\', \'width=600,height=300\'); return false"><i class="fa fa-pinterest-p" aria-hidden="true" '.$icon_style_css.'></i></a>';}
    if($sh_plat_rd){ $red  ='<a href="'.rest_get_share('red').'" class="fl_share_icon_vc red_icon" onclick="window.open(this.href, \'Share this post\', \'width=600,height=300\'); return false"><i class="fa fa-reddit-alien" aria-hidden="true" '.$icon_style_css.'></i></a>';}
    if($sh_plat_lk){ $lin  ='<a href="'.rest_get_share('lin').'" class="fl_share_icon_vc lin_icon" onclick="window.open(this.href, \'Share this post\', \'width=600,height=300\'); return false"><i class="fa fa-linkedin" aria-hidden="true" '.$icon_style_css.'></i></a>';}

    $share_link = ''.$fb.''.$twi.''.$gplus.''.$lin.''.$pin.''.$red.''.$vk.'';

    $class .= fl_get_css_tab_class($atts);

    $result .= '<div class="fl_share_link_vc '.$hv_thematic.' '.$hv_cl_class.' '.$icon_border_style.' '.$icon_animation.' '.$icon_style.' '. fl_sanitize_class($class) .' '.$icon_position.' '.$thematic_hv.'">';

    $result .= $share_link;

    $result .= '</div>';

    $result .= $hover_css;

    return $result;
}
add_action('vc_before_init', 'vc_fl_share_shortcode');

function vc_fl_share_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Share', 'fl-themes-helper'),
            'base'          => 'vc_fl_share',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon'          => 'fl-icon icon-fl-share',
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
                        esc_attr__('Enable', 'fl-themes-helper')            => 'enable',
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
                    'std'           => '#f1f1f1',
                    'edit_field_class' => 'vc_col-sm-6',

                ),
                array(
                    'type'          => 'checkbox',
                    'heading'       => esc_html__('Facebook', 'fl-themes-helper'),
                    'param_name'    => 'sh_plat_fb',
                    'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')             => 'enable',
                    ),
                    'std'           => 'enable',
                    'group'         => 'Share Platform',
                ),
                array(
                    'type'          => 'checkbox',
                    'heading'       => esc_html__('Twitter', 'fl-themes-helper'),
                    'param_name'    => 'sh_plat_tw',
                    'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')             => 'enable',
                    ),
                    'std'           => 'enable',
                    'group'         => 'Share Platform',
                ),
                array(
                    'type'          => 'checkbox',
                    'heading'       => esc_html__('Google', 'fl-themes-helper'),
                    'param_name'    => 'sh_plat_gplus',
                    'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')             => 'enable',
                    ),
                    'std'           => 'enable',
                    'group'         => 'Share Platform',
                ),
                array(
                    'type'          => 'checkbox',
                    'heading'       => esc_html__('VK', 'fl-themes-helper'),
                    'param_name'    => 'sh_plat_vk',
                    'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')             => 'enable',
                    ),
                    'std'           => '',
                    'group'         => 'Share Platform',
                ),
                array(
                    'type'          => 'checkbox',
                    'heading'       => esc_html__('Pinterest', 'fl-themes-helper'),
                    'param_name'    => 'sh_plat_pn',
                    'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')             => 'enable',
                    ),
                    'std'           => '',
                    'group'         => 'Share Platform',
                ),
                array(
                    'type'          => 'checkbox',
                    'heading'       => esc_html__('Reddit', 'fl-themes-helper'),
                    'param_name'    => 'sh_plat_rd',
                    'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')             => 'enable',
                    ),
                    'std'           => '',
                    'group'         => 'Share Platform',
                ),
                array(
                    'type'          => 'checkbox',
                    'heading'       => esc_html__('LinkedIn', 'fl-themes-helper'),
                    'param_name'    => 'sh_plat_lk',
                    'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')             => 'enable',
                    ),
                    'std'           => '',
                    'group'         => 'Share Platform',
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
                    'std'               => '#ffffff',
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
                    'std'               => '#1f1f1f',
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