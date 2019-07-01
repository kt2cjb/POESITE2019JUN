<?php

/*
 * Shortcode Testimonial Row
 * */

add_shortcode('vc_fl_testimonial_row', 'vc_fl_testimonial_row_function');

function vc_fl_testimonial_row_function($atts, $content = null) {

	
	extract(shortcode_atts(array(
        'img'               => '',
        'name'              => 'Name',
        'images_size'       => 'size_150x150_crop',
        'category'          => 'Web design',
        'name_color'        => '#1f1f1f',
        'category_color'    => '#1f1f1f',
        'text_color'        => '#1f1f1f',
        'icon_type'         => 'default',
        'flquote'           => '',
        'background'        => 'enable',
        'testimonial_style' => '1',
        'rating'            => 'five_star',
        'rating_star'       => 'disable',
        'rating_color'      => '#dd9933',
        'content_separator' => '',
        'sp_line_color'     => '',
        'sp_icon_color'     => '',
        'background_color'  => '#f1f1f1'

	), $atts));

	$result = '';


    switch ($icon_type) {
        case 'flquote':
            $icon = $atts['icon_flquote'];
            break;
    }

    vc_icon_element_fonts_enqueue($icon_type);


    if($rating_star !=='disable'){
        $star_rating= '<i class="fa fa-star"></i>';
        $star_rating_none = '<i class="fa fa-star-o"></i>';
        if($rating == 'five_star'){
            $star = '<div class="fl-testimonial-rating" style="color:'.$rating_color.'">'.$star_rating.$star_rating.$star_rating.$star_rating.$star_rating.'</div>';
        } elseif ($rating == 'four_star') {
            $star = '<div class="fl-testimonial-rating" style="color:'.$rating_color.'">'.$star_rating.$star_rating.$star_rating.$star_rating.$star_rating_none.'</div>';
        } elseif ($rating == 'three_star') {
            $star = '<div class="fl-testimonial-rating" style="color:'.$rating_color.'">'.$star_rating.$star_rating.$star_rating.$star_rating_none.$star_rating_none.'</div>';
        } elseif ($rating == 'two_star') {
            $star = '<div class="fl-testimonial-rating" style="color:'.$rating_color.'">'.$star_rating.$star_rating.$star_rating_none.$star_rating_none.$star_rating_none.'</div>';
        } elseif ($rating  == 'one_star') {
            $star = '<div class="fl-testimonial-rating" style="color:'.$rating_color.'">'.$star_rating.$star_rating_none.$star_rating_none.$star_rating_none.$star_rating_none.'</div>';
        }
    } else {
        $star='';
    }
    $vc_icon = '';
    if($content_separator !='disable'){
        if ($icon_type == 'flquote') {
            $vc_icon = '<div class="fl-testimonial-separator"><span class="separator-left" style="background:'.$sp_line_color.';"></span><i class="fl-testimonial-icon  ' . $icon . '" style="color:'.$sp_icon_color.'"></i><span class="separator-right" style="background:'.$sp_line_color.';"></span></div>';
        } elseif ($icon_type == 'default') {
            $vc_icon = '<div class="fl-testimonial-separator"><span class="separator-left" style="background:'.$sp_line_color.';"></span><i class="fl-testimonial-icon dashicons dashicons-format-quote" style="color:'.$sp_icon_color.'"></i><span class="separator-right" style="background:'.$sp_line_color.';"></span></div>';
        } else {
            $vc_icon = '';
        }
    }


    if($img){
    $attachment = fl_get_attachment($img, $images_size);
    $img = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="fl_single-img">';
    } else {
     $img = '';
    }
    $background_margin_off = '';
    $background_cl = '';
    if($background =='enable'){
        if ($testimonial_style == '1'){
        $background_cl = 'style="background:'.$background_color.'"';
       } elseif ($testimonial_style == '2'){
        $background_cl = 'style="background:'.$background_color.'"';
        $border_cl = 'style="border-color:'.$background_color.' transparent transparent;"';
       } elseif ($testimonial_style == '3'){
        $background_cl = 'style="background:'.$background_color.'"';
        $border_cl = 'style="border-color:transparent transparent '.$background_color.';"';
       } elseif ($testimonial_style == '4'){
        $background_cl = 'style="background:'.$background_color.'"';
        $border_cl = 'style="border-color:'.$background_color.' transparent transparent;"';
       }
    } else {
        $background_margin_off = 'fl_margin_off';
        $border_cl = 'style="border-color:transparent;"';
        $background_cl = '';
    }

    if ($testimonial_style == '2'){
        $result .= '<div class="fl-testimonial-item fl_slick_slide testimonial_style_two cf">';

        $result .=  '<div class="fl-testimonial-content '.$background_margin_off.'" '.$background_cl.'>';

        $result .= '<span class="content_bottom" '.$border_cl.'></span>';

        $result .=  $vc_icon;

        $result .=  '<div class="fl-testimonial-text" style="color:'.$text_color.'">'.fl_js_remove_wpautop($content, true).'</div>';

        $result .= '</div>';

        $result .=  '<div class="fl-testimonial-info cf">';

        $result .= '<div class="fl-testimonial-img">'.$img.'</div>';

        $result .=  '<div class="fl_info_and_rating cf">';

        $result .=  $star;

        $result .=  '<div class="fl-testimonial-name h5" style="color:'.$name_color.'">'.$name.'</div>';

        $result .=  '<div class="fl-testimonial-category" style="color:'.$category_color.'">'.$category.'</div>';

        $result .=  '</div>';

        $result .=  '</div>';

        $result .=  '</div>';

    } elseif ($testimonial_style == '3'){

        $result .= '<div class="fl-testimonial-item fl_slick_slide testimonial_style_three cf">';

        $result .=  '<div class="fl-testimonial-info cf">';

        $result .= '<div class="fl-testimonial-img">'.$img.'</div>';

        $result .=  '<div class="fl_info_and_rating cf">';

        $result .=  '<div class="fl-testimonial-name h5" style="color:'.$name_color.'">'.$name.'</div>';

        $result .=  '<div class="fl-testimonial-category" style="color:'.$category_color.'">'.$category.'</div>';

        $result .=  $star;

        $result .=  '</div>';

        $result .=  '</div>';

        $result .=  '<div class="fl-testimonial-content '.$background_margin_off.'" '.$background_cl.'>';

        $result .= '<span class="content_top" '.$border_cl.'></span>';

        $result .=  $vc_icon;

        $result .=  '<div class="fl-testimonial-text" style=" color:'.$text_color.'">'.fl_js_remove_wpautop($content, true).'</div>';

        $result .= '</div>';

        $result .= '</div>';

    } elseif ($testimonial_style == '4'){

        $result .= '<div class="fl-testimonial-item fl_slick_slide testimonial_style_four cf">';

        $result .=  '<div class="fl-testimonial-content '.$background_margin_off.'" '.$background_cl.'>';

        $result .= '<span class="content_bottom" '.$border_cl.'></span>';

        $result .=  $vc_icon;

        $result .=  '<div class="fl-testimonial-text" style=" color:'.$text_color.'">'.fl_js_remove_wpautop($content, true).'</div>';

        $result .= '</div>';

        $result .=  '<div class="fl-testimonial-info cf">';

        $result .= '<div class="fl-testimonial-img">'.$img.'</div>';

        $result .=  '<div class="fl_info_and_rating cf">';

        $result .=  '<div class="fl-testimonial-name h5" style="color:'.$name_color.'">'.$name.'</div>';

        $result .=  '<div class="fl-testimonial-category" style="color:'.$category_color.'">'.$category.'</div>';

        $result .=  $star;

        $result .=  '</div>';

        $result .=  '</div>';

        $result .= '</div>';

    } else {
        $result .= '<div class="fl-testimonial-item fl_slick_slide testimonial_style_one cf" '.$background_cl.'>';

        $result .=  '<div class="fl-testimonial-info cf">';

        $result .= '<div class="fl-testimonial-img">'.$img.'</div>';

        $result .=  '<div class="fl_info_and_rating cf">';

        $result .=  '<div class="fl-testimonial-name h5" style="color:'.$name_color.'">'.$name.'</div>';

        $result .=  '<div class="fl-testimonial-category" style="color:'.$category_color.'">'.$category.'</div>';

        $result .=  '</div>';

        $result .=  '</div>';

        $result .=  '<div class="fl-testimonial-content">';

        $result .=  $vc_icon;

        $result .= '<div class="fl-testimonial-text" style="color:'.$text_color.'">'.fl_js_remove_wpautop($content, true).'</div>';

        $result .= '</div>';

        $result .= '</div>';
    }


	return $result;
	
}

