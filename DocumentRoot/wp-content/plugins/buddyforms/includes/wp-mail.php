<?php

add_action( 'buddyforms_process_submission_end', 'mail_submission_trigger_sent' );
/**
 * Start the email notification process
 *
 * @param $args
 */
function mail_submission_trigger_sent( $args ) {
	global $form_slug, $buddyforms;

	if ( ! isset( $args['post_id'] ) ) {
		return;
	}

	$form_slug = $args['form_slug'];
	$post_id   = $args['post_id'];

	$post = get_post( $post_id );

	if ( isset( $buddyforms[ $form_slug ]['mail_submissions'] ) && is_array( $buddyforms[ $form_slug ]['mail_submissions'] ) ) {
		foreach ( $buddyforms[ $form_slug ]['mail_submissions'] as $notification ) {
			buddyforms_send_mail_submissions( $notification, $post );
		}
	}

}

/**
 *
 * Sent mail notifications for contact forms
 *
 * @param $notification
 * @param $post
 */
function buddyforms_send_mail_submissions( $notification, $post ) {
	global $form_slug, $buddyforms;

	$post_ID  = $post->ID;

	$author_id  = $post->post_author;
	$post_title = $post->post_title;
	$postperma  = get_permalink( $post_ID );
	$user_info  = get_userdata( $author_id );

	$usernameauth  = $user_info->user_login;
	$user_nicename = $user_info->user_nicename;

	$mail_notification_trigger = $notification;

	$user_email = isset( $_POST['user_email'] ) ? $_POST['user_email'] : $user_info->user_email;

	$mail_to = array();

	// Check the Sent mail to checkbox
	if ( isset( $mail_notification_trigger['mail_to'] ) ) {
		foreach ( $mail_notification_trigger['mail_to'] as $key => $mail_address ) {
			if ( $mail_address == 'submitter' ) {
				array_push( $mail_to, $user_email );
			}

			if ( $mail_address == 'admin' ) {
				array_push( $mail_to, get_option( 'admin_email' ) );
			}
		}
	}

	// Check if mail to addresses
	if ( isset( $mail_notification_trigger['mail_to_address'] ) ) {
		$mail_to_address = explode( ',', str_replace( ' ', '', $mail_notification_trigger['mail_to_address'] ) );
		foreach ( $mail_to_address as $mail_address ) {
			if ( ! empty( $mail_address ) ) {
				$mail_address = buddyforms_get_field_value_from_string( $mail_address, $post_ID, $form_slug );
				array_push( $mail_to, $mail_address );
			}
		}
	}

	// Check if CC
	$mail_to_cc = array();
	if ( isset( $mail_notification_trigger['mail_to_cc_address'] ) ) {
		$mail_to_address = explode( ',', str_replace( ' ', '', $mail_notification_trigger['mail_to_cc_address'] ) );
		foreach ( $mail_to_address as $key => $mail_address ) {
			if ( ! empty( $mail_address ) ) {
				$mail_address = buddyforms_get_field_value_from_string( $mail_address, $post_ID, $form_slug );
				array_push( $mail_to_cc, $mail_address );
			}
		}
	}

	// Check if BCC
	$mail_to_bcc = array();
	if ( isset( $mail_notification_trigger['mail_to_bcc_address'] ) ) {
		$mail_to_address = explode( ',', str_replace( ' ', '', $mail_notification_trigger['mail_to_bcc_address'] ) );
		foreach ( $mail_to_address as $key => $mail_address ) {
			if ( ! empty( $mail_address ) ) {
				$mail_address = buddyforms_get_field_value_from_string( $mail_address, $post_ID, $form_slug );
				array_push( $mail_to_bcc, $mail_address );
			}
		}
	}

	$first_name = isset( $_POST['user_first'] ) ? $_POST['user_first'] : $user_info->user_firstname;
	$last_name  = isset( $_POST['user_last'] ) ? $_POST['user_last'] : $user_info->user_lastname;

	$blog_title  = get_bloginfo( 'name' );
	$siteurl     = get_bloginfo( 'wpurl' );
	$siteurlhtml = "<a href='$siteurl' target='_blank' >$siteurl</a>";

	$subject = isset( $_POST['subject'] ) ? $_POST['subject'] : $mail_notification_trigger['mail_subject'];
	$subject = buddyforms_get_field_value_from_string( $subject, $post_ID, $form_slug );

	$from_name = isset( $mail_notification_trigger['mail_from_name'] ) ? $mail_notification_trigger['mail_from_name'] : 'blog_title';

	switch ( $from_name ) {
		case 'user_login':
			$from_name = $usernameauth;
			break;
		case 'user_first':
			$from_name = $first_name;
			break;
		case 'user_last':
			$from_name = $last_name;
			break;
		case 'user_first_last':
			$from_name = $first_name . ' ' . $last_name;
			break;
		case 'custom':
			$from_name = buddyforms_get_field_value_from_string( $mail_notification_trigger['mail_from_name_custom'], $post_ID, $form_slug );
			break;
		default:
			$from_name = $blog_title;
			break;
	}

	$from_email = isset( $mail_notification_trigger['mail_from'] ) ? $mail_notification_trigger['mail_from'] : 'admin';

	switch ( $from_email ) {
		case 'submitter':
			$from_email = $user_email;
			break;
		case 'admin':
			$from_email = get_option( 'admin_email' );
			break;
		case 'custom':
			$from_email = isset( $mail_notification_trigger['mail_from_custom'] ) ? $mail_notification_trigger['mail_from_custom'] : $from_email;
			$from_email = buddyforms_get_field_value_from_string( $from_email, $post_ID, $form_slug );
			break;
		default:
			$from_email = $user_email;
			break;
	}

	$emailBody = isset( $mail_notification_trigger['mail_body'] ) ? $mail_notification_trigger['mail_body'] : '';

	$post_link_html = ! empty( $postperma ) ? sprintf( '<a href="%s" target="_blank">%s</a>', $postperma , $postperma ) : '';

	$short_codes_and_values = array(
			'[user_login]' => $usernameauth,
			'[user_nicename]' => $user_nicename,
			'[user_email]' => $user_email,
			'[first_name]' => $first_name,
			'[last_name]' => $last_name,
			'[published_post_link_plain]' => $postperma,
			'[published_post_link_html]' => $post_link_html,
			'[published_post_title]' => $post_title,
			'[site_name]' => $blog_title,
			'[site_url]' => $siteurl,
			'[site_url_html]' => $siteurlhtml,
			'[form_elements_table]' => buddyforms_mail_notification_form_elements_as_table( $form_slug, $post ),
		);

	// If we have content let us check if there are any tags we need to replace with the correct values.
	if ( ! empty( $emailBody ) ) {
		$emailBody = stripslashes( $emailBody );
		$emailBody = buddyforms_get_field_value_from_string( $emailBody, $post_ID, $form_slug );

		foreach ( $short_codes_and_values as $shortcode => $short_code_value ) {
			$emailBody = buddyforms_replace_shortcode_for_value( $emailBody, $shortcode, $short_code_value );
		}
	} else {
		if ( isset( $buddyforms[ $form_slug ]['form_fields'] ) ) {
			$emailBody = $short_codes_and_values['[form_elements_table]'];
		}
	}

	$emailBody = nl2br( $emailBody );

	buddyforms_email($mail_to, $subject, $from_name, $from_email, $emailBody, $mail_to_cc, $mail_to_bcc);
}

