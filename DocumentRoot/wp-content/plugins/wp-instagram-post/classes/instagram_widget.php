<?php
/**
 * Adds WT_Widget widget.
 */
class WIGP_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		global $wpigp;
		$this->wpigp = $wpigp;
		parent::__construct(
			'wigp_widget', // Base ID
			__( 'WP Instagram Post Widget', 'wpigp' ), // Name
			array( 'description' => __( 'A WP Instagram Widget to show user images', 'wpigp' ), ) // Args
		);
	}

	/**
	 * returns a big old hunk of JSON from a non-private IG account page.
	 */
	function scrape_insta($username) {
		try{
			
			$this->wpigp->wigp_get_inst(true);
			$userId = $this->wpigp->igp->people->getUserIdForName($username);

		    $maxId = null;
		    do {
		        // Request the page corresponding to maxId.
		        $response = $this->wpigp->igp->timeline->getUserFeed($userId, $maxId);

		        foreach ($response->getItems() as $item) {
		            $item_url = $item->getCode();
		            $item = json_decode($item);

		            if (isset($item->image_versions2))
		            	$insta_array[] = array( 'item_img' => $item->image_versions2, 'item_url' => $item_url);
		        }

		    } while ($maxId !== null); // Must use "!==" for comparison instead of "!=".

			if (is_array($insta_array)){

				return array_filter($insta_array);
			}
			else
			 	return __( 'Nothing found!', 'wpigp' );
		}
		catch(Exception $e) {
		  return $e->getMessage();
		}
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$IgUserName = ! empty( $instance['IgUserName'] ) ? $instance['IgUserName'] : '';
		$ImgCount = ! empty( $instance['ImgCount'] ) ? $instance['ImgCount'] : '5';
		$display_style = ! empty( $instance['display_style'] ) ? $instance['display_style'] : 'display_src';
		
		$results_array = $this->scrape_insta($IgUserName);
		if ( is_array($results_array) and array_filter($results_array) ){
			
			for($cnt=0; $cnt < $ImgCount; $cnt++)
			{
				if (array_key_exists($cnt, $results_array)){
					$latest_array = $results_array[$cnt];
					echo '<a href="http://instagram.com/p/'.$latest_array['item_url'].'"><img src="'.$latest_array['item_img']->candidates[1]->url.'"></a></br>';
				}
			}
		}
		else
			echo '<div id="message" class="error"><p>' . $results_array . '</p></div>';

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Instagram!', 'wpigp' );
		$IgUserName = ! empty( $instance['IgUserName'] ) ? $instance['IgUserName'] : '';
		$ImgCount = ! empty( $instance['ImgCount'] ) ? $instance['ImgCount'] : '5';
		$display_style = ! empty( $instance['display_style'] ) ? $instance['display_style'] : 'display_src';
		?>
		
        <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ), 'wpigp' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        
		<p>
		<label for="<?php echo $this->get_field_id( 'IgUserName' ); ?>"><?php _e( 'Instagram Username', 'wpigp' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'IgUserName' ); ?>" name="<?php echo $this->get_field_name( 'IgUserName' ); ?>" type="text" value="<?php echo esc_attr( $IgUserName ); ?>" placeholder="<?php _e( 'Enter Instagram User','wpigp'); ?>">
		</p>
		
        <p>
		<label for="<?php echo $this->get_field_id( 'ImgCount' ); ?>"><?php _e( 'Number of Images! 1 to 15', 'wpigp' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ImgCount' ); ?>" 
			   name="<?php echo $this->get_field_name( 'ImgCount' ); ?>" 
			   type="number" min="1" max="15" 
			   value="<?php echo esc_attr( $ImgCount ); ?>" 
			   onkeydown="return false">
        </p>

		<p>
		<label for="<?php echo $this->get_field_id( 'display_style' ); ?>"><?php _e( 'Image Style', 'wpigp' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'display_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_style' ) ); ?>" class="widefat">
				<option value="thumbnail_src" <?php selected( 'thumbnail_src', $display_style ) ?>><?php _e( 'Thumbnail (Square)', 'wpigp' ); ?></option>
				<option value="display_src" <?php selected( 'display_src', $display_style ) ?>><?php _e( 'Original (Keep aspect ratio)', 'wpigp' ); ?></option>
			</select>
		</p>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['IgUserName'] = ( ! empty( $new_instance['IgUserName'] ) ) ? strip_tags( $new_instance['IgUserName'] ) : '';
		$instance['ImgCount'] = ( ! empty( $new_instance['ImgCount'] ) ) ? strip_tags( $new_instance['ImgCount'] ) : '';
		$instance['display_style'] = ( ! empty( $new_instance['display_style'] ) ) ? strip_tags( $new_instance['display_style'] ) : '400';
		
		return $instance;
	}

} // class Foo_Widget
?>