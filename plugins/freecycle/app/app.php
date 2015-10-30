<?php

/**
 * freecycle/app/app.php
 *
 * Functions called from the smartphone app.
 */

add_action('wp_ajax_nopriv_echo_signup_fields_json', 'echo_signup_fields_json_from_app');
add_action('wp_ajax_nopriv_get_nonce_from_app', 'get_nonce_from_app');
add_action('wp_ajax_nopriv_signup_from_app', 'signup_from_app');


/**
 * ユーザ登録フォームの一覧をjson形式でechoします。
 * ajaxの直接のコール先です。
 */

function echo_signup_fields_json_from_app(){
	echo get_signup_fields_json();
	die;
}


/**
 * ユーザ登録に必要なフィールドをJSON形式で返します。
 * @return {string} フィールド情報のJSON
 */
function get_signup_fields_json(){
	$fs = [];
	$f;
	if(bp_has_profile(array('profile_group_id'=>1, 'fetch_field_data'=>false))){
		while(bp_profile_groups()){
			bp_the_profile_group();
			while(bp_profile_fields()){
				bp_the_profile_field();
				$f = array(
					"type" => bp_get_the_profile_field_type(),
					"input_name" => bp_get_the_profile_field_input_name(),
					"name" => bp_get_the_profile_field_name(),
					"id" => bp_get_the_profile_field_id(),
					"is_required" => bp_get_the_profile_field_is_required()
				);

				// セレクトボックス、ラジオボタンの場合、選択肢を配列にして追加する
				if($f["type"] === "selectbox" || $f["type"] === "radio"){
					$temp_f = new BP_XProfile_Field(bp_get_the_profile_field_id());
					$f["options"] = $temp_f->get_children();
				}

				array_push($fs, $f);
			}
		}
	}
	return json_encode($fs);
}

/**
 * 認証用のnonceを取得します。
 */

function get_nonce_from_app(){
	$action = isset($_REQUEST["nonce_action"])?$_REQUEST["nonce_action"]:"";
	echo wp_create_nonce($action);
	die;
}

/**
 * スマホアプリからAjaxを介してユーザ登録関数を叩きます。
 */

function signup_from_app(){
	global $bp;
	$bp->current_component = "register"; // コールするコンポーネントをregisterに設定
	fc_core_screen_signup();
	if(!empty($bp->signup->errors)){
		echo json_encode(["errors"=>$bp->signup->errors]);
	}else{
		echo '{"msg":"入力したメールアドレスに、登録完了用URLをお送りしました。リンクをクリックして登録処理を完了させてください！"}';
	}
	die;
}

/**
 * 新規ユーザ登録の標準処理を行います。
 * bp_core_screen_signup 関数のほぼコピーです。
 * 元の関数は、処理の最後に bp_core_load_template して register 画面を読み込んでいますが、
 * すべて Ajax で処理をしたいので、そこだけ削除しています。
 */