/**
 * Prepare header and body to send and email with wp_email
 *
 * @since 2.2.8
 *
 * @param $mail_to
 * @param $subject
 * @param $from_name
 * @param $from_email
 * @param $email_body
 * @param array $mail_to_cc
 * @param array $mail_to_bcc
 */
function buddyforms_email($mail_to, $subject, $from_name, $from_email, $email_body, $mail_to_cc = array(), $mail_to_bcc = array()){
	// Create the email header
	$mail_header = "MIME-Version: 1.0\n";
	$mail_header .= "X-Priority: 1\n";
	$mail_header .= "Content-Type: text/html; charset=\"UTF-8\"\n";
	$mail_header .= "Content-Transfer-Encoding: 7bit\n\n";
	$mail_header .= "From: $from_name <$from_email>" . "\r\n";
	$message    = '<html><head></head><body>' . $email_body . '</body></html>';

	$mail_header .= buddyforms_email_prepare_cc_bcc($mail_to_cc);
	$mail_header .= buddyforms_email_prepare_cc_bcc($mail_to_bcc, 'bcc');

	// OK Let us sent the mail
	wp_mail( $mail_to, $subject, $message, $mail_header );
}

/**
 * Prepare the string header for Cc or Bcc form array of emails
 *
 * @since 2.2.8
 *
 * @param $email_array
 * @param string $type
 *
 * @return string
 */
function buddyforms_email_prepare_cc_bcc( $email_array, $type = 'cc' ) {
	$result = '';
	if ( ! empty( $email_array ) && is_array( $email_array ) ) {
		foreach ( $email_array as $email ) {
			$result .= sprintf( "%s: %s\r\n", $type, $email );
		}
	}

	return $result;
}

/**
 *
 *  Lets us check for post status change and sent notifications if on transition_post_status
 *
 * @param $new_status
 * @param $old_status
 * @param $post
 */
add_action( 'transition_post_status', 'buddyforms_transition_post_status', 10, 3 );
/**
 * @param $new_status
 * @param $old_status
 * @param $post
 */
function buddyforms_transition_post_status( $new_status, $old_status, $post ) {
	global $form_slug, $buddyforms;

    if ($new_status === $old_status) {
        return;
    }

	if ( empty( $form_slug ) ) {
		$form_slug = get_post_meta( $post->ID, '_bf_form_slug', true );
	}

	if ( empty( $form_slug ) ) {
		return;
	}

	if ( ! isset( $buddyforms[ $form_slug ]['mail_notification'][ $new_status ] ) ) {
		return;
	}

	buddyforms_send_post_status_change_notification( $post );

}

/**
 *
 * Create the mail content and sent it with wp_mail
 *
 * @param $post
 */
