<?php
/*
 * Shortcode Pie
 */

add_shortcode('vc_fl_pie', 'vc_fl_render_fl_pie');

	  function vc_fl_render_fl_pie( $atts, $content = null  )
	   {
          extract( shortcode_atts( array(
	   
		     'linewidth'                => '4',
		     'barcolor'                 => '#ffffff',
		     'scalecolor'               => '',
		     'linecap'                  => 'butt',
		     'size'                     => '125',
		     'rotate'                   => '100',
		     'animate'                  => 'easeOutBounce',
             'duration'                 => '1200',
		     'enablecolor'              => '',
		     'track_color'              => '',
	         'prefix'                   => '',
		     'suffix'                   => '%',
		     'rotatecolor'              => '#ffffff',
		     'font_size'                => '23',
			 'trackwidth'               => '2',
			 'source'                   => 'gradiant_link',
			 'barcolor '                => '#ffffff',
			 'gradiantcolorstart'       => 'rgba(134,160,232,0.5)',
			 'gradiantcolorend'         => 'rgba(63,0,140,0.99)',
             'class'                    => '',
             'vc_css'                   => '',
			 
            ), $atts ) );
	   
       wp_enqueue_script( 'radial-easypiechart', plugins_url('../../assets/js/fl-pie/jquery.easypiechart.min.js', __FILE__), array('jquery') );
       wp_enqueue_script( 'radial-easing', plugins_url('../../assets/js/fl-pie/jquery.easing.min.js', __FILE__), array('jquery') );
       wp_enqueue_script( 'radial-main', plugins_url('../../assets/js/fl-pie/fl.pie.main.js', __FILE__), array('jquery') );

       $class .= fl_get_css_tab_class($atts);

       $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
       $id = 'chart-'.rand(1000000 ,90000000);

       $html='';
       $html .='<div class="fl-pie-wrapper '. fl_sanitize_class($class).'" >';
	   $html .='<span id="'.$id.'" class="chart easy_circle_progressbar  " data-percent = "'.$rotate.'" data-barColor= "'.$barcolor.'" data-scaleColor =  "'.       $scalecolor.'"  data-lineWidth = "'.$linewidth.'" data-size = "'.$size.'" 
	   data-trackColor =  "'.$track_color.'" data-lineCap =  "'.$linecap.'"  data-easing = "'.$animate.'"
	   data-duration = "'.$duration.'"  data-prefix = "'.$prefix.'" data-suffix = "'.$suffix.'"  data-rotatecolor = "'.$rotatecolor.'" data-font_size = "'.       $font_size.'" data-trackwidth = "'.$trackwidth.'" data-gradiantcolorstart = "'.$gradiantcolorstart.'" data-gradiantcolorend = "'.$gradiantcolorend.'"
	    data-source = "'.$source.'">
	   <span  class="percent"></span>
	   </span>'.'</div>';
	   $html .='<style>
                #'.$id.'.chart
			{
	            width  : '.$size.'px;
	            height : '.$size.'px;
	        }
                #'.$id.' .percent
			{
	            line-height : '.$size.'px;
	            color       : '.$rotatecolor.';
	            font-size   : '.$font_size.'px;
	        }
         </style>';

       return $html;
}
add_action('vc_before_init', 'vc_fl_pie_shortcode');

