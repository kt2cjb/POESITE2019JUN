<?php
/**
 * Custom User Contact methods
 */

add_filter('user_contactmethods', 'fl_add_contact_info');

if (!function_exists('fl_add_contact_info')) {

    function fl_add_contact_info($contact_info)
    {
        $contact_info['facebook']       = esc_html__('Facebook Username', 'fl-themes-helper');
        $contact_info['google']         = esc_html__('Google Plus Username', 'fl-themes-helper');
        $contact_info['instagram']      = esc_html__('Instagram Username', 'fl-themes-helper');
        $contact_info['pinterest']      = esc_html__('Pinterest Username', 'fl-themes-helper');
        $contact_info['twitter']        = esc_html__('Twitter Username', 'fl-themes-helper');
        $contact_info['behance']        = esc_html__('Behance Username', 'fl-themes-helper');
        return $contact_info;
    }

}


/**
 * Custom Excerpt length
 */
function fl_limit_excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}
/**
 * Custom Pagination
 */
function fl_custom_pagination($pages = '', $range = 2)
{

    global $paged;
    if(empty($paged)) $paged = 1;

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }

    if(1 != $pages)
    {

        if($paged > 1  ) echo "<a href='".get_pagenum_link($paged - 1)."' class='page-numbers'><i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i></a>";

        if($paged > 2 && $paged > $range+1 && $range < $pages) echo "<a href='".get_pagenum_link(1)."' class='page-numbers'>1</a>";
        if($paged > 2 && $paged > $range+2 && $range < $pages) echo "<span class='page-numbers dots'>…</span>";
        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $range ))
            {
                echo ($paged == $i)? "<span class=\"page-numbers current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"page-numbers\">".$i."</a>";
            }
        }
        if ($paged < $pages-1 &&  $paged+$range+1 < $pages && $range+1 < $pages ) echo "<span class='page-numbers dots'>…</span>";
        if ($paged < $pages-1 &&  $paged+$range < $pages && $range+1 < $pages ) echo "<a href='".get_pagenum_link($pages)."' class=\"page-numbers\">".$pages."</a>";

        if ($paged < $pages ) echo "<a href=\"".get_pagenum_link($paged + 1)."\" class=\"page-numbers\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></a>";
    }
}


/* get_intermediate_image_sizes() without keys */
if (!function_exists( 'fl_get_image_sizes' )) :
    function fl_get_image_sizes() {
        $sizes = get_intermediate_image_sizes();
        $result = array('full' => 'full');
        foreach($sizes as $k => $name) {
            $result[$name] = $name;
        }
        return $result;
    }
endif;


/**
 * Get Attachment Attribute for Images
 */
if (!function_exists( 'fl_get_attachment' )) :
    function fl_get_attachment($attachment_id, $attachment_size = 'full')
    {
        if (filter_var($attachment_id, FILTER_VALIDATE_URL)) {
            $path_to_image = $attachment_id;
            $attachment_id = attachment_url_to_postid($attachment_id);
            if (is_numeric($attachment_id) && $attachment_id == 0) {
                return array(
                    'alt' => null,
                    'caption' => null,
                    'description' => null,
                    'href' => null,
                    'src' => $path_to_image,
                    'title' => null,
                    'width' => null,
                    'height' => null,
                );
            }
        }

        if (is_numeric($attachment_id) && $attachment_id !== 0) {
            $attachment = get_post($attachment_id);
            if(is_object($attachment)) {
                $attachment_src = array();
                if (isset($attachment_size)) {
                    $attachment_src = wp_get_attachment_image_src($attachment_id, $attachment_size);
                }
                return array(
                    'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
                    'caption' => $attachment->post_excerpt,
                    'description' => $attachment->post_content,
                    'href' => get_permalink($attachment->ID),
                    'src' => isset($attachment_src[0]) ? $attachment_src[0] : $attachment->guid,
                    'title' => $attachment->post_title,
                    'width' => isset($attachment_src[1]) ? $attachment_src[1] : false,
                    'height' => isset($attachment_src[2]) ? $attachment_src[2] : false,
                );
            }
        }
        return false;
    }
endif;


function fl_post_taxonomy($post_id, $taxonomy, $delimiter = ', ', $get = 'name', $link = true)
{
    $tags = wp_get_post_terms($post_id, $taxonomy);
    $list = '';
    foreach ($tags as $tag) {
        if ($link) {
            $list .= '<a href="' . get_category_link($tag->term_id) . '">' . $tag->$get . '</a>' . $delimiter;
        } else {
            $list .= $tag->$get . $delimiter;
        }
    }
    return substr($list, 0, strlen($delimiter) * (-1));
}


function fl_wp_kses($fl_string){
    $allowed_tags = array(
        'img' => array(
            'src' => array(),
            'alt' => array(),
            'width' => array(),
            'height' => array(),
            'class' => array(),
        ),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
        ),
        'span' => array(
            'class' => array(),
        ),
        'div' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h1' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h2' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h3' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h4' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h5' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h6' => array(
            'class' => array(),
            'id' => array(),
        ),
        'p' => array(
            'class' => array(),
            'id' => array(),
        ),
        'strong' => array(
            'class' => array(),
            'id' => array(),
        ),
        'i' => array(
            'class' => array(),
            'id' => array(),
        ),
        'del' => array(
            'class' => array(),
            'id' => array(),
        ),
        'ul' => array(
            'class' => array(),
            'id' => array(),
        ),
        'li' => array(
            'class' => array(),
            'id' => array(),
        ),
        'ol' => array(
            'class' => array(),
            'id' => array(),
        ),
        'input' => array(
            'class' => array(),
            'id' => array(),
            'type' => array(),
            'style' => array(),
            'name' => array(),
            'value' => array(),
        ),
    );
    if (function_exists('wp_kses')) {
        return wp_kses($fl_string,$allowed_tags);
    }
}

if (!function_exists('fl_remove_wpautop')):
    function fl_remove_wpautop($content, $autop = false) {
        if ($autop) {
            $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
        }
        return do_shortcode(shortcode_unautop($content));
    }
endif;



//delete [...] before output and trim to need char length
if (!function_exists('fl_excerpt_max_charlength')):
    function fl_excerpt_max_charlength($limit = 15, $return_mode = false) {
        $content = wp_trim_words(do_shortcode(get_the_content()), $limit, '...');
        if ($return_mode){
            return $content;
        }
        else{
            echo esc_html($content);
        }
    }
endif;