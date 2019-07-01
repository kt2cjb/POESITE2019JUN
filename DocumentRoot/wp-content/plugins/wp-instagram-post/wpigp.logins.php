<?php
global $wpigp, $is_IE;
$getInstagramLogin = $wpigp->wigp_get_inst(true);
?>
<!doctype html>
<html>
  <head>
    <title><?php _e( 'WP Instagram Logins', 'wpigp' ) ?></title>
</head>
<body>
<div class="woosocio_wrap">
  <h1><?php _e( 'WP Instagram Logins', 'wpigp' ) ?></h1>
  <p>
  <?php _e( 'Connect your site to Instagram and automatically share posts with your friends.', 'wpigp' ) ?>
  </p>
  <?php 
	if ($is_IE){
	  echo "<p style='font-size:18px; color:#F00;'>" . __( 'Important Notice:', 'wpigp') . "</p>";
	  echo "<p style='font-size:16px; color:#F00;'>" . 
	  		__( 'You are using Internet Explorer. This plugin may not work properly with IE. Please use any other browser.', 'wpigp') . "</p>";
	  echo "<p style='font-size:16px; color:#F00;'>" . __( 'Recommended: Google Chrome.', 'wpigp') . "</p>";
	}
  ?>
  
  <div id="woosocio-services-block">
	<a href="http://genialsouls.com/product/wp-instagram-post-and-widget-pro/" target="_top">
  <img src="<?php echo $wpigp->assets_url.'/wpigp_cs.jpg' ?>" alt="WP Instagram Post Pro" width="560"></a>

  <!-- <img src="<?php //echo $wpigp->assets_url.'/instagram-logo.png' ?>" alt="Instagram Logo"> -->
    <div class="woosocio-service-entry" >
		<div id="twitter" class="woosocio-service-left">
			<a href="https://www.instagram.com" id="service-link-facebook" target="_top">Instagram</a>
		</div>
		<div class="woosocio-service-right">
           	<div id="app-info">
            <table class="form-table">
            <tr valign="top">
	  			<th scope="row"><label><?php _e('Username:', 'wpigp') ?></label></th>
	  			<td>
	  				<input type="text" name="wigp_username" id="wigp-username" placeholder="<?php _e('Instagram Username', 'wpigp') ?>" value="<?php echo get_option( 'wigp_username' ); ?>" size="55" maxlength="128"><br>
                    <p style="font-size:12px"><?php _e("Don't have an Instagram account? You can create from ", 'wpigp') ?>
                    <a href="https://www.instagram.com/" target="_new" style="font-size:12px">https://www.instagram.com</a>
	  			</td>
	  		</tr>
            <tr valign="top">
          <th scope="row"><label><?php _e('Password:', 'wpigp') ?></label></th>
          <td>
            <input type="password" name="wigp_password" id="wigp-password" placeholder="<?php _e('Instagram Password', 'wpigp') ?>" value="<?php echo get_option( 'wigp_password' ); ?>" size="55" maxlength="128">
          </td>
        </tr>
        <tr valign="top">
          <th scope="row"><label><?php _e('Proxy', 'wpigp'); _e(' ( optional ):', 'wpigp') ?></label></th>
          <td>
            <input type="text" name="wigp_proxy" id="wigp-proxy" placeholder="https://user:pass@proxyserver:port" value="<?php echo get_option( 'wigp_proxy' ); ?>" size="55" maxlength="128">
            <span class='description'>https://proxyserver:port</span><br>            
            <a href="https://www.highproxies.com/billing/aff.php?aff=482&gid=5" target="_new" style="font-size:14px"><?php _e('Try Instagram Proxies:', 'wpigp') ?></a>
          </td>
        </tr>
        
        <!-- Two Factor -->
        <?php if ( $getInstagramLogin['success'] == 2 ) { ?>
        <tr valign="top">
          <th scope="row"><label style="color:red"><?php _e('Code:', 'wpigp'); ?></label></th>
          <td>
            <input type="text" name="wigp_verificationcode" id="wigp-verificationcode" size="55" maxlength="6">
            <span class='description'><?php _e('Instagram verification code!', 'wpigp'); ?></span>
          </td>
          <td>
            <a id="wigp-btn-submit-code" class="button-primary button" href="javascript:"><?php _e('Submit', 'wpigp') ?></a>
            <span id="working_code" class="spinner is-active" style="display: none;"></span>
          </td>
        </tr>
        <?php } ?>
        <!-- Two Factor -->

        <tr valign="top">
            <th scope="row"></th>
          <td>
                  <div id="publishing-action">
                  <span id="save-user-msg"></span>
                  <span id="working" class="spinner is-active" style="display: none;"></span>
                  <a id="wigp-btn-save" class="button-primary button" href="javascript:"><?php _e('Connect', 'wpigp') ?></a>
                  </div>
          </td>
        </tr>

            </table>
            
            </div>
		</div>
	</div>