function fc_core_screen_signup() {
	global $bp;

	if ( !bp_is_current_component( 'register' ) )
		return;

	// Not a directory
	bp_update_is_directory( false, 'register' );

	// If the user is logged in, redirect away from here
	if ( is_user_logged_in() ) {
		if ( bp_is_component_front_page( 'register' ) )
			$redirect_to = trailingslashit( bp_get_root_domain() . '/' . bp_get_members_root_slug() );
		else
			$redirect_to = bp_get_root_domain();

		bp_core_redirect( apply_filters( 'bp_loggedin_register_page_redirect_to', $redirect_to ) );

		return;
	}

	if ( !isset( $bp->signup ) ) {
		$bp->signup = new stdClass;
	}

	$bp->signup->step = 'request-details';

 	if ( !bp_get_signup_allowed() ) {
		$bp->signup->step = 'registration-disabled';
	// If the signup page is submitted, validate and save
	} elseif ( isset( $_POST['signup_submit'] ) && bp_verify_nonce_request( 'bp_new_signup' ) ) {

		// Check the base account details for problems
		$account_details = bp_core_validate_user_signup( $_POST['signup_username'], $_POST['signup_email'] );

		// If there are errors with account details, set them for display
		if ( !empty( $account_details['errors']->errors['user_name'] ) )
			$bp->signup->errors['signup_username'] = $account_details['errors']->errors['user_name'][0];

		if ( !empty( $account_details['errors']->errors['user_email'] ) )
			$bp->signup->errors['signup_email'] = $account_details['errors']->errors['user_email'][0];

		// Check that both password fields are filled in
		if ( empty( $_POST['signup_password'] ) || empty( $_POST['signup_password_confirm'] ) )
			$bp->signup->errors['signup_password'] = __( 'Please make sure you enter your password twice', 'buddypress' );

		// Check that the passwords match
		if ( ( !empty( $_POST['signup_password'] ) && !empty( $_POST['signup_password_confirm'] ) ) && $_POST['signup_password'] != $_POST['signup_password_confirm'] )
			$bp->signup->errors['signup_password'] = __( 'The passwords you entered do not match.', 'buddypress' );

		$bp->signup->username = $_POST['signup_username'];
		$bp->signup->email = $_POST['signup_email'];

		// Now we've checked account details, we can check profile information
		if ( bp_is_active( 'xprofile' ) ) {

			// Make sure hidden field is passed and populated
			if ( isset( $_POST['signup_profile_field_ids'] ) && !empty( $_POST['signup_profile_field_ids'] ) ) {

				// Let's compact any profile field info into an array
				$profile_field_ids = explode( ',', $_POST['signup_profile_field_ids'] );

				// Loop through the posted fields formatting any datebox values then validate the field
				foreach ( (array) $profile_field_ids as $field_id ) {
					if ( !isset( $_POST['field_' . $field_id] ) ) {
						if ( !empty( $_POST['field_' . $field_id . '_day'] ) && !empty( $_POST['field_' . $field_id . '_month'] ) && !empty( $_POST['field_' . $field_id . '_year'] ) )
							$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $_POST['field_' . $field_id . '_day'] . $_POST['field_' . $field_id . '_month'] . $_POST['field_' . $field_id . '_year'] ) );
					}

					// Create errors for required fields without values
					if ( xprofile_check_is_required_field( $field_id ) && empty( $_POST['field_' . $field_id] ) )
						$bp->signup->errors['field_' . $field_id] = __( 'This is a required field', 'buddypress' );
				}

			// This situation doesn't naturally occur so bounce to website root
			} else {
				bp_core_redirect( bp_get_root_domain() );
			}
		}

		// Finally, let's check the blog details, if the user wants a blog and blog creation is enabled
		if ( isset( $_POST['signup_with_blog'] ) ) {
			$active_signup = $bp->site_options['registration'];

			if ( 'blog' == $active_signup || 'all' == $active_signup ) {
				$blog_details = bp_core_validate_blog_signup( $_POST['signup_blog_url'], $_POST['signup_blog_title'] );

				// If there are errors with blog details, set them for display
				if ( !empty( $blog_details['errors']->errors['blogname'] ) )
					$bp->signup->errors['signup_blog_url'] = $blog_details['errors']->errors['blogname'][0];

				if ( !empty( $blog_details['errors']->errors['blog_title'] ) )
					$bp->signup->errors['signup_blog_title'] = $blog_details['errors']->errors['blog_title'][0];
			}
		}

		do_action( 'bp_signup_validate' );

		// Add any errors to the action for the field in the template for display.
		if ( !empty( $bp->signup->errors ) ) {
			foreach ( (array) $bp->signup->errors as $fieldname => $error_message ) {
				// addslashes() and stripslashes() to avoid create_function()
				// syntax errors when the $error_message contains quotes
				add_action( 'bp_' . $fieldname . '_errors', create_function( '', 'echo apply_filters(\'bp_members_signup_error_message\', "<div class=\"error\">" . stripslashes( \'' . addslashes( $error_message ) . '\' ) . "</div>" );' ) );
			}
		} else {
			$bp->signup->step = 'save-details';

			// No errors! Let's register those deets.
			$active_signup = !empty( $bp->site_options['registration'] ) ? $bp->site_options['registration'] : '';

			if ( 'none' != $active_signup ) {

				// Make sure the extended profiles module is enabled
				if ( bp_is_active( 'xprofile' ) ) {
					// Let's compact any profile field info into usermeta
					$profile_field_ids = explode( ',', $_POST['signup_profile_field_ids'] );

					// Loop through the posted fields formatting any datebox values then add to usermeta - @todo This logic should be shared with the same in xprofile_screen_edit_profile()
					foreach ( (array) $profile_field_ids as $field_id ) {
						if ( ! isset( $_POST['field_' . $field_id] ) ) {

							if ( ! empty( $_POST['field_' . $field_id . '_day'] ) && ! empty( $_POST['field_' . $field_id . '_month'] ) && ! empty( $_POST['field_' . $field_id . '_year'] ) ) {
								// Concatenate the values
								$date_value = $_POST['field_' . $field_id . '_day'] . ' ' . $_POST['field_' . $field_id . '_month'] . ' ' . $_POST['field_' . $field_id . '_year'];

								// Turn the concatenated value into a timestamp
								$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $date_value ) );
							}
						}

						if ( !empty( $_POST['field_' . $field_id] ) )
							$usermeta['field_' . $field_id] = $_POST['field_' . $field_id];

						if ( !empty( $_POST['field_' . $field_id . '_visibility'] ) )
							$usermeta['field_' . $field_id . '_visibility'] = $_POST['field_' . $field_id . '_visibility'];
					}

					// Store the profile field ID's in usermeta
					$usermeta['profile_field_ids'] = $_POST['signup_profile_field_ids'];
				}

				// Hash and store the password
				$usermeta['password'] = wp_hash_password( $_POST['signup_password'] );

				// If the user decided to create a blog, save those details to usermeta
				if ( 'blog' == $active_signup || 'all' == $active_signup )
					$usermeta['public'] = ( isset( $_POST['signup_blog_privacy'] ) && 'public' == $_POST['signup_blog_privacy'] ) ? true : false;

				$usermeta = apply_filters( 'bp_signup_usermeta', $usermeta );

				// Finally, sign up the user and/or blog
				if ( isset( $_POST['signup_with_blog'] ) && is_multisite() )
					$wp_user_id = bp_core_signup_blog( $blog_details['domain'], $blog_details['path'], $blog_details['blog_title'], $_POST['signup_username'], $_POST['signup_email'], $usermeta );
				else
					$wp_user_id = bp_core_signup_user( $_POST['signup_username'], $_POST['signup_password'], $_POST['signup_email'], $usermeta );

				if ( is_wp_error( $wp_user_id ) ) {
					$bp->signup->step = 'request-details';
					bp_core_add_message( $wp_user_id->get_error_message(), 'error' );
				} else {
					$bp->signup->step = 'completed-confirmation';
				}
			}

			do_action( 'bp_complete_signup' );
		}

	}

	do_action( 'bp_core_screen_signup' );
}
?>