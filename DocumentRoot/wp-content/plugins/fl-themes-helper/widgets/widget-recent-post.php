<?php
/**
 * Blog Widget 
 */
class Fl_Recent_Post_Widget extends WP_Widget
{
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'fl_recent_post_widget',
			'description' => esc_html__('A widget that displays your latest posts with image.', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'		=> 300, 
			'height'	=> 350, 
			'id_base'	=> 'fl_recent_post_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_recent_post_widget', esc_html__('Fl Recent Posts', 'fl-themes-helper'), $widget_ops, $control_ops );
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
			<div class="fl-recent-post-widget">
                <div class="cf">
                    <?php
                    $query = new WP_Query(array(
                        'posts_per_page'		=> $number,
                        'ignore_sticky_posts'	=> 1,
                        'orderby'               => 'date',
                        'order'                 => 'DESC'
                    ));
                    ?>
                    <?php global $post; if ($query->have_posts()) : $i=0; while ($query->have_posts()) : $query->the_post(); $i++; ?>
                        <article class="fl_recent_post cf" id="fl-widget-recent-post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                            <div class="fl-recent-post-img">
                                <?php if ( has_post_thumbnail()) { ?>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                                        <?php  echo get_the_post_thumbnail($post->ID, 'size_1170x1170_crop');; ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="fl-recent-post-info">
                                <?php if(get_the_title() == false ){ ?>
                                    <h5 class="fl-recent-post-title"><a href="<?php echo esc_url(the_permalink()); ?>"><?php esc_html_e('No Title','rest'); ?></a></h5>
                                <?php } ?>
                                <h5 class="fl-recent-post-title"><a class="main_color_hover" href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title()); ?></a></h5>
                                <div class="date_info"><?php echo get_the_date() ?></div>
                                <div class="fl_recent_comment_count">
                                    <?php echo '<a class="fl-post-comments" href="'.get_comments_link().'" target="_self">';
                                    comments_number('<i class="fa fa-comments-o" ></i>'.' 0 '.esc_html__('Comments','rest') , '<i class="fa fa-comment-o"></i>'.' 1 '.esc_html__('Comment','rest'), '<i class="fa fa-comments-o" ></i>'.' % '.esc_html__('Comments','rest'));
                                    echo '</a>';?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; endif; wp_reset_query(); ?>



                </div>
                
            </div><!--End fl-recent-post-widget-->
		
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
			'title' => esc_html__('Recent Posts', 'fl-themes-helper'),
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