<?php  

    echo '<table class="wp-list-table widefat fixed ws-table-css">';
    echo '<tbody>';
    echo '<h3 class="ws-table-title">' . __( 'Instagram User!', 'wpigp' ) . '</h3>';


  if ( get_option( 'wigp_username' ) ) {
    $insta_user = get_option( 'wigp_username' ); 
    echo '<tr>';
    echo '<td>';
      echo $insta_user;
    echo '</td>';
    
    echo '<td>';
      if ( get_option( 'wigp_proxy' ) )
        echo get_option( 'wigp_proxy' );
    echo '</td>';

    echo '<td>';
      echo '<a data-value="'.$insta_user.'" title="'.__( 'Delete User!', 'wpigp').'" class="wigp_delete_user" href="javascript:;"><span class="dashicons dashicons-trash" style="color: #d01000;"></span></a>';
    echo '</td>';

    echo '<td>';
    echo '<span id="'.$insta_user.'" class="spinner is-active" style="display: none;"></span>';
    echo '</td>';
    
    echo '</tr>';

    /*
     ******* Connection ********
     */
    
    if ( $getInstagramLogin['success'] == 1 ){
      $user_details = $wpigp->igp->people->getInfoByName($insta_user);
      $user_details = json_decode($user_details);

      echo '<tr>';
      echo '<td> UserID:</td>
            <td>'.$user_details->user->pk.'</td>
            <td> <span class="dashicons dashicons-yes" title="'.__( 'Connected', 'wpigp').'" style="color:green;font-size: 200%"></span> </td>
            <td> </td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td>'.__( 'Full Name:', 'wpigp').'</td>
            <td>'.$user_details->user->full_name.'</td>
            <td> </td>
            <td> </td>';
      echo '</tr>';

    } else { 
      
      echo '<tr>';
      echo "<td>".__( 'Response:', 'wpigp')."</td>
            <td><span style=\"color:red\">" .$getInstagramLogin['msg']. "</span></td>
            <td></td>
            <td></td>";
      echo '</tr>';
    }

  } else {
      echo '<tr>';
      echo '<td>';
        echo '<span class="dashicons dashicons-no-alt" title="No" style="color:#a20404;font-size: 200%"></span>';
        echo "<span style=\"color:red\">    ".__('No Instagram user added.', 'wpigp')."</span>";
      echo '</td>';
      echo '</tr>';
  }
    echo '</tbody>';
    echo '</table>';