function buddyforms_send_post_status_change_notification( $post ) {
	global $form_slug, $buddyforms;

	if ( ! isset( $buddyforms[ $form_slug ] ) ) {
		return;
	}

	$post_ID  = $post->ID;

	$author_id  = $post->post_author;
	$post_title = $post->post_title;
	$postperma  = get_permalink( $post_ID );
	$user_info  = get_userdata( $author_id );

	$usernameauth  = $user_info->user_login;
	$user_nicename = $user_info->user_nicename;

	$post_status = get_post_status( $post_ID );

	$mail_notification_trigger = $buddyforms[ $form_slug ]['mail_notification'][ $post_status ];

	$user_email = $user_info->user_email;

	$mail_to = array();

	if ( isset( $mail_notification_trigger['mail_to'] ) ) {
		foreach ( $mail_notification_trigger['mail_to'] as $key => $mail_address ) {
			if ( $mail_address == 'author' ) {
				array_push( $mail_to, $user_email );
			}

			if ( $mail_address == 'admin' ) {
				array_push( $mail_to, get_option( 'admin_email' ) );
			}
		}
	}

	if ( isset( $mail_notification_trigger['mail_to_address'] ) ) {
		$mail_to_address = explode( ',', str_replace( ' ', '', $mail_notification_trigger['mail_to_address'] ) );
		foreach ( $mail_to_address as $mail_address ) {
			if ( ! empty( $mail_address ) ) {
				$mail_address = buddyforms_get_field_value_from_string( $mail_address, $post_ID, $form_slug );
				array_push( $mail_to, $mail_address );
			}
		}
	}

	$first_name = $user_info->user_firstname;
	$last_name  = $user_info->user_lastname;

	$blog_title  = get_bloginfo( 'name' );
	$siteurl     = get_bloginfo( 'wpurl' );
	$siteurlhtml = "<a href='$siteurl' target='_blank' >$siteurl</a>";

	$subject = isset( $_POST['subject'] ) ? $_POST['subject'] : $mail_notification_trigger['mail_subject'];
	$subject = buddyforms_get_field_value_from_string( $subject, $post_ID, $form_slug );
	$from_name  = buddyforms_get_field_value_from_string( $mail_notification_trigger['mail_from_name'], $post_ID, $form_slug );
	$from_email = buddyforms_get_field_value_from_string( $mail_notification_trigger['mail_from'], $post_ID, $form_slug );
	$emailBody  = $mail_notification_trigger['mail_body'];
	$emailBody  = stripslashes( $emailBody );

	$post_link_html = "<a href='$postperma' target='_blank'>$postperma</a>";

	$short_codes_and_values = array(
		'[user_login]' => $usernameauth,
		'[user_nicename]' => $user_nicename,
		'[user_email]' => $user_email,
		'[first_name]' => $first_name,
		'[last_name]' => $last_name,
		'[published_post_link_plain]' => $postperma,
		'[published_post_link_html]' => $post_link_html,
		'[published_post_title]' => $post_title,
		'[site_name]' => $blog_title,
		'[site_url]' => $siteurl,
		'[site_url_html]' => $siteurlhtml,
		'[form_elements_table]' => buddyforms_mail_notification_form_elements_as_table( $form_slug, $post ),
	);

	// If we have content let us check if there are any tags we need to replace with the correct values.
	if ( ! empty( $emailBody ) ) {
		$emailBody = stripslashes( $emailBody );
		$emailBody = buddyforms_get_field_value_from_string( $emailBody, $post_ID, $form_slug );

		foreach ( $short_codes_and_values as $shortcode => $short_code_value ) {
			$emailBody = buddyforms_replace_shortcode_for_value( $emailBody, $shortcode, $short_code_value );
		}
	} else {
		if ( isset( $buddyforms[ $form_slug ]['form_fields'] ) ) {
			$emailBody = $short_codes_and_values['[form_elements_table]'];
		}
	}

	$emailBody = nl2br( $emailBody );

 	buddyforms_email($mail_to, $subject, $from_name, $from_email, $emailBody);
}


/**
 * @param $form_slug
 * @param $post
 *
 * @return string
 */
function buddyforms_mail_notification_form_elements_as_table( $form_slug, $post ) {
	global $buddyforms;
	$striped_c = 0;

	// Table start
	$message = '<table rules="all" style="border-color: #666;" cellpadding="10">';
	// Loop all form elements and add as table row
	foreach ( $buddyforms[ $form_slug ]['form_fields'] as $key => $field ) {
		$striped = ( $striped_c ++ % 2 == 1 ) ? "style='background: #eee;'" : '';
		// Check if the form element exist and have is not empty.
		$message .= "<tr " . $striped . "><td><strong>" . $field['name'] . "</strong> </td><td>[" . $field['slug'] . "]</td></tr>";
	}
	// Table end
	$message .= "</table>";

	//Convert all field shortcode into field values
	$message = buddyforms_get_field_value_from_string( $message, $post->ID, $form_slug );

	// Let us return the form elements table
	return $message;
}
