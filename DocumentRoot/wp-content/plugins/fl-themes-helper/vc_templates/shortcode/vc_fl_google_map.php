<?php



add_shortcode('vc_fl_google_map', 'vc_fl_google_map_function');


function vc_fl_google_map_function($atts, $content = null) {

    extract(shortcode_atts(array(
        'map_img'           => '',
        'address'           => 'New York',
        'zoom'              => 14,
        'apikey'            => 'AIzaSyAno0gm_AuDYUQMG_a8I_EfyxSpdKjZmzc',
        'size'              => '400px',
        'map_scrollwheel'   => 'false',
        'map_style_custom'  => 'custom',
        'map_style'         => '1',
        'class'             => ''
    ), $atts));

    $class .= fl_get_css_tab_class($atts);
    $customstyle_map = '';
    switch ($map_style) {
        case '1' :
            $customstyle_map = '[ { "featureType": "landscape", "stylers": [ { "hue": "#FFBB00" }, { "saturation": 43.400000000000006 }, { "lightness": 37.599999999999994 }, { "gamma": 1 } ] }, { "featureType": "road.highway", "stylers": [ { "hue": "#FFC200" }, { "saturation": -61.8 }, { "lightness": 45.599999999999994 }, { "gamma": 1 } ] }, { "featureType": "road.arterial", "stylers": [ { "hue": "#FF0300" }, { "saturation": -100 }, { "lightness": 51.19999999999999 }, { "gamma": 1 } ] }, { "featureType": "road.local", "stylers": [ { "hue": "#FF0300" }, { "saturation": -100 }, { "lightness": 52 }, { "gamma": 1 } ] }, { "featureType": "water", "stylers": [ { "hue": "#0078FF" }, { "saturation": -13.200000000000003 }, { "lightness": 2.4000000000000057 }, { "gamma": 1 } ] }, { "featureType": "poi", "stylers": [ { "hue": "#00FF6A" }, { "saturation": -1.0989010989011234 }, { "lightness": 11.200000000000017 }, { "gamma": 1 } ] } ]';
            break;
        case '2' :
            $customstyle_map = '[ { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#e9e9e9" }, { "lightness": 17 } ] }, { "featureType": "landscape", "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" }, { "lightness": 20 } ] }, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ { "color": "#ffffff" }, { "lightness": 17 } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#ffffff" }, { "lightness": 29 }, { "weight": 0.2 } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#ffffff" }, { "lightness": 18 } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#ffffff" }, { "lightness": 16 } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" }, { "lightness": 21 } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#dedede" }, { "lightness": 21 } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "visibility": "on" }, { "color": "#ffffff" }, { "lightness": 16 } ] }, { "elementType": "labels.text.fill", "stylers": [ { "saturation": 36 }, { "color": "#333333" }, { "lightness": 40 } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit", "elementType": "geometry", "stylers": [ { "color": "#f2f2f2" }, { "lightness": 19 } ] }, { "featureType": "administrative", "elementType": "geometry.fill", "stylers": [ { "color": "#fefefe" }, { "lightness": 20 } ] }, { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [ { "color": "#fefefe" }, { "lightness": 17 }, { "weight": 1.2 } ] } ]';
            break;
        case '3' :
            $customstyle_map = '[ { "featureType": "administrative", "elementType": "labels.text.fill", "stylers": [ { "color": "#444444" } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "color": "#f2f2f2" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "poi", "elementType": "geometry.fill", "stylers": [ { "saturation": "-100" }, { "lightness": "57" } ] }, { "featureType": "poi", "elementType": "geometry.stroke", "stylers": [ { "lightness": "1" } ] }, { "featureType": "poi", "elementType": "labels", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "saturation": -100 }, { "lightness": 45 } ] }, { "featureType": "road.highway", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit.station.bus", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "transit.station.bus", "elementType": "labels.text.fill", "stylers": [ { "saturation": "0" }, { "lightness": "0" }, { "gamma": "1.00" }, { "weight": "1" } ] }, { "featureType": "transit.station.bus", "elementType": "labels.icon", "stylers": [ { "saturation": "-100" }, { "weight": "1" }, { "lightness": "0" } ] }, { "featureType": "transit.station.rail", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "transit.station.rail", "elementType": "labels.text.fill", "stylers": [ { "gamma": "1" }, { "lightness": "40" } ] }, { "featureType": "transit.station.rail", "elementType": "labels.icon", "stylers": [ { "saturation": "-100" }, { "lightness": "30" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "color": "#d2d2d2" }, { "visibility": "on" } ] } ]';
            break;
        case '4' :
            $customstyle_map = '[ { "featureType": "all", "elementType": "all", "stylers": [ { "hue": "#e7ecf0" } ] }, { "featureType": "administrative", "elementType": "labels.text.fill", "stylers": [ { "color": "#636c81" } ] }, { "featureType": "administrative.neighborhood", "elementType": "labels.text.fill", "stylers": [ { "color": "#636c81" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#ff0000" } ] }, { "featureType": "landscape", "elementType": "geometry.fill", "stylers": [ { "color": "#f1f4f6" } ] }, { "featureType": "landscape", "elementType": "labels.text.fill", "stylers": [ { "color": "#496271" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "saturation": -70 } ] }, { "featureType": "road", "elementType": "geometry.fill", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road", "elementType": "geometry.stroke", "stylers": [ { "color": "#c6d3dc" } ] }, { "featureType": "road", "elementType": "labels.text.fill", "stylers": [ { "color": "#898e9b" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "visibility": "simplified" }, { "saturation": -60 } ] }, { "featureType": "water", "elementType": "geometry.fill", "stylers": [ { "color": "#d3eaf8" } ] } ]';
            break;
        case '5' :
            $customstyle_map = '[ { "featureType": "administrative", "elementType": "labels.text.fill", "stylers": [ { "color": "#444444" } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "color": "#f2f2f2" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.business", "elementType": "geometry.fill", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "saturation": -100 }, { "lightness": 45 } ] }, { "featureType": "road.highway", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "transit", "elementType": "labels", "stylers": [ { "visibility": "off" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "color": "#b2d0e3" }, { "visibility": "on" } ] } ]';
            break;
        case '6' :
            $customstyle_map = '[ { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#747474" }, { "lightness": "23" } ] }, { "featureType": "poi.attraction", "elementType": "geometry.fill", "stylers": [ { "color": "#f38eb0" } ] }, { "featureType": "poi.government", "elementType": "geometry.fill", "stylers": [ { "color": "#ced7db" } ] }, { "featureType": "poi.medical", "elementType": "geometry.fill", "stylers": [ { "color": "#ffa5a8" } ] }, { "featureType": "poi.park", "elementType": "geometry.fill", "stylers": [ { "color": "#c7e5c8" } ] }, { "featureType": "poi.place_of_worship", "elementType": "geometry.fill", "stylers": [ { "color": "#d6cbc7" } ] }, { "featureType": "poi.school", "elementType": "geometry.fill", "stylers": [ { "color": "#c4c9e8" } ] }, { "featureType": "poi.sports_complex", "elementType": "geometry.fill", "stylers": [ { "color": "#b1eaf1" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "lightness": "100" } ] }, { "featureType": "road", "elementType": "labels", "stylers": [ { "visibility": "off" }, { "lightness": "100" } ] }, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ { "color": "#ffd4a5" } ] }, { "featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [ { "color": "#ffe9d2" } ] }, { "featureType": "road.local", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.local", "elementType": "geometry.fill", "stylers": [ { "weight": "3.00" } ] }, { "featureType": "road.local", "elementType": "geometry.stroke", "stylers": [ { "weight": "0.30" } ] }, { "featureType": "road.local", "elementType": "labels.text", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#747474" }, { "lightness": "36" } ] }, { "featureType": "road.local", "elementType": "labels.text.stroke", "stylers": [ { "color": "#e9e5dc" }, { "lightness": "30" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "visibility": "on" }, { "lightness": "100" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "color": "#d2e7f7" } ] } ]';
            break;
        case '7' :
            $customstyle_map = '[ { "featureType": "landscape", "stylers": [ { "saturation": -100 }, { "lightness": 60 } ] }, { "featureType": "road.local", "stylers": [ { "saturation": -100 }, { "lightness": 40 }, { "visibility": "on" } ] }, { "featureType": "transit", "stylers": [ { "saturation": -100 }, { "visibility": "simplified" } ] }, { "featureType": "administrative.province", "stylers": [ { "visibility": "off" } ] }, { "featureType": "water", "stylers": [ { "visibility": "on" }, { "lightness": 30 } ] }, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ { "color": "#ef8c25" }, { "lightness": 40 } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.park", "elementType": "geometry.fill", "stylers": [ { "color": "#b6c54c" }, { "lightness": 40 }, { "saturation": -40 } ] }, {} ]';
            break;
        case '8' :
            $customstyle_map = '[ { "featureType": "administrative", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [ { "visibility": "on" } ] }, { "featureType": "administrative", "elementType": "labels", "stylers": [ { "visibility": "on" }, { "color": "#716464" }, { "weight": "0.01" } ] }, { "featureType": "administrative.country", "elementType": "labels", "stylers": [ { "visibility": "on" } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "landscape.natural", "elementType": "geometry", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "landscape.natural.landcover", "elementType": "geometry", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi", "elementType": "geometry.fill", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi", "elementType": "geometry.stroke", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi", "elementType": "labels.text", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi", "elementType": "labels.text.stroke", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi.attraction", "elementType": "geometry", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.highway", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "visibility": "simplified" }, { "color": "#a05519" }, { "saturation": "-13" } ] }, { "featureType": "road.local", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "transit", "elementType": "geometry", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "visibility": "on" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "visibility": "simplified" }, { "color": "#84afa3" }, { "lightness": 52 } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "visibility": "on" } ] }, { "featureType": "water", "elementType": "geometry.fill", "stylers": [ { "visibility": "on" } ] } ]';
            break;
        case '9' :
            $customstyle_map = '[ { "featureType": "all", "elementType": "labels.text.fill", "stylers": [ { "color": "#7c93a3" }, { "lightness": "-10" } ] }, { "featureType": "administrative.country", "elementType": "geometry", "stylers": [ { "visibility": "on" } ] }, { "featureType": "administrative.country", "elementType": "geometry.stroke", "stylers": [ { "color": "#a0a4a5" } ] }, { "featureType": "administrative.province", "elementType": "geometry.stroke", "stylers": [ { "color": "#62838e" } ] }, { "featureType": "landscape", "elementType": "geometry.fill", "stylers": [ { "color": "#dde3e3" } ] }, { "featureType": "landscape.man_made", "elementType": "geometry.stroke", "stylers": [ { "color": "#3f4a51" }, { "weight": "0.30" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "poi.attraction", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "poi.business", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.government", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.park", "elementType": "all", "stylers": [ { "visibility": "on" } ] }, { "featureType": "poi.place_of_worship", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.school", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.sports_complex", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "saturation": "-100" }, { "visibility": "on" } ] }, { "featureType": "road", "elementType": "geometry.stroke", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ { "color": "#bbcacf" } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "lightness": "0" }, { "color": "#bbcacf" }, { "weight": "0.50" } ] }, { "featureType": "road.highway", "elementType": "labels", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.highway", "elementType": "labels.text", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.highway.controlled_access", "elementType": "geometry.fill", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road.highway.controlled_access", "elementType": "geometry.stroke", "stylers": [ { "color": "#a9b4b8" } ] }, { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [ { "invert_lightness": true }, { "saturation": "-7" }, { "lightness": "3" }, { "gamma": "1.80" }, { "weight": "0.01" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "water", "elementType": "geometry.fill", "stylers": [ { "color": "#a3c7df" } ] } ]';
            break;
        case '10' :
            $customstyle_map = '[ { "featureType": "administrative", "elementType": "all", "stylers": [ { "visibility": "on" }, { "lightness": 33 } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "color": "#f2e5d4" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#c5dac6" } ] }, { "featureType": "poi.park", "elementType": "labels", "stylers": [ { "visibility": "on" }, { "lightness": 20 } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "lightness": 20 } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#c5c6c6" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#e4d7c6" } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#fbfaf7" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "visibility": "on" }, { "color": "#acbcc9" } ] } ]';
            break;
        case '11' :
            $customstyle_map = '[ { "featureType": "all", "elementType": "labels.text.fill", "stylers": [ { "saturation": 36 }, { "color": "#000000" }, { "lightness": 40 } ] }, { "featureType": "all", "elementType": "labels.text.stroke", "stylers": [ { "visibility": "on" }, { "color": "#000000" }, { "lightness": 16 } ] }, { "featureType": "all", "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "administrative", "elementType": "geometry.fill", "stylers": [ { "color": "#000000" }, { "lightness": 20 } ] }, { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [ { "color": "#000000" }, { "lightness": 17 }, { "weight": 1.2 } ] }, { "featureType": "administrative", "elementType": "labels", "stylers": [ { "visibility": "off" } ] }, { "featureType": "administrative.country", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "administrative.country", "elementType": "geometry", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "administrative.country", "elementType": "labels.text", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "administrative.province", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "administrative.locality", "elementType": "all", "stylers": [ { "visibility": "simplified" }, { "saturation": "-100" }, { "lightness": "30" } ] }, { "featureType": "administrative.neighborhood", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "administrative.land_parcel", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "visibility": "simplified" }, { "gamma": "0.00" }, { "lightness": "74" } ] }, { "featureType": "landscape", "elementType": "geometry", "stylers": [ { "color": "#000000" }, { "lightness": 20 } ] }, { "featureType": "landscape.man_made", "elementType": "all", "stylers": [ { "lightness": "3" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#000000" }, { "lightness": 21 } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ { "color": "#000000" }, { "lightness": 17 } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#000000" }, { "lightness": 29 }, { "weight": 0.2 } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#000000" }, { "lightness": 18 } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#000000" }, { "lightness": 16 } ] }, { "featureType": "transit", "elementType": "geometry", "stylers": [ { "color": "#000000" }, { "lightness": 19 } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#000000" }, { "lightness": 17 } ] } ]';
            break;
        case '12' :
            $customstyle_map = '[ { "elementType": "geometry", "stylers": [ { "color": "#242f3e" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#746855" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#242f3e" } ] }, { "featureType": "administrative.locality", "elementType": "labels.text.fill", "stylers": [ { "color": "#d59563" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#d59563" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#263c3f" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#6b9a76" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#38414e" } ] }, { "featureType": "road", "elementType": "geometry.stroke", "stylers": [ { "color": "#212a37" } ] }, { "featureType": "road", "elementType": "labels.text.fill", "stylers": [ { "color": "#9ca5b3" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#746855" } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#1f2835" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#f3d19c" } ] }, { "featureType": "transit", "elementType": "geometry", "stylers": [ { "color": "#2f3948" } ] }, { "featureType": "transit.station", "elementType": "labels.text.fill", "stylers": [ { "color": "#d59563" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#17263c" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#515c6d" } ] }, { "featureType": "water", "elementType": "labels.text.stroke", "stylers": [ { "color": "#17263c" } ] } ]';
        break;
    }

    if ($map_style_custom =='custom') {
        $styles_map_text = 'styles:';
        $customstyle_map_style = $customstyle_map.",";
    } else {
        $styles_map_text = '';
        $customstyle_map_style = '';
    }

    $vc_class = 'fl-map';

    $vc_init = uniqid('fl_');
    $image_done = wp_get_attachment_image_src($map_img, 'full');


    ob_start(); ?>

    <?php echo '<div id="map-' . $vc_init . '" class="' . $vc_class . fl_sanitize_class($class) . '" style="height:' . $size . ';"></div>';?>


    <?php
    wp_register_script( '' . $vc_init . 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key='.$apikey );
    wp_print_scripts( '' . $vc_init . 'google-maps-api' );
    ?>
    <script type="text/javascript">
        jQuery.noConflict()(function($){
            $("#map-<?php echo $vc_init ?>").gmap3({
                marker:{
                    address :"<?php echo $address ?>",
                    options:{
                        icon: "<?php echo $image_done[0] ?>"
                    }
                },
                map:{
                    options:{
                        <?php echo $styles_map_text ?><?php echo $customstyle_map_style ?>

                        zoom: <?php echo $zoom ?>,
                        scrollwheel: <?php echo $map_scrollwheel ?>,
                        draggable: true,
                        mapTypeControl: true
                    }
                }
            });
        });
    </script>

    <?php


    return ob_get_clean();
}

add_action('vc_before_init', 'vc_fl_google_map_shortcode');

function vc_fl_google_map_shortcode()
{
    if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Google Map', 'fl-themes-helper'),
            'base'          => 'vc_fl_google_map',
            'icon'          => 'fl-icon icon-fl-google-map',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'      => 'full',
            'weight'        => 500,
            'params' => array(
                array(
                    'type'          => 'textfield',
                    'param_name'    => 'address',
                    'heading'       => esc_html__('Address', 'fl-themes-helper'),
                    'admin_label'   => true,
                    'value'         => 'New York',
                ),
                array(
                    'type'          => 'textfield',
                    'param_name'    => 'apikey',
                    'heading'       => esc_html__('API Key', 'fl-themes-helper'),
                    'value'         => '',
                    'std'           =>'AIzaSyAno0gm_AuDYUQMG_a8I_EfyxSpdKjZmzc',
                ),

                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Map Zoom', 'fl-themes-helper'),
                    'param_name'    => 'zoom',
                    'admin_label'   => true,
                    'value'         => array(
                                1,
                                2,
                                3,
                                4,
                                5,
                                6,
                                7,
                                8,
                                9,
                                10,
                                11,
                                12,
                                13,
                                14,
                                15,
                                16,
                                17,
                                18,
                                19,
                                20
                    ),
                    'std'           => 14, 
                    'group'         => 'Style'
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Map Height (px)', 'fl-themes-helper'),
                    'param_name'    => 'size',
                    'admin_label'   => true,
                    'value'         => '400px',

                ),
                array(
                    'type'          => 'attach_image',
                    'heading'       => esc_html__('Map Marker', 'fl-themes-helper'),
                    'param_name'    => 'map_img',
                    'value'         => '',
                    'group'         => 'Style'
                ),

                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Scrollwheel Zoom', 'fl-themes-helper'),
                    'param_name'    => 'map_scrollwheel',
                    'value' => array(
                            esc_html__('True', 'fl-themes-helper')      => 'true',
                            esc_html__('False', 'fl-themes-helper')     => 'false',
                    ),
                    'std'           => 'false',
                    'group'         => 'Style'
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Map style', 'fl-themes-helper'),
                    'param_name'    => 'map_style_custom',
                    'value' => array(
                            esc_html__('Custom', 'fl-themes-helper')    => 'custom',
                            esc_html__('Default', 'fl-themes-helper')   => 'default',
                    ),
                    'std'           => 'custom',
                    'group'         => 'Style'
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Style', 'fl-themes-helper'),
                    'param_name'    => 'map_style',
                    'value' => array(
                            esc_html__('Light coloured', 'fl-themes-helper')    => 1,
                            esc_html__('Ultra Light', 'fl-themes-helper')       => 2,
                            esc_html__('Light', 'fl-themes-helper')             => 3,
                            esc_html__('Light Blue', 'fl-themes-helper')        => 4,
                            esc_html__('Grey Blue', 'fl-themes-helper')         => 5,
                            esc_html__('Flat', 'fl-themes-helper')              => 6,
                            esc_html__('Pastel', 'fl-themes-helper')            => 7,
                            esc_html__('Green', 'fl-themes-helper')             => 8,
                            esc_html__('Blue', 'fl-themes-helper')              => 9,
                            esc_html__('Pale Dawn', 'fl-themes-helper')         => 10,
                            esc_html__('Dark', 'fl-themes-helper')              => 11,
                            esc_html__('Dark 2', 'fl-themes-helper')              => 12,
                    ),
                    'dependency' => array(
                            'element'           => 'map_style_custom',
                            'value'             => array('custom'),
                    ),
                    'group'         => 'Style'
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
            )
        ));
    }
}