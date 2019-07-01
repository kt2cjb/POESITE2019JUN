<?php
/**
 * Most Commented Widget
 */
class Fl_Mostcommented_Widget extends WP_Widget
{
    /**
     * General Setup
     */
    public function __construct() {

        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'fl_mostcommented_widget',
            'description' => 'A widget that displays your most commented posts'
        );

        /* Widget control settings. */
        $control_ops = array(
            'width'		=> 300,
            'height'	=> 350,
            'id_base'	=> 'fl_mostcommented_widget'
        );

        /* Create the widget. */
        parent::__construct( 'fl_mostcommented_widget', 'Fl Most Commented Posts', $widget_ops, $control_ops );
    }

    /**
     * Display Widget
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance )
    {
        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );

        /* Our variables from the widget settings. */
        $number = $instance['number'];

        /* Before widget (defined by themes). */
        echo fl_wp_kses($before_widget);

        // Display Widget
        ?>
    <?php /* Display the widget title if one was input (before and after defined by themes). */
        if ( $title )
            echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
        ?>
    <div class="fl-mostcommented-widget">
        <div class="cf">

            <?php
            $query = new WP_Query(array(
                'posts_per_page'		=> $number,
                'ignore_sticky_posts'	=> 1,
                'orderby'               => 'comment_count',
            ));
            ?>
            <?php global $post; if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
						<div class="cf fl-most-commented-post">
							<div class="fl-entry-thumb">
                                <a class="whitelink" href="<?php the_permalink(); ?>">
                                    <?php echo get_the_post_thumbnail($post->ID,'size_1170x1170_crop') ?>
                                </a>
                            </div>
                            <div class="fl-post-detail">
                                <h4 class="fl-entry-title">
                                    <a class="whitelink" href="<?php the_permalink(); ?>">
                                        <span class="title"><?php the_title(); ?></span>
                                    </a>
                                </h4>
                                <div class="fl_recent_comment_count">
                                    <?php echo '<a class="fl-post-comments" href="'.get_comments_link().'" target="_self">';
                                    comments_number('<i class="fa fa-comments-o" ></i>'.' 0 '.esc_html__('Comments','rest') , '<i class="fa fa-comment-o"></i>'.' 1 '.esc_html__('Comment','rest'), '<i class="fa fa-comments-o" ></i>'.' % '.esc_html__('Comments','rest'));
                                    echo '</a>';?>
                                </div>
                            </div>
                        </div>
            <?php endwhile; endif; ?>
        </div>

    </div><!--blog_widget-->

    <?php

        /* After widget (defined by themes). */
        echo fl_wp_kses($after_widget);
    }

    /**
     * Update Widget
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['number'] = strip_tags( $new_instance['number'] );

        return $instance;
    }

    /**
     * Widget Settings
     * @param array $instance
     */
    public function form( $instance )
    {
        //default widget settings.
        $defaults = array(
            'title' => esc_html__('Most Commented', 'fl-themes-helper'),
            'number' => 3
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
    </p>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Posts to show:', 'fl-themes-helper') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" value="<?php echo ''.$instance['number']; ?>" />
    </p>
    <?php
    }
}