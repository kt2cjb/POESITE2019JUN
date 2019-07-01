<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * WPIGP Base Class
 *
 * All functionality pertaining to core functionality of the WP Instagram Post plugin.
 *
 * @package WordPress
 * @subpackage WPIGP
 * @author qsheeraz
 * @since 0.0.1
 *
 */

class Woo_IGP {
	public $version;
	private $file;

	private $token;
	private $prefix;

	private $plugin_url;
	private $assets_url;
	private $plugin_path;
	
	public $igp;
	
	private $ig_user_name;
	private $ig_password;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct ( $file ) {
		$this->version = '';
		$this->file = $file;
		$this->prefix = 'woo_igp_';

		/* Plugin URL/path settings. */
		$this->plugin_url = str_replace( '/classes', '', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
		$this->plugin_path = str_replace( 'classes', '', plugin_dir_path( __FILE__ ));
		$this->assets_url = $this->plugin_url . '/assets';

		
	} // End __construct()

	/**
	 * init function.
	 *
	 * @access public
	 * @return void
	 */
	public function init () {
		add_action( 'init', array( $this, 'load_localisation' ) );

		add_action( 'admin_init', array( $this, 'wooigp_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'wooigp_admin_menu' ) );
		
		add_action( 'wp_ajax_wigp_save_user', array( $this, 'wigp_save_user' ));
		add_action( 'wp_ajax_wigp_submit_verification_code', array( $this, 'wigp_submit_verification_code' ));
		
		add_action( 'wp_ajax_wigp_save_meta_box', array( $this, 'wigp_save_meta_box' ));
		add_action( 'save_post', array( $this, 'wigp_instagram_post' ));
		add_action( 'wp_ajax_wigp_delete_user', array( $this, 'wigp_delete_user' ));

		add_action( 'post_submitbox_misc_actions', array( $this, 'wigp_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_wigp_meta_boxes' ), 1, 2 );

		add_action( 'wigp_schedule_action', array($this, 'wigp_ig_post' ), 1, 1);
		
		add_action( 'widgets_init', array( $this, 'register_wigp_widget' ) );

		// Run this on activation.
		register_activation_hook( $this->file, array( $this, 'activation' ) );
	} // End init()
	
	function pa($arr){

		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}

	/**
	 * register instagram widget
	 *
	 * @return void
	 * @author 
	 **/
	function register_wigp_widget() {
		register_widget( 'WIGP_Widget' );
	}

	/**
	 * register Instagram meta box
	 *
	 * @return void
	 * @author 
	 **/
	function add_wigp_meta_boxes( $post_type, $post ) {
	    add_meta_box( 
	        'wigp-meta-box',
	        __( 'WP Instagram Post' ),
	        array( $this, 'wigp_meta_box' ),
	        'post',
	        'side',
	        'default'
	    );
	}

	/**
	 * get new Instagram instance
	 *
	 * @access public
	 */
	function wigp_get_inst($widget_login = false){

		$this->wigp_username = get_option( 'wigp_username');
		$this->wigp_password = get_option( 'wigp_password');
		$this->wigp_proxy    = get_option( 'wigp_proxy');

		/**
		 * Login and video processing calling and initiating at the backend.
		 * No user intervention in calling or stopping involved in it.
		 * That's why its safe to run.
		 */
		\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
		$this->igp = new \InstagramAPI\Instagram(false, true);
		
		try {

		    if ( $this->wigp_proxy != "" )
		    	$this->igp->setProxy($this->wigp_proxy);
		    
			$loginResponse = $this->igp->login($this->wigp_username, $this->wigp_password);

			if ($loginResponse !== null && $loginResponse->isTwoFactorRequired()) {
        		$twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();
        		update_option( '_wigp_twoFactorIdentifier', $twoFactorIdentifier );
        		return array('success' => 2, 'msg' => __('Please submit two factor code!', 'wpigp') );

        	} else {
				return array('success' => 1, 'msg' => __('Login Successful!', 'wpigp') );
        		// return true;
        	}

		} catch (\Exception $e) {

			$options = get_option( 'wooigp_settings' );
			if ( $options['wooigp_checkbox_notifications'] && !$widget_login ){
				$admin_email = get_option( 'admin_email' );
				if ( empty( $admin_email ) ) {
					$current_user = wp_get_current_user();
					$admin_email = $current_user->user_email;
				}
				
				$msg = __('Unable to login Instagram!', 'wpigp') . "\r\n";
				$msg.= $e->getMessage();
				wp_mail($admin_email, __('WP Instagram - Login', 'wpigp'), $msg, $this->wigp_headers());
			}

			return array('success' => 0, 'msg' => $e->getMessage());
			// return false;
		}
	}
	

	/**
	 * wigp_meta_box function.
	 *
	 * @access public
	 * @return void
	 */
	public function wigp_meta_box() {
		global $post; global $post_type;
		$post_id = get_the_ID();
		
		?>
		<div id="wpigp" class="misc-pub-section misc-pub-section-last">
		<?php

			echo '<img src="'.$this->assets_url.'/instagram.png" >&nbsp;&nbsp;&nbsp;';
			echo "<b>";_e( 'WP Instagram:', 'wpigp' ); echo "</b>";
			$ig_post = metadata_exists('post', $post_id, '_wigp_ig') ? get_post_meta( $post_id, '_wigp_ig', true ) : 'checked';
			$ig_msg = ( get_post_meta( $post_id, '_wigp_msg', true ) ? get_post_meta( $post_id, '_wigp_msg', true ) : $post->title );
			?>
			<div id="wigp-form" style="display: none;">
            	<br />
                <input type="checkbox" name="chk_ig" id="chk-ig" <?php echo $ig_post; ?> />
                <label for="chk-ig"><b><?php _e( 'Post to Instagram?', 'wpigp' ); ?></b></label><br />
				<label for="wigp-custom-msg"><?php _e( 'Custom Message: (No html tags)', 'wpigp' ); ?></label>
				<textarea name="wigp_custom_msg" id="wigp-custom-msg"><?php echo $ig_msg; ?></textarea>
				<a href="#" id="wigp-form-ok" class="button"><?php _e( 'Save', 'wpigp' ); ?></a>
				<a href="#" id="wigp-form-hide"><?php _e( 'Cancel', 'wpigp' ); ?></a>
                <input type="hidden" name="postid" id="postid" value="<?php echo get_the_ID()?>" />
			</div>
             &nbsp; <a href="#" id="wigp-form-edit"><?php _e( 'Edit', 'wpigp' ); ?></a>
		</div> 
        
		<script type="text/javascript"><!--
        jQuery(document).ready(function($){
                $("#wigp-form").hide();
                
            $("#wigp-form-edit").click(function(){
				$("#wigp-form-edit").hide();
                $("#wigp-form").show(1000);
            });
            
            $("#wigp-form-hide").click(function(){
                $("#wigp-form").hide(1000);
				$("#wigp-form-edit").show();
            });
           
		    $("#wigp-form-ok").click(function(){
				var custom_msg;
       			custom_msg = $("#wigp-custom-msg").val();
				var data = {
					action: 'wigp_save_meta_box',
					ig_msg: custom_msg,
					postid: $("#postid").val(),
					chk_ig: $("#chk-ig").attr("checked"),
				};
				$.post(ajaxurl, data, function(response) {
					console.log('Got this from the server: ' + response);
				});
                $("#wigp-form").hide(1000);
				$("#wigp-form-edit").show();
            });

        });
		//-->
        </script>
		<?php 
		
	}

	/**
	 * wigp_save_meta_box function.
	 *
	 * @access public
	 * @return void
	 */	
	public function wigp_save_meta_box($post) {

		if ( isset( $_POST['postid'] ) && (int)$_POST['postid'] ) {
			$ig_message = sanitize_text_field( $_POST['ig_msg'] );
			$ig_post_cb = sanitize_text_field( $_POST['chk_ig'] );
			$postid = (int)$_POST['postid'];

			update_post_meta ($postid, '_wigp_msg', $ig_message );
			update_post_meta ($postid, '_wigp_ig', $ig_post_cb );
		}

		die(0);
	}
	
	/**
	 * wooigp_admin_init function.
	 *
	 * @access public
	 * @return void
	 */		
	public function wooigp_admin_init() {
       /* Register stylesheet. */
        wp_register_style( 'wooigpStylesheet', $this->plugin_url.'/wpigp.css' );
		
		register_setting( 'wooigp_options', 'wooigp_settings' );
	
		add_settings_section(
			'wooigp_options_section', 
			__( 'WP Instagram Post Settings!', 'wpigp' ), 
			array($this, 'wooigp_settings_section_callback'), 
			'wooigp_options'
		);
		
		add_settings_section(
			'wooigp_post_format_section', 
			'', 
			array($this, 'wooigp_post_format_section_callback'), 
			'wooigp_options'
		);

		add_settings_section(
			'wooigp_posts_options_section', 
			'', 
			array($this, 'wooigp_posts_section_callback'), 
			'wooigp_options'
		);
		
		add_settings_field( 
			'wooigp_checkbox_post_update', 
			__( 'Post to Instagram every time on post update?', 'wpigp' ), 
			array($this, 'wooigp_checkbox_post_update'), 
			'wooigp_options', 
			'wooigp_options_section' 
		);
	
		add_settings_field( 
			'wooigp_checkbox_notifications', 
			__( 'Get error notifications by email?', 'wpigp' ), 
			array($this, 'wooigp_checkbox_notifications'), 
			'wooigp_options', 
			'wooigp_options_section' 
		);
		
		if ( class_exists( 'WooCommerce' ) ) {
			add_settings_field( 
				'wooigp_checkbox_show_price', 
				__( 'Show Product Price?', 'wpigp' ), 
				array($this, 'wooigp_checkbox_show_price'), 
				'wooigp_options', 
				'wooigp_post_format_section' 
			);
		}
		
		add_settings_field( 
			'wooigp_checkbox_show_link', 
			__( 'Show Post Link?', 'wpigp' ), 
			array($this, 'wooigp_checkbox_show_link'), 
			'wooigp_options', 
			'wooigp_post_format_section' 
		);

		add_settings_field( 
			'wooigp_checkbox_post_tags', 
			__( 'Include Post tags?', 'wpigp' ), 
			array($this, 'wooigp_checkbox_post_tags'), 
			'wooigp_options', 
			'wooigp_post_format_section' 
		);

		add_settings_field( 
			'wooigp_number_show_words', 
			__( 'Show Post Details (words)', 'wpigp' ), 
			array($this, 'wooigp_number_show_words'), 
			'wooigp_options', 
			'wooigp_post_format_section' 
		);

		add_settings_field( 
			'wooigp_checkbox_post_types', 
			__( 'Select post types to post to Instagram!', 'wpigp' ), 
			array($this, 'wooigp_checkbox_post_types'), 
			'wooigp_options', 
			'wooigp_posts_options_section' 
		);
    }

	/**
	 * wooigp_options function.
	 *
	 * @access public
	 * @return void
	 */		
	public function wooigp_options () {
		
	?>
	<form action='options.php' method='post'>
	<div class="woosocio_wrap">
	<div id="woosocio-services-block">
		
		<?php
		settings_fields( 'wooigp_options' );
		do_settings_sections( 'wooigp_options' );
		submit_button();

		echo '</div>';
		
		$filepath = $this->plugin_path.'right_area.php';
		if (file_exists($filepath))
			include_once($filepath);
		else
			die('Could not load file '.$filepath);

		?>
	</div>	
	</form>
	<?php

	}

	function wooigp_checkbox_post_update(  ) { 
		$options = get_option( 'wooigp_settings' );
		if ( !isset ( $options['wooigp_checkbox_post_update'] ) )
			$options['wooigp_checkbox_post_update'] = 0;
		?>
		<input type='checkbox' 
			   class="ios8-switch" 
			   name='wooigp_settings[wooigp_checkbox_post_update]' <?php checked( $options['wooigp_checkbox_post_update'], 1 ); ?> 
   			   id = 'wooigp_checkbox_post_update'
			   value='1'>
		<label for="wooigp_checkbox_post_update"><b><?php //echo ucwords($post_type); ?></b></label>
		<span class='description'><?php _e( 'Only new posts will be posted to Instagram.', 'wpigp' ) ?></span>
		<?php
	
	}
	
	
	function wooigp_checkbox_notifications(  ) { 
		$options = get_option( 'wooigp_settings' );
		if ( !isset ( $options['wooigp_checkbox_notifications'] ) )
			$options['wooigp_checkbox_notifications'] = 0;
		?>
		<input type='checkbox' 
			   class="ios8-switch" 
			   name='wooigp_settings[wooigp_checkbox_notifications]' <?php checked( $options['wooigp_checkbox_notifications'], 1 ); ?> 
			   id = 'wooigp_checkbox_notifications'
			   value='1'>
		<label for="wooigp_checkbox_notifications"></label>
		<span class='description'><?php _e( 'Get error notifications in site admin inbox.', 'wpigp' ) ?></span>
		<?php
	
	}

	function wooigp_checkbox_show_price(  ) { 
		$options = get_option( 'wooigp_settings' );
		if ( !isset ( $options['wooigp_checkbox_show_price'] ) )
			$options['wooigp_checkbox_show_price'] = 0;
		?>
		<input type='checkbox' 
			   class="ios8-switch" 
			   name='wooigp_settings[wooigp_checkbox_show_price]' <?php checked( $options['wooigp_checkbox_show_price'], 1 ); ?> 
			   id = 'wooigp_checkbox_show_price'
			   value='1'>
		<label for="wooigp_checkbox_show_price"></label>
		<span class='description'><?php _e( 'Select if you want to show product price to Instagram.', 'wpigp' ) ?></span>
		<?php
	
	}

	function wooigp_checkbox_show_link(  ) { 
		$options = get_option( 'wooigp_settings' );
		if ( !isset ( $options['wooigp_checkbox_show_link'] ) )
			$options['wooigp_checkbox_show_link'] = 0;
		?>
		<input type='checkbox' 
			   class="ios8-switch" 
			   name='wooigp_settings[wooigp_checkbox_show_link]' <?php checked( $options['wooigp_checkbox_show_link'], 1 ); ?> 
			   id = 'wooigp_checkbox_show_link'
			   value='1'>
		<label for="wooigp_checkbox_show_link"></label>
		<span class='description'><?php _e( 'Select if you want to show post URL to Instagram.', 'wpigp' ) ?></span>
		<?php
	
	}

	function wooigp_checkbox_post_tags(  ) { 
		$options = get_option( 'wooigp_settings' );
		if ( !isset ( $options['wooigp_checkbox_post_tags'] ) )
			$options['wooigp_checkbox_post_tags'] = 0;
		?>
		<input type='checkbox' 
			   class="ios8-switch" 
			   name='wooigp_settings[wooigp_checkbox_post_tags]' <?php checked( $options['wooigp_checkbox_post_tags'], 1 ); ?> 
			   id = 'wooigp_checkbox_post_tags'
			   value='1'>
		<label for="wooigp_checkbox_post_tags"></label>
		<span class='description'><?php _e( 'Include post tags as hashtags for Instagram.', 'wpigp' ) ?></span>
		<?php
	
	}

	function wooigp_number_show_words(  ) { 
		$options = get_option( 'wooigp_settings' );
		if ( !isset ( $options['wooigp_number_show_words'] ) )
			$options['wooigp_number_show_words'] = 2200;
		?>
		<input type='number' 
			   min = '0'
			   max = '2200'
			   class="ios8-switch" 
			   name='wooigp_settings[wooigp_number_show_words]'
			   id = 'wooigp_number_show_words'
			   value = <?php echo $options['wooigp_number_show_words'] == '' ? 2200 : $options['wooigp_number_show_words'] ?> >
		<label for="wooigp_number_show_words"></label>
		<span class='description'><?php _e( 'Number of words in Instagram post. Enter 0 for no description.', 'wpigp' ) ?></span>
		<?php
	
	}

	function wooigp_checkbox_post_types(  ) { 
		$options = get_option( 'wooigp_settings' );
		if ( !isset ( $options['wooigp_checkbox_post_types'] ) )
			$options['wooigp_checkbox_post_types'] = array();
		
		foreach ( get_post_types( '', 'names' ) as $post_type ) {
		?>
		<input type='checkbox'
			   class="ios8-switch"
			   name='wooigp_settings[wooigp_checkbox_post_types][<?php echo $post_type ?>]' 
			   id = '<?php echo $post_type ?>'
			   <?php checked( isset($options['wooigp_checkbox_post_types'][$post_type]) ); ?> 
			   value='<?php echo $post_type ?> '> 
		<label for="<?php echo $post_type ?>"><b><?php echo ucwords($post_type) ?></b></label><br />
		<?php
		}
	}

	/**
	 * wooigp_posts_section_callback function.
	 *
	 * @access public
	 * @return void
	 */		
	function wooigp_settings_section_callback(  ) { 
		//echo __( 'Settings', 'wpigp' );
		echo '<h3 class="ws-table-title">' . __( 'Settings!', 'wpigp' ) . '</h3>';
	}

	/**
	 * wooigp_posts_section_callback function.
	 *
	 * @access public
	 * @return void
	 */		
	function wooigp_posts_section_callback(  ) { 
	
		echo '<h3 class="ws-table-title">' . __( 'Post Types for Instagram!', 'wpigp' ) . '</h3>';

	}

	/**
	 * wooigp_post_format_section_callback
	 *
	 * @access public
	 * @return void
	 */		
	function wooigp_post_format_section_callback(  ) { 
	
		echo '<h3 class="ws-table-title">' . __( 'Post Format for Instagram!', 'wpigp' ) . '</h3>';

	}

	/**
	 * socialize_post function.
	 *
	 * @access public
	 * @return void
	 */		
	public function wigp_instagram_post($post_id){
		$options = get_option( 'wooigp_settings' );
		if( get_post_status($post_id) == "publish" && isset($options['wooigp_checkbox_post_types'][get_post_type( $post_id )]) != '' ){
			$ig_post = metadata_exists('post', $post_id, '_wigp_ig') ? get_post_meta( $post_id, '_wigp_ig', true ) : 'checked';
			$ig_posted = metadata_exists('post', $post_id, '_wigp_ig_posted') ? get_post_meta( $post_id, '_wigp_ig_posted', true ) : '';
			//$options = get_option( 'wooigp_settings' );
			$repost = !$ig_posted ? true : $options['wooigp_checkbox_post_update'];

			if ( $ig_post && $repost ) {

				$time_delay = time() + 5;
				$args = array($post_id);
				wp_schedule_single_event( $time_delay, 'wigp_schedule_action', $args );
		
	      	} else return;
		} else return;
	}

	/**
	 * wigp_ig_post function.
	 *
	 * @access public
	 * @return void
	 */		
	public function wigp_ig_post($post_id){

		$getInstagramLogin = $this->wigp_get_inst();
		if( $getInstagramLogin['success'] ){
			
			$options = get_option( 'wooigp_settings' );
		
			if ( !isset ( $options['wooigp_number_show_words'] ) )
				$options['wooigp_number_show_words'] = 2000;
			
			$post_desc = strip_tags( wp_trim_words( get_post_field( 'post_content', $post_id ), $options['wooigp_number_show_words']) );
			
			$message = get_the_title($post_id);
			$message.= metadata_exists('post', $post_id, '_wigp_msg') ? " - ".get_post_meta( $post_id, '_wigp_msg', true ) : '';
			
			if( get_post_type( $post_id ) == "product" ){
			
				$_pf = new WC_Product_Factory();
				$_product = $_pf->get_product($post_id);

				if ( $options['wooigp_checkbox_post_tags'] ) {
					$tag_names = wp_get_post_terms( $post_id, 'product_tag', array( 'fields' => 'names' ) );
					$tag_names = str_replace(' ','',$tag_names);
					$message.= "\n" . '#' . implode(' #', $tag_names);
				}

				//$post_desc = strip_tags( get_post_field( 'post_content', $post_id ) );
				$curr_symb = get_woocommerce_currency_symbol();
				
				if ( $options['wooigp_checkbox_show_price'] ) {
					$message.= "\n" . __( 'Price: ', 'wpigp') 
							. html_entity_decode($curr_symb, ENT_COMPAT, "UTF-8") 
							. $_product->get_price() ;
				}		
			} else {

				if ( $options['wooigp_checkbox_post_tags'] ) {
					$tag_names = wp_get_post_tags( $post_id, array( 'fields' => 'names' ) );
					$tag_names = str_replace(' ','',$tag_names);
					$message.= "\n" . '#' . implode(' #', $tag_names);
				}

			}
			
			if ( $options['wooigp_number_show_words'] > 0 ) {
				$message.=  "\n" . $post_desc;
			}

			if ( $options['wooigp_checkbox_show_link'] ) {
				$message.= "\n" . __( 'Link: ', 'wpigp') 
						. get_permalink( $post_id );
			}
		
			$photoFilename = get_attached_file(get_post_thumbnail_id( $post_id ) );

			try {
				
				$message = strip_shortcodes(html_entity_decode($message, ENT_COMPAT, "UTF-8"));
			    
			    if ($photoFilename)
			    	$photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
    				$this->igp->timeline->uploadPhoto($photo->getFile(), ['caption' => $message]);
				
				update_post_meta ($post_id, '_wigp_ig_posted', 'checked' );
				update_post_meta ($post_id, '_wigp_ig', 'checked' );
      		} 
			catch (\Exception $e) {
				$options = get_option( 'wooigp_settings' );
				if ( $options['wooigp_checkbox_notifications'] ){
					$admin_email = get_option( 'admin_email' );
					if ( empty( $admin_email ) ) {
						$current_user = wp_get_current_user();
						$admin_email = $current_user->user_email;
					}
					
					$msg = __('Dear user,', 'wpigp') . "\r\n";
					$msg.= __('Your post ID ', 'wpigp') . $post_id . __(' not posted on Instragram due to following reason.', 'wpigp') . "\r\n";
					$msg.= $e->getMessage();
					
					wp_mail($admin_email, __('WP Instagram - Notification', 'wpigp'), $msg, $this->wigp_headers());
				}
				return false;
				//console.log($e->getType());
      		}
      	} else return;
	}

	/**
	 * wooigp_admin_menu function.
	 *
	 * @access public
	 * @return void
	 */		
	public function wooigp_admin_menu () {
		add_menu_page( 'WP Instagram', 'WP Instagram', 'manage_options', 'wpigp', '', $this->assets_url.'/instagram.png', 52 );
		$page_logins   = add_submenu_page( 'wpigp', 'Logins', 'Logins', 'manage_options', 'wpigp', array( $this, 'wooigp_logins_page' ) );
		$page_options  = add_submenu_page( 'wpigp', 'Options', 'Options', 'manage_options', 'wooigp_options', array( $this, 'wooigp_options' ) );
		add_action( 'admin_print_styles-' . $page_logins, array( $this, 'wooigp_admin_styles' ) );
		add_action( 'admin_print_styles-' . $page_options, array( $this, 'wooigp_admin_styles' ) );
	}

	/**
	 * wooigp_admin_styles function.
	 *
	 * @access public
	 * @return void
	 */			
	public function wooigp_admin_styles() {
       /*
        * It will be called only on plugin admin page, enqueue stylesheet here
        */
       wp_enqueue_style( 'wooigpStylesheet' );
       
   }

   public function guten_burg_script(){

		wp_enqueue_script( 'guten-js', $this->assets_url.'/gutenberg-sidebar-panel.js', false );

   }

	/**
	 * wooigp_logins_page function.
	 *
	 * @access public
	 * @return void
	 */		
	public function wooigp_logins_page () {
		
		$filepath = $this->plugin_path.'wpigp.logins.php';
		if (file_exists($filepath))
			include_once($filepath);
		else
			die('Could not load file '.$filepath);
	}


	/**
	 * creating email headers.
	 *
	 * @access public
	 */
	public function wigp_headers(){
		$admin_email = get_option( 'admin_email' );
		if ( empty( $admin_email ) ) {
			$admin_email = 'support@' . $_SERVER['SERVER_NAME'];
		}

		$from_name = get_option( 'blogname' );

		$header = "From: \"{$from_name}\" <{$admin_email}>\n";
		$header.= "MIME-Version: 1.0\r\n"; 
		$header.= "Content-Type: text/plain; charset=\"" . get_option( 'blog_charset' ) . "\"\n";
		$header.= "X-Priority: 1\r\n"; 

		return $header;
	}



	/**
	 * save Instagram username and password function.
	 *
	 * @access public
	 */
	public function wigp_save_user() {
		
		if ( $_POST['wigp_username'] != '' && $_POST['wigp_password'] != '' ) {
			$ig_user = sanitize_user( $_POST['wigp_username'] );

			update_option( 'wigp_username', $ig_user );
			update_option( 'wigp_password', $_POST['wigp_password'] );
			update_option( 'wigp_proxy', $_POST['wigp_proxy'] );
			_e( 'User info updated!', 'wpigp');
		}
		else
			_e( 'Empty Username or Password!', 'wpigp');
		
		die(0);
 	}

	/**
	 * finish Instagram verfication process by code.
	 *
	 * @access public
	 */
	public function wigp_submit_verification_code() {
		
		if ( $_POST['wigp_verificationcode'] != '' && $_POST['wigp_verificationcode'] != '' ) {
	    
			\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
	        $igpt = new \InstagramAPI\Instagram(false, false);

			$instaUsername = get_option( 'wigp_username');
			$instaPassword = get_option( 'wigp_password');

	        $verificationCode = trim($_POST['wigp_verificationcode']);
    	    $twoFactorIdentifier = get_option( '_wigp_twoFactorIdentifier' );
    	    $igpt->finishTwoFactorLogin($instaUsername, $instaPassword, $twoFactorIdentifier, $verificationCode);

			_e( 'User info updated!', 'wpigp');
		}
		else
			_e( 'Something went wrong! Try again.', 'wpigp');
		
		die(0);
 	}

	/**
	 * delete instagram user session
	 *
	 * @access public
	 */
	public function wigp_delete_user_session( $dir ) {

		$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new RecursiveIteratorIterator($it,
		             RecursiveIteratorIterator::CHILD_FIRST);
		foreach($files as $file) {
		    if ($file->isDir()){
		        rmdir($file->getRealPath());
		    } else {
		        unlink($file->getRealPath());
		    }
		}
		rmdir($dir);
	}

	/**
	 * delete instagram user
	 *
	 * @access public
	 */
	public function wigp_delete_user() {
		
		if (delete_option( 'wigp_username' ) ){
			delete_option( 'wigp_password' );
			delete_option( 'wigp_proxy' );

			$dir = $this->plugin_path.'vendor'.DIRECTORY_SEPARATOR.'mgp25'.DIRECTORY_SEPARATOR.'instagram-php'.DIRECTORY_SEPARATOR.'sessions';
			$this->wigp_delete_user_session($dir);
			
			_e( 'Deleted', 'wpigp');
		}
		else
		 	_e( 'Error deleting user! Please try later!', 'wpigp');	

		die(0);
 	}

	/**
	 * load_localisation function.
	 *
	 * @access public
	 * @return void
	 */
	public function load_localisation () {
		$lang_dir = trailingslashit( str_replace( 'classes', 'lang', plugin_basename( dirname(__FILE__) ) ) );
		load_plugin_textdomain( 'wpigp', false, $lang_dir );
	} // End load_localisation()

	/**
	 * activation function.
	 *
	 * @access public
	 * @return void
	 */
	public function activation () {
		$this->register_plugin_version();
	} // End activation()

	/**
	 * register_plugin_version function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_plugin_version () {
		if ( $this->version != '' ) {
			update_option( 'wpigp' . '-version', $this->version );
		}
	} // End register_plugin_version()
} // End Class
?>