add_action('vc_before_init', 'vc_fl_testimonial_row_shortcode');
function vc_fl_testimonial_row_shortcode()
{
	vc_map(array(
		'name' => esc_html__('Testimonial Row', 'fl-themes-helper'),
		'base' => 'vc_fl_testimonial_row',
        'icon'          => 'fl-icon icon-fl-testimonial-row',
		'as_child' => array(
			'only' => 'vc_fl_testimonial_parent'
		),
		'params' => array(
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Testimonial Style', 'fl-themes-helper'),
                'param_name'        => 'testimonial_style',
                'std'               => 'disable',
                'value' => array(
                        esc_attr__('Default', 'fl-themes-helper')               => '1',
                        esc_attr__('Style two', 'fl-themes-helper')             => '2',
                        esc_attr__('Style three', 'fl-themes-helper')           => '3',
                        esc_attr__('Style four', 'fl-themes-helper')            => '4',
                ),
                'description' => ''
            ),
            array(
                'type'              => 'attach_image',
                'heading'           => esc_html__('User photo', 'fl-themes-helper'),
                'description'       => esc_html__('Select image.', 'fl-themes-helper'),
                'param_name'        => 'img',
                'value'             => '',
                'admin_label'       => false,
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Images Size', 'fl-themes-helper'),
                'param_name'        => 'images_size',
                'std'               => 'size_150x150_crop',
                'value'             => fl_get_image_sizes(),
                'description'       => ''
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Rating', 'fl-themes-helper'),
                'param_name'        => 'rating_star',
                'std'               => 'disable',
                'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')                => 'enable',
                        esc_attr__('Disable', 'fl-themes-helper')               => 'disable',
                ),
                'dependency' => array(
                        'element'                                   => 'testimonial_style',
                        'value'                                     => array( '2','3','4' ),
                ),
                'description'       => ''
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Testimonial Rating', 'fl-themes-helper'),
                'param_name'        => 'rating',
                'std'               => 'five_star',
                'dependency' => array(
                        'element'                                   => 'rating_star',
                        'value'                                     => array( 'enable' ),
                ),
                'value' => array(
                        esc_attr__('Default Five star', 'fl-themes-helper')     => 'five_star',
                        esc_attr__('Four star', 'fl-themes-helper')             => 'four_star',
                        esc_attr__('Three star', 'fl-themes-helper')            => 'three_star',
                        esc_attr__('Two star', 'fl-themes-helper')              => 'two_star',
                        esc_attr__('One star', 'fl-themes-helper')              => 'one_star',
                ),
                'description' => ''
            ),
            array(
                'type'              => 'textfield',
                'admin_label'       => true,
                'heading'           => esc_html__('Name', 'fl-themes-helper'),
                'description'       => esc_html__('Enter name of testimonial.', 'fl-themes-helper'),
                'param_name'        => 'name',
                'value'             => '',
                'std'               => 'Name'
            ),
            array(
                'type'              => 'textfield',
                'admin_label'       => true,
                'heading'           => esc_html__('Category', 'fl-themes-helper'),
                'description'       => esc_html__('Enter category testimonial.', 'fl-themes-helper'),
                'param_name'        => 'category',
                'value'             => '',
                'std'               => 'Web design'
            ),
            array(
                'type'              => 'textarea_html',
                "heading"           => esc_html__( "Content", "fl-themes-helper" ),
                'param_name'        => 'content',
                'value'             => '',
                'holder'            => 'div',
                'std'               => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                "description"       => esc_html__( "Enter your content.", "fl-themes-helper" )
            ),


            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Background', 'fl-themes-helper'),
                'param_name'        => 'background',
                'std'               => 'enable',
                'value' => array(
                        esc_attr__('Enable', 'fl-themes-helper')                => 'enable',
                        esc_attr__('Disable', 'fl-themes-helper')               => 'disable',
                ),
                'description'       => ''
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Background color', 'fl-themes-helper' ),
                'param_name'        => 'background_color',
                'dependency' => array(
                        'element'                                   => 'background',
                        'value'                                     => 'enable'
                ),
                'std'               => '#f1f1f1',
            ),


            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Name Color', 'fl-themes-helper' ),
                'param_name'        => 'name_color',
                'edit_field_class'  => 'vc_col-sm-3',
                'std'               => '#363636',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Text color', 'fl-themes-helper' ),
                'param_name'        => 'text_color',
                'edit_field_class'  => 'vc_col-sm-3',
                'std'               => '#363636',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Category color', 'fl-themes-helper' ),
                'param_name'        => 'category_color',
                'edit_field_class'  => 'vc_col-sm-3',
                'std'               => '#363636',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Rating Color', 'fl-themes-helper' ),
                'param_name'        => 'rating_color',
                'edit_field_class'  => 'vc_col-sm-3',
                'dependency' => array(
                        'element'                               => 'rating_star',
                        'value'                                 => 'enable'
                ),
                'std'               => '#dd9933',
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Separator', 'fl-themes-helper'),
                'value' => array(
                    esc_attr__('Enable', 'fl-themes-helper')            => '',
                    esc_attr__('Disable', 'fl-themes-helper')           => 'disable',
                ),
                'param_name'        => 'content_separator',
                'std'               => '',
                'group'             => 'Separator'
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Select your icon', 'fl-themes-helper'),
                'value' => array(
                        esc_attr__('Disable', 'fl-themes-helper')           => 'none',
                        esc_attr__('Default', 'fl-themes-helper')           => 'default',
                        esc_attr__('Custom', 'fl-themes-helper')            => 'flquote',
                ),
                'param_name'        => 'icon_type',
                'std'               => 'default',
                'group'             => 'Separator',
                'dependency' => array(
                    'element'                               => 'content_separator',
                    'value_not_equal_to'                    => 'disable',
                )

            ),
            array(
                'type'              => 'iconpicker',
                'heading'           => esc_html__('Icon', 'fl-themes-helper'),
                'param_name'        => 'icon_flquote',
                'settings' => array(
                        'emptyIcon'                             => false,
                        'type'                                  => 'flquote',
                        'iconsPerPage'                          => 300
                ),
                'dependency' => array(
                        'element'                               => 'icon_type',
                        'value'                                 => 'flquote'
                ),
                'group'             => 'Separator'

            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Separator Line color', 'fl-themes-helper' ),
                'param_name'        => 'sp_line_color',
                'edit_field_class'  => 'vc_col-sm-3',
                'std'               => '',
                'group'             => 'Separator',
                'dependency' => array(
                    'element'                               => 'content_separator',
                    'value_not_equal_to'                    => 'disable',
                )
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__( 'Separator Icon color', 'fl-themes-helper' ),
                'param_name'        => 'sp_icon_color',
                'edit_field_class'  => 'vc_col-sm-3',
                'std'               => '',
                'group'             => 'Separator',
                'dependency' => array(
                    'element'                               => 'content_separator',
                    'value_not_equal_to'                    => 'disable',
                )
            ),
		)
	));
}