?>

	<!-- Video tutorial   
	<div class="woosocio-service-entry">    

	</div>
    -->
    <h3 class="ws-table-title"><?php _e( 'Required Server Extensions!', 'wpigp' ) ?> </h3>
    <div class="woosocio-service-entry" style="font-size:18px; color:#03D">
    <?php 
      include_once 'wpigp.extensions.php';
    ?>
    </div>
    
    <h3 class="ws-table-title"><?php _e( 'You May Also Like!', 'wpigp' ) ?> </h3>    
    
    <div class="woosocio-service-entry" style="font-size:18px; color:#03D">
        <div class="woosocio-service-left">
            <a href="https://wordpress.org/plugins/gs-facebook-comments/" target="_top">
            <img src="<?php echo $wpigp->assets_url.'/wpfc_icon.jpg' ?>" alt="WP Facebook Comments/" height="128">
            </a>
        </div>
        <div class="woosocio-service-right">
            <div align="left">
            <?php
        echo '<a href="https://wordpress.org/plugins/gs-facebook-comments/" target="_top">'.__('* WP Facebook Comments *', 'wpigp').'</a></br>';
        _e('* Add Facebook comments at your site.', 'wpigp'); echo "</br>";
        _e('* Share comments on Facebook.', 'wpigp'); echo "</br>";
        _e('* Add Facebook comments on all types of posts.', 'wpigp'); echo "</br>";
        _e('* Customize comments box.', 'wpigp'); echo "</br>";
        _e('* Ability to moderation of comments.', 'wpigp'); echo "</br>";
        _e('* And many more...', 'wpigp'); echo "</br>";
            ?>
            </div>
        </div>
    </div>
    <div class="woosocio-service-entry" style="font-size:18px; color:#03D">
        <div class="woosocio-service-left">
            <a href="https://wordpress.org/plugins/woosocio/" target="_top">
            <img src="<?php echo $wpigp->assets_url.'/woosocio_icon.jpg' ?>" alt="WooSocio Free" height="128">
            </a>
        </div>
        <div class="woosocio-service-right">
            <div align="left">
            <?php
				echo '<a href="https://wordpress.org/plugins/woosocio/" target="_top">'.__('* WooSocio Free version *', 'wpigp').'</a></br>';
				_e('* Post product to Facebook, pages and groups', 'wpigp'); echo "</br>";
				_e('* post to groups you dont manage', 'wpigp'); echo "</br>";
				_e('* Add widget for Facebook like box', 'wpigp'); echo "</br>";
				_e('* Multi user ready', 'wpigp'); echo "</br>";
				_e('* Post as image or link', 'wpigp'); echo "</br>";
				_e('* And many more...', 'wpigp'); echo "</br>";
            ?>
            </div>
        </div>
    </div>

    <div class="woosocio-service-entry" style="font-size:18px; color:#03C">
        <div class="woosocio-service-left">
            <a href="https://wordpress.org/plugins/wootweet/" target="_top">
            <img src="<?php echo $wpigp->assets_url.'/wootweet_icon.jpg' ?>" alt="WooTweet">
            </a>
        </div>
        <div class="woosocio-service-right">
            <div align="left">
            <?php
                echo '<a href="https://wordpress.org/plugins/wootweet/" target="_top">'.__('* WooTweet Free *', 'wpigp').'</a>';
                echo "</br></br>";
                _e('* Post product to Twitter', 'wpigp'); echo "</br>";
                _e('* Post products multiple times(on every update)', 'wpigp'); echo "</br>";
                _e('* Add Tweet Widget for latest Tweets', 'wpigp'); echo "</br>";
                _e('* And many more to come...', 'wpigp'); echo "</br>";
            ?>
            </div>
        </div>
    </div>

  </div>
    <!-- Right Area Widgets -->  
    <?php 
		include_once 'right_area.php';
	 ?>
    <!-- Right Area Widgets -->  
</div>
  </body>
</html>
<script type="text/javascript"><!--
jQuery(document).ready(function($){
		
  $("#wigp-btn-save").click(function(){
    $("#working").show();
    $("#save-user-msg").html('');
    $("#save-user-msg").fadeIn();

    var data = {
      action: 'wigp_save_user',
      wigp_username: $("#wigp-username").val(),
      wigp_password: $("#wigp-password").val(),
      wigp_proxy: $("#wigp-proxy").val(),
    };
    
    $.post(ajaxurl, data, function(response) {
      //console.log('Got this from the server: ' + response);
      $("#save-user-msg").html(response);
      $("#save-user-msg").fadeOut(7000);
      $("#working").hide();
      location.reload();
    }); 
    
  });

  $("#wigp-btn-submit-code").click(function(){
    $("#working_code").show();

    var data = {
      action: 'wigp_submit_verification_code',
      wigp_verificationcode: $("#wigp-verificationcode").val(),
    };
    
    $.post(ajaxurl, data, function(response) {
      console.log('Got this from the server: ' + response);
      // $("#working_code").hide();
      location.reload();
    }); 
    
  });

  $(".wigp_delete_user").click(function(){
    var working_img;
    working_img = $("#"+$(this).data('value'));
    working_img.show();

    var data = {
      action: 'wigp_delete_user',
      insta_user: $(this).data('value'),
    };

    $.post(ajaxurl, data, function(response) {
      console.log('Got this from the server: ' + response);
      if (response=='Deleted') {
        location.reload();
      } else {
        working_img.hide();
        alert(response);
      };
    });   
  });

});
//-->
</script>