function vc_fl_pie_shortcode()
{
  {
    if (function_exists('vc_map')) {
      vc_map(array(
        "name"          => esc_html__("Pie Chart", 'fl-themes-helper'),
        "base"          => "vc_fl_pie",
        "class"         => "",
        "controls"      => "full",
        'weight'        => 300,
        'icon'          => 'fl-icon icon-fl-pie',
        "category"      => esc_html__('Fl Theme', 'fl-themes-helper'),
        "params"        => array(
            array(
                "type"              => "textfield",
                'heading'           => esc_html__('Rotate', 'fl-themes-helper'),
                'param_name'        => 'rotate',
                'std'               => '100',
                "value"             => esc_html__("", 'fl-themes-helper'),
                'description'       => esc_html__('Select degree.', 'fl-themes-helper'),
            ),
            array(
                "type"              => "textfield",
                "heading"           => esc_html__("Size", 'fl-themes-helper'),
                "param_name"        => "size",
                "value"             => esc_html__("", 'fl-themes-helper'),
                'std'               => '125',
                "description"       => esc_html__("Enter the size of pie chart.", 'fl-themes-helper')
            ),
            array(
                "type"              => "textfield",
                "heading"           => esc_html__("Line width", 'fl-themes-helper'),
                "param_name"        => "linewidth",
                'std'               => '4',
                "description"       => esc_html__("Enter the line width in between 0 to 100.", 'fl-themes-helper')
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Line type', 'fl-themes-helper'),
                'param_name'        => 'linecap',
                'value' => array(
                        esc_html__('square', 'fl-themes-helper')                => 'square',
                        esc_html__('round', 'fl-themes-helper')                 => 'round',
                        esc_html__('butt', 'fl-themes-helper')                  => 'butt',
                ),
                'std'               => 'butt',
                'description'       => esc_html__('Select linecap for the track.', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Color type', 'fl-themes-helper'),
                'param_name'        => 'source',
                'value' => array(
                        esc_html__('Simple Color', 'fl-themes-helper')          => 'color_library',
                        esc_html__('Gradient Color', 'fl-themes-helper')        => 'gradiant_link',
                ),
                'std'               => 'simple_link',
                'description'       => esc_html__('Select color type for chart.', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Line Color', 'fl-themes-helper'),
                'param_name'        => 'barcolor',
                'value'             => '',
                'std'               => '',
                'description'       => esc_html__('Select simple color to apply on chart.', 'fl-themes-helper'),
                'dependency' => array(
                        'element'                                   => 'source',
                        'value'                                     => 'color_library',
                ),
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Gradient color First', 'fl-themes-helper'),
                'param_name'        => 'gradiantcolorstart',
                'dependency' => array(
                        'element'                                   => 'source',
                        'value'                                     => 'gradiant_link',
                ),
                'std'               => 'rgba(134,160,232,0.5)',
            ),
            array(
                'type'              => 'colorpicker',
                'heading'           => esc_html__('Gradient color second', 'fl-themes-helper'),
                'param_name'        => 'gradiantcolorend',
                'dependency' => array(
                        'element'                                   => 'source',
                        'value'                                     => 'gradiant_link',
                ),
                'std'               => 'rgba(63,0,140,0.99)',
                'description'       => esc_html__('Select Gradiant color to apply on chart.', 'fl-themes-helper'),

            ),
            array(
                "type"              => "checkbox",
                "admin_label"       => true,
                "weight"            => 10,
                "heading"           => esc_html__("", "js_composer"),
                "description"       => esc_html__("Enable the track color", "js_composer"),
                "value"             => array('<b>Track color</b>' => 'value'),
                "param_name"        => "enablecolor", "tracwidth",
                'std'               => '',

            ),
            array(
                "type"              => "textfield",
                "heading"           => esc_html__("Track width", 'fl-themes-helper'),
                "param_name"        => "trackwidth",
                "value"             => '',
                "description"       => esc_html__("Enter the track width in between 0 to 100.", 'fl-themes-helper'),
                'dependency' => array(
                        'element'                                   => 'enablecolor',
                        'value'                                     => array('value'),
                ),
                'std'               => '2',
            ),
            array(
                "type"              => "colorpicker",
                "heading"           => esc_html__("Track color", 'fl-themes-helper'),
                "param_name"        => "track_color",
                "value"             => '',
                "description"       => esc_html__("Select Track color", 'fl-themes-helper'),
                'dependency' => array(
                        'element'                                   => 'enablecolor',
                        'value'                                     => array('value'),
                ),
                'std'               => '',
            ),
            array(
                "type"              => "checkbox",
                "admin_label"       => true,
                "weight"            => 10,
                "heading"           => esc_html__("", "js_composer"),
                "description"       => esc_html__("Enable the scale color", "js_composer"),
                "value"             => array('<b>Scale color</b>' => 'value'),
                "param_name"        => "enablescalecolor",
                'std'               => "",
            ),
            array(
                "type"              => "colorpicker",
                "heading"           => esc_html__("Scale color", 'fl-themes-helper'),
                "param_name"        => "scalecolor",
                "value"             => '',
                "description"       => esc_html__("Choose scale color", 'fl-themes-helper'),
                'dependency' => array(
                        'element'                                   => 'enablescalecolor',
                        'value'                                     => array('value'),
                ),
                'std'               => '',
            ),
            array(
                "type"              => "textfield",
                "heading"           => esc_html__("Prefix", 'fl-themes-helper'),
                "param_name"        => "prefix",
                "value"             => esc_html__("", 'fl-themes-helper'),
                "description"       => esc_html__("Enter the prefix for rotate. Use: %, #, ^,& etc.", 'fl-themes-helper')
            ),
            array(
                "type"              => "textfield",
                "heading"           => esc_html__("Suffix", 'fl-themes-helper'),
                "param_name"        => "suffix",
                "value"             => esc_html__("", 'fl-themes-helper'),
                'std'               => '',
                "description"       => esc_html__("Enter the suffix for rotate. Use: %, #, ^,& etc.", 'fl-themes-helper')
            ),
            array(
                "type"              => "colorpicker",
                "heading"           => esc_html__("Text color", 'fl-themes-helper'),
                "param_name"        => "rotatecolor",
                "value"             => '',
                'std'               => '#ffffff',
                "description"       => esc_html__("Choose text color", 'fl-themes-helper')
            ),
            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__('Text size', 'fl-themes-helper'),
                'param_name'        => 'font_size',
                'value' => array(
                        '10' => '10',
                        '12' => '12',
                        '15' => '15',
                        '19' => '19',
                        '23' => '23',
                        '27' => '27',
                        '31' => '31',
                        '36' => '36',
                ),
                'std'               => '23',
                'description'       => esc_html__('Select text size.', 'fl-themes-helper'),
            ),
            array(
                "type"              => "textfield",
                'heading'           => esc_html__('Duration', 'fl-themes-helper'),
                'param_name'        => 'duration',
                'std'               => '1200',
                "value"             => esc_html__("", 'fl-themes-helper'),
                'description'       => esc_html__('Select timestamp.', 'fl-themes-helper'),
            ),
            array(
                'type'              => 'dropdown',
                "heading"           => esc_html__("Animate", 'fl-themes-helper'),
                "param_name"        => "animate",
                'value' => array(
                        'easeInQuad'                        => 'easeInQuad',
                        'easeOutQuad'                       => 'easeOutQuad',
                        'easeInOutQuad'                     => 'easeInOutQuad',
                        'easeInCubic'                       => 'easeInCubic',
                        'easeOutCubic'                      => 'easeOutCubic',
                        'easeInOutCubic'                    => 'easeInOutCubic',
                        'easeInQuart'                       => 'easeInQuart',
                        'easeOutQuart'                      => 'easeOutQuart',
                        'easeInOutQuart'                    => 'easeInOutQuart',
                        'easeInQuint'                       => 'easeInQuint',
                        'easeOutQuint'                      => 'easeOutQuint',
                        'easeInOutQuint'                    => 'easeInOutQuint',
                        'easeInSine'                        => 'easeInSine',
                        'easeOutSine'                       => 'easeOutSine',
                        'easeInOutSine'                     => 'easeInOutSine',
                        'easeOutExpo'                       => 'easeOutExpo',
                        'easeInOutExpo'                     => 'easeInOutExpo',
                        'easeInCirc'                        => 'easeInCirc',
                        'easeOutCirc'                       => 'easeOutCirc',
                        'easeInOutCirc'                     => 'easeInOutCirc',
                        'easeInElastic'                     => 'easeInElastic',
                        'easeOutElastic'                    => 'easeOutElastic',
                        'easeInOutElastst'                  => 'easeInOutElastic',
                        'easeInBack'                        => 'easeInBack',
                        'easeOutBack'                       => 'easeOutBack',
                        'easeInOutBack'                     => 'easeInOutBack',
                        'easeInBounce'                      => 'easeInBounce',
                        'easeOutBounce'                     => 'easeOutBounce',
                        'easeInOutBounct'                   => 'easeInOutBounce',
                ),
                'std'               => 'easeOutBounce',
                "description"       => esc_html__("Select animate for pie chart.", 'fl-themes-helper')
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
        )
      )
    );
    }
